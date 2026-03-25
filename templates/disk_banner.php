<div class="disk-banner">
    <span class="disk-icon">💾</span>
    <div>
        <div class="disk-title"><?= htmlspecialchars($originalName) ?></div>
        <div class="disk-meta">
            <?= htmlspecialchars($d['format']) ?> &nbsp;·&nbsp;
            Créateur : <?= htmlspecialchars($d['creator']) ?> &nbsp;·&nbsp;
            <?= FormatHelper::bytes($d['fileSize']) ?>
        </div>
    </div>
    <div class="disk-stats">
        <div class="stat-badge"><div class="val"><?= $d['nbTracks'] ?></div><div class="lbl">Pistes</div></div>
        <div class="stat-badge"><div class="val"><?= $d['nbSides'] ?></div><div class="lbl">Face(s)</div></div>
        <div class="stat-badge"><div class="val"><?= $d['totalSectors'] ?></div><div class="lbl">Secteurs</div></div>
        <div class="stat-badge"><div class="val" style="color:var(--green)"><?= $d['usedSectors'] ?></div><div class="lbl">Utilisés</div></div>
        <?php if ($d['weakSectors'] > 0): ?>
        <div class="stat-badge"><div class="val" style="color:var(--red)"><?= $d['weakSectors'] ?></div><div class="lbl">Weak</div></div>
        <?php endif; ?>
    </div>
    <div class="new-upload-btn">
        <a href="?" class="btn btn-sm">⬆ Nouveau fichier</a>
    </div>
</div>
