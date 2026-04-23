<?php $message = $uploadError; include __DIR__ . '/partials/error_msg.php'; ?>

<div class="upload-dual">

    <!-- ══ Carte DSK ══════════════════════════════════════════════════════════ -->
    <div class="upload-card">
        <img src="public/assets/img/logo-dsk-tool-php.webp" alt="DSKscan" class="logo-big">
        <h2><?= htmlspecialchars($t['upload_title']) ?></h2>
        <p><?= $t['upload_desc'] ?></p>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <div class="drop-zone" id="drop-zone-dsk">
                <input type="file" name="dsk_file" id="dsk_file" accept=".dsk">
                <div class="dz-label"><?= $t['upload_dropzone'] ?></div>
                <div class="dz-file-name" id="dz-file-name-dsk"></div>
            </div>
            <button type="submit" class="btn"><?= htmlspecialchars($t['upload_btn']) ?></button>
        </form>
    </div>

    <!-- ══ Séparateur ════════════════════════════════════════════════════════ -->
    <div class="upload-sep"><span>ou</span></div>

    <!-- ══ Carte CDT/TZX ════════════════════════════════════════════════════ -->
    <div class="upload-card">
        <div class="icon">📼</div>
        <h2><?= htmlspecialchars($t['upload_tape_title']) ?></h2>
        <p><?= $t['upload_tape_desc'] ?></p>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <div class="drop-zone" id="drop-zone-cdt">
                <input type="file" name="cdt_file" id="cdt_file" accept=".cdt,.tzx">
                <div class="dz-label"><?= $t['upload_tape_dropzone'] ?></div>
                <div class="dz-file-name" id="dz-file-name-cdt"></div>
            </div>
            <button type="submit" class="btn btn-tape"><?= htmlspecialchars($t['upload_tape_btn']) ?></button>
        </form>

        <div class="tape-fmt-badges">
            <span class="fmt-badge cdt">📼 .CDT — Amstrad CPC</span>
            <span class="fmt-badge tzx">💾 .TZX — ZX Spectrum</span>
        </div>
    </div>

</div>
