<div id="tab-catalogue" class="tab-panel">

<?php if (empty($d['catalogue'])): ?>
    <div class="empty-state">
        <div class="es-icon">📂</div>
        <div><?= $t['cat_empty'] ?></div>
        <div style="margin-top:8px;font-size:12px;color:var(--text-dim)"><?= $t['cat_empty_hint'] ?></div>
    </div>
<?php else: ?>

    <?php foreach ($d['catalogue'] as $i => $entry): ?>
    <?php $h = $entry['header']; $isCpc = $h['isCpc'] ?? true; ?>
    <div class="cat-entry">
        <div class="cat-header-bar">
            <span class="cat-icon"><?= $isCpc ? '🖥' : '💻' ?></span>
            <span class="cat-filename"><?= htmlspecialchars($h['name'] !== '' ? $h['name'] : $t['cat_no_name']) ?></span>
            <span class="cat-platform"><?= $isCpc ? 'Amstrad CPC' : 'ZX Spectrum' ?></span>
            <span class="cat-type-badge"><?= htmlspecialchars($h['fileTypeName']) ?></span>
        </div>

        <div class="cat-body">
            <?php if ($isCpc): ?>
            <div class="cat-grid">
                <div class="cat-section">
                    <div class="cat-section-title"><?= sprintf($t['cat_header_cpc'], str_pad($entry['headerBlockIndex'], 4, '0', STR_PAD_LEFT)) ?></div>
                    <table class="cat-table">
                        <tr><td><?= $t['cat_field_name'] ?></td>
                            <td class="mono"><?= htmlspecialchars($h['name']) ?></td></tr>
                        <tr><td><?= $t['cat_field_type'] ?></td>
                            <td><?= htmlspecialchars($h['fileTypeName']) ?></td></tr>
                        <tr><td><?= $t['cat_field_block_num'] ?></td>
                            <td class="mono"><?= $h['blockNum'] ?></td></tr>
                        <tr><td><?= $t['cat_field_first_block'] ?></td>
                            <td><?= FormatHelper::badge($h['firstBlock'], $t['cat_yes'], 'yes') ?></td></tr>
                        <tr><td><?= $t['cat_field_last_block'] ?></td>
                            <td><?= FormatHelper::badge($h['lastBlock'], $t['cat_yes'], 'yes') ?></td></tr>
                        <tr><td><?= $t['cat_field_sum_header'] ?></td>
                            <td class="mono"><?= number_format($entry['headerSumData']) ?></td></tr>
                    </table>
                </div>

                <div class="cat-section">
                    <div class="cat-section-title"><?= $t['cat_mem_title'] ?></div>
                    <table class="cat-table">
                        <tr><td><?= $t['cat_field_load_addr'] ?></td>
                            <td class="mono addr-highlight"><?= FormatHelper::addr($h['loadAddr']) ?></td></tr>
                        <tr><td><?= $t['cat_field_data_len'] ?></td>
                            <td class="mono"><?= FormatHelper::addr($h['dataLen']) ?>
                                <span class="bytes-hint">(<?= number_format($h['dataLen']) ?> <?= $t['cat_bytes'] ?>)</span>
                            </td></tr>
                        <tr><td><?= $t['cat_field_log_len'] ?></td>
                            <td class="mono"><?= FormatHelper::addr($h['logLen']) ?>
                                <span class="bytes-hint">(<?= number_format($h['logLen']) ?> <?= $t['cat_bytes'] ?>)</span>
                            </td></tr>
                        <tr><td><?= $t['cat_field_exec_addr'] ?></td>
                            <td class="mono addr-highlight"><?= FormatHelper::addr($h['execAddr']) ?></td></tr>
                    </table>
                </div>

                <?php if ($entry['dataBlockIndex'] !== null): ?>
                <div class="cat-section">
                    <div class="cat-section-title"><?= sprintf($t['cat_data_block'], str_pad($entry['dataBlockIndex'], 4, '0', STR_PAD_LEFT)) ?></div>
                    <table class="cat-table">
                        <tr><td><?= $t['cat_field_real_size'] ?></td>
                            <td class="mono"><?= number_format($entry['dataLen']) ?> <?= $t['cat_bytes'] ?></td></tr>
                        <tr><td><?= $t['cat_field_sum_data'] ?></td>
                            <td class="mono"><?= number_format($entry['dataSumData']) ?></td></tr>
                    </table>
                    <button class="btn btn-sm" style="margin-top:10px"
                            onclick="jumpToBlock(<?= $entry['dataBlockIndex'] ?>)">
                        <?= $t['cat_hex_dump_btn'] ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <?php else: ?>
            <div class="cat-grid">
                <div class="cat-section">
                    <div class="cat-section-title"><?= sprintf($t['cat_header_zx'], str_pad($entry['headerBlockIndex'], 4, '0', STR_PAD_LEFT)) ?></div>
                    <table class="cat-table">
                        <tr><td><?= $t['cat_field_zx_name'] ?></td>
                            <td class="mono"><?= htmlspecialchars($h['name']) ?></td></tr>
                        <tr><td><?= $t['cat_field_type'] ?></td>
                            <td><?= htmlspecialchars($h['fileTypeName']) ?></td></tr>
                        <tr><td><?= $t['cat_field_zx_length'] ?></td>
                            <td class="mono"><?= number_format($h['length']) ?> <?= $t['cat_bytes'] ?></td></tr>
                        <tr><td><?= $t['cat_field_zx_param1'] ?></td>
                            <td class="mono"><?= FormatHelper::addr($h['param1']) ?></td></tr>
                        <tr><td><?= $t['cat_field_zx_param2'] ?></td>
                            <td class="mono"><?= FormatHelper::addr($h['param2']) ?></td></tr>
                    </table>
                </div>

                <?php if ($entry['dataBlockIndex'] !== null): ?>
                <div class="cat-section">
                    <div class="cat-section-title"><?= sprintf($t['cat_data_block'], str_pad($entry['dataBlockIndex'], 4, '0', STR_PAD_LEFT)) ?></div>
                    <table class="cat-table">
                        <tr><td><?= $t['cat_field_zx_size'] ?></td>
                            <td class="mono"><?= number_format($entry['dataLen']) ?> <?= $t['cat_bytes'] ?></td></tr>
                        <tr><td><?= $t['cat_field_zx_sum'] ?></td>
                            <td class="mono"><?= number_format($entry['dataSumData']) ?></td></tr>
                    </table>
                    <button class="btn btn-sm" style="margin-top:10px"
                            onclick="jumpToBlock(<?= $entry['dataBlockIndex'] ?>)">
                        <?= $t['cat_hex_dump_btn'] ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endforeach; ?>

    <div style="margin-top:16px;font-size:12px;color:var(--text-dim);text-align:right">
        <?= sprintf($t['cat_footer'], count($d['catalogue'])) ?>
    </div>

<?php endif; ?>

</div>
