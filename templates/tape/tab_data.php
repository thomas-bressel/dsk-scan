<div id="tab-data" class="tab-panel">

<?php
$dataBlocks = array_filter($d['blocks'], fn($b) => $b['dataLen'] > 0 && strlen($b['data']) > 0);
$dataBlocks = array_values($dataBlocks);
?>

<?php if (empty($dataBlocks)): ?>
    <div class="empty-state">
        <div class="es-icon">📭</div>
        <div><?= $t['tape_data_empty'] ?></div>
    </div>
<?php else: ?>

    <div class="sdata-toolbar">
        <label for="sdata-select" class="sdata-label"><?= $t['tape_data_choose'] ?></label>
        <select id="sdata-select" onchange="sdataShow(this.value)">
            <?php foreach ($dataBlocks as $i => $block): ?>
                <option value="<?= $i ?>">
                    [<?= str_pad($block['index'], 4, '0', STR_PAD_LEFT) ?>]
                    <?= htmlspecialchars($block['typeName']) ?>
                    <?php
                    $bh = $block['cpcHeader'] ?? $block['zxHeader'] ?? null;
                    if ($bh) echo ' — ' . htmlspecialchars($bh['name']);
                    echo ' (' . number_format($block['dataLen']) . ' o)';
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-sm" onclick="sdataNav(-1)">&#8249;</button>
        <button class="btn btn-sm" onclick="sdataNav(+1)">&#8250;</button>
    </div>

    <div id="sdata-panels">
    <?php foreach ($dataBlocks as $i => $block):
        $len       = strlen($block['data']);
        $truncated = ($block['dataLen'] > $len);
        $flags     = [];
        if ($block['cpcHeader'] ?? null) $flags[] = 'HEADER CPC';
        if ($block['zxHeader']  ?? null) $flags[] = 'HEADER ZX';
        $flagStr = $flags ? implode(' + ', $flags) : '';
    ?>
    <div class="sdata-panel <?= $i === 0 ? 'active' : '' ?>" id="sdata-panel-<?= $i ?>">

        <div class="block-meta-bar">
            <div class="bm-cell">
                <span class="bm-label"><?= $t['blocks_col_type'] ?></span>
                <span class="bm-value">
                    <span class="block-type-dot <?= $block['cssClass'] ?>"></span>
                    <?= htmlspecialchars($block['typeName']) ?>
                </span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_decl_size'] ?></span>
                <span class="bm-value mono"><?= number_format($block['dataLen']) ?> o</span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_real_size'] ?></span>
                <span class="bm-value mono<?= $truncated ? ' orange-val' : '' ?>"><?= number_format($len) ?> o</span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_sum'] ?></span>
                <span class="bm-value mono"><?= number_format($block['sumData'] ?? 0) ?></span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_duration'] ?></span>
                <span class="bm-value mono"><?= number_format($block['durationMs']) ?> ms</span>
            </div>
            <?php if ($flagStr): ?>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_flags'] ?></span>
                <span class="bm-value" style="color:var(--accent)"><?= htmlspecialchars($flagStr) ?></span>
            </div>
            <?php endif; ?>
            <?php if (isset($block['pilotPulse'])): ?>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_pilot'] ?></span>
                <span class="bm-value mono"><?= $block['pilotPulse'] ?> / <?= $block['sync1'] ?> / <?= $block['sync2'] ?> T</span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_zero_one'] ?></span>
                <span class="bm-value mono"><?= $block['zeroPulse'] ?> / <?= $block['onePulse'] ?> T</span>
            </div>
            <div class="bm-cell">
                <span class="bm-label"><?= $t['tape_data_pilot_tone'] ?></span>
                <span class="bm-value mono"><?= number_format($block['pilotCount']) ?> pulses</span>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($truncated): ?>
        <div class="sdata-warning">
            <?= sprintf($t['tape_data_truncated'], number_format($len), number_format($block['dataLen'])) ?>
        </div>
        <?php endif; ?>

        <pre class="hex-dump"><?= FormatHelper::hexDump($block['data']) ?></pre>

    </div>
    <?php endforeach; ?>
    </div>

<?php endif; ?>
</div>
