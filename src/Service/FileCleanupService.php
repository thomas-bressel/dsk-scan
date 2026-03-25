<?php

class FileCleanupService
{
    public function run(): void
    {
        foreach (glob(UPLOAD_DIR . '*.dsk') as $file) {
            if (filemtime($file) < time() - FILE_MAX_AGE_SECONDS) {
                @unlink($file);
            }
        }
    }
}
