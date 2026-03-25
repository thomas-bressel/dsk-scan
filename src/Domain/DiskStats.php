<?php

class DiskStats
{
    /**
     * Calcule toutes les métriques agrégées à partir des données brutes du parser.
     *
     * @param  array $raw  Résultat de DskParser::parse()
     * @return array       Tableau complet prêt pour les vues
     */
    public function compute(array $raw): array
    {
        $sectors = $raw['rawSectors'];
        $tracks  = $raw['tracks'];

        $totalSectors      = count($sectors);
        $usedSectors       = 0;
        $weakSectors       = 0;
        $erasedSectors     = 0;
        $incompleteSectors = 0;
        $totalWeakSectors  = 0;
        $sizeCounts        = array_fill(0, 10, 0); // index 0-8 = taille N, index 9 = N>8
        $totalDeclaredBytes = 0;
        $totalRealBytes     = 0;
        $totalSumData       = 0;

        foreach ($sectors as $s) {
            if ($s['isUsed'])       $usedSectors++;
            if ($s['isWeak'])     { $weakSectors++; $totalWeakSectors++; }
            if ($s['isErased'])     $erasedSectors++;
            if ($s['isWeak'] && $s['isErased']) $totalWeakSectors++; // comptés double
            if ($s['isIncomplete']) $incompleteSectors++;

            $n = $s['N'] <= 8 ? $s['N'] : 9;
            $sizeCounts[$n]++;

            $totalDeclaredBytes += $s['declSize'];
            $totalRealBytes     += $s['realSize'];
            $totalSumData       += $s['sumData'];
        }

        // Taille totale déclarée des pistes (table d'offset du header)
        $tracksDeclaredSize = array_sum(array_filter($raw['trackSizes']));

        // Stats MAP précalculées (évite du PHP dans le template)
        $mapStats = $this->computeMapStats($sectors);

        // Stats par piste (taille totale, secteurs)
        $tracksData = $this->computeTracksData($tracks);

        return [
            // Identité du disque
            'path'               => $raw['path'],
            'fileSize'           => $raw['fileSize'],
            'format'             => $raw['header']['format'],
            'creator'            => $raw['header']['creator'],
            'nbTracks'           => $raw['header']['nbTracks'],
            'nbSides'            => $raw['header']['nbSides'],

            // Données brutes pour les onglets
            'tracks'             => $tracksData,
            'sectors'            => $sectors,
            'files'              => $raw['files'] ?? [],

            // Stats globales
            'totalSectors'       => $totalSectors,
            'usedSectors'        => $usedSectors,
            'weakSectors'        => $weakSectors,
            'erasedSectors'      => $erasedSectors,
            'incompleteSectors'  => $incompleteSectors,
            'totalWeakSectors'   => $totalWeakSectors,
            'sizeCounts'         => $sizeCounts,
            'totalDeclaredBytes' => $totalDeclaredBytes,
            'totalRealBytes'     => $totalRealBytes,
            'totalSumData'       => $totalSumData,
            'tracksDeclaredSize' => $tracksDeclaredSize,

            // Stats pour l'onglet MAP
            'mapStats'           => $mapStats,
        ];
    }

    // ----------------------------------------------------------------
    // Privé
    // ----------------------------------------------------------------

    private function computeMapStats(array $sectors): array
    {
        $sizeCounts  = array_fill(0, 10, 0);
        $erased      = 0;
        $weak        = 0;
        $weakTotal   = 0;
        $incomplete  = 0;

        foreach ($sectors as $s) {
            $n = $s['N'] <= 8 ? $s['N'] : 9;
            $sizeCounts[$n]++;
            if ($s['isErased'])   $erased++;
            if ($s['isWeak'])   { $weak++; $weakTotal++; }
            if ($s['isWeak'] && $s['isErased']) $weakTotal++;
            if ($s['isIncomplete']) $incomplete++;
        }

        return [
            'sizeCounts' => $sizeCounts,
            'erased'     => $erased,
            'weak'       => $weak,
            'weakTotal'  => $weakTotal,
            'incomplete' => $incomplete,
            'gaps'       => 0,
            'gap2'       => 0,
        ];
    }

    private function computeTracksData(array $tracks): array
    {
        $result = [];
        foreach ($tracks as $t) {
            $totalBytes = 0;
            foreach ($t['sectorInfos'] as $si) {
                $totalBytes += 128 << $si['N'];
            }

            $result[] = [
                'num'        => $t['num'],
                'side'       => $t['side'],
                'spt'        => $t['spt'],
                'gap'        => $t['gap'],
                'filler'     => $t['filler'],
                'totalBytes' => $totalBytes,
                'sumData'    => array_sum(array_column($t['sectors'], 'sumData')),
            ];
        }
        return $result;
    }
}
