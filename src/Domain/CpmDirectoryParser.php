<?php

class CpmDirectoryParser
{
    /**
     * Parse le répertoire CP/M depuis les secteurs de la piste 0.
     *
     * @param  array $rawSectors  Tous les secteurs bruts du disque
     * @return array              Liste de fichiers CP/M trouvés
     */
    public function parse(array $rawSectors): array
    {
        $dirData = $this->extractTrack0Data($rawSectors);
        if (strlen($dirData) < 32) return [];

        $extents = $this->readExtents($dirData);
        return $this->mergeExtents($extents);
    }

    // ----------------------------------------------------------------
    // Privé
    // ----------------------------------------------------------------

    private function extractTrack0Data(array $rawSectors): string
    {
        $data = '';
        foreach ($rawSectors as $s) {
            if ($s['track'] === 0) {
                $data .= $s['data'];
            }
        }
        return $data;
    }

    private function readExtents(string $dirData): array
    {
        $extents = [];
        $total   = intdiv(strlen($dirData), 32);

        for ($i = 0; $i < $total; $i++) {
            $entry = substr($dirData, $i * 32, 32);
            $user  = ord($entry[0]);

            if ($user === 0xE5 || $user > 15) continue;

            $name = '';
            for ($c = 1; $c <= 8; $c++) {
                $name .= chr(ord($entry[$c]) & 0x7F);
            }
            $name = rtrim($name);

            $ext = '';
            for ($c = 9; $c <= 11; $c++) {
                $ext .= chr(ord($entry[$c]) & 0x7F);
            }
            $ext = rtrim($ext);

            $extents[] = [
                'user'     => $user,
                'name'     => $name,
                'ext'      => $ext,
                'readonly' => (bool)(ord($entry[9])  & 0x80),
                'hidden'   => (bool)(ord($entry[10]) & 0x80),
                'extent'   => ord($entry[12]) | (ord($entry[14]) << 5),
                'rc'       => ord($entry[15]),
            ];
        }

        return $extents;
    }

    private function mergeExtents(array $extents): array
    {
        $seen = [];

        foreach ($extents as $e) {
            $key = $e['user'] . '/' . $e['name'] . '.' . $e['ext'];

            if (!isset($seen[$key])) {
                $seen[$key] = [
                    'user'     => $e['user'],
                    'name'     => $e['name'],
                    'ext'      => $e['ext'],
                    'readonly' => $e['readonly'],
                    'hidden'   => $e['hidden'],
                    'rc'       => 0,
                    'track'    => 0,
                    'sector'   => '#C1',
                ];
            }

            $seen[$key]['rc'] += $e['rc'];

            // Les attributs de l'extent 0 font foi
            if ($e['extent'] === 0) {
                $seen[$key]['readonly'] = $e['readonly'];
                $seen[$key]['hidden']   = $e['hidden'];
            }
        }

        $files = [];
        foreach ($seen as $e) {
            $files[] = [
                'user'     => $e['user'],
                'name'     => $e['name'],
                'ext'      => $e['ext'],
                'readonly' => $e['readonly'],
                'hidden'   => $e['hidden'],
                'sizeKo'   => (int)ceil($e['rc'] * 128 / 1024),
                'track'    => $e['track'],
                'sector'   => $e['sector'],
            ];
        }

        return $files;
    }
}
