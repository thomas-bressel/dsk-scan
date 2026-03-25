<?php

class UploadService
{
    /**
     * Valide et déplace le fichier uploadé.
     *
     * @return array{success: bool, path: string, originalName: string, error: string}
     */
    public function handle(array $fileInput): array
    {
        $result = ['success' => false, 'path' => '', 'originalName' => '', 'error' => ''];

        if (!isset($fileInput['error']) || $fileInput['error'] !== UPLOAD_ERR_OK) {
            $result['error'] = 'Erreur lors de l\'upload du fichier.';
            return $result;
        }

        $ext = strtolower(pathinfo($fileInput['name'], PATHINFO_EXTENSION));
        if ($ext !== 'dsk') {
            $result['error'] = 'Seuls les fichiers .dsk sont acceptés.';
            return $result;
        }

        if ($fileInput['size'] > MAX_FILE_SIZE) {
            $result['error'] = 'Fichier trop grand (max ' . (MAX_FILE_SIZE / 1024 / 1024) . ' Mo).';
            return $result;
        }

        if (!$this->hasValidSignature($fileInput['tmp_name'])) {
            $result['error'] = 'Fichier invalide : signature DSK non reconnue.';
            return $result;
        }

        $newName = bin2hex(random_bytes(8)) . '.dsk';
        $dest    = UPLOAD_DIR . $newName;

        if (!move_uploaded_file($fileInput['tmp_name'], $dest)) {
            $result['error'] = 'Impossible de sauvegarder le fichier.';
            return $result;
        }

        $result['success']      = true;
        $result['path']         = $dest;
        $result['originalName'] = $fileInput['name'];
        return $result;
    }

    private function hasValidSignature(string $tmpPath): bool
    {
        $fp  = fopen($tmpPath, 'rb');
        $sig = fread($fp, 16);
        fclose($fp);

        foreach (DSK_VALID_SIGNATURES as $validSig) {
            if (strpos($sig, $validSig) === 0) {
                return true;
            }
        }
        return false;
    }
}
