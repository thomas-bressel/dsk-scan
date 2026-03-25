<div class="upload-card">
    <div class="icon">📀</div>
    <h2>Analyser une disquette Amstrad</h2>
    <p>Déposez un fichier <strong>.dsk</strong> au format Extended CPC DSK.<br>Taille maximale : 5 Mo.</p>

    <?php $message = $uploadError; include __DIR__ . '/partials/error_msg.php'; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

        <div class="drop-zone" id="drop-zone">
            <input type="file" name="dsk_file" id="dsk_file" accept=".dsk">
            <div class="dz-label">Glissez votre fichier ici ou <span>cliquez pour parcourir</span></div>
            <div class="dz-file-name" id="dz-file-name"></div>
        </div>

        <button type="submit" class="btn">
            <span>🔍</span> Analyser le fichier
        </button>
    </form>
</div>
