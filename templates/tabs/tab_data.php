<div id="tab-data" class="tab-panel">

    <?php if (empty($d['sectors'])): ?>
        <div class="empty-state"><div class="es-icon">📭</div>No sectors found.</div>
    <?php else: ?>

    <div class="sdata-toolbar">
        <label for="sdata-select" class="sdata-label">Choose sector :</label>
        <select id="sdata-select" onchange="sdataShow(this.value)">
            <?php foreach ($d['sectors'] as $i => $s): ?>
                <option value="<?= $i ?>">
                    Track <?= str_pad($s['track'], 2, '0', STR_PAD_LEFT) ?>
                    Sector #<?= strtoupper(str_pad(dechex($s['R']), 2, '0', STR_PAD_LEFT)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-sm" onclick="sdataNav(-1)">&#8249;</button>
        <button class="btn btn-sm" onclick="sdataNav(+1)">&#8250;</button>
    </div>

    <div id="sdata-panels">
        <?php foreach ($d['sectors'] as $i => $s):
            $data     = $s['data'];
            $len      = strlen($data);
            $declSize = $s['declSize'];
            $realSize = $s['realSize'];
            $flags    = [];
            if ($s['isWeak'])       $flags[] = 'WEAK';
            if ($s['isErased'])     $flags[] = 'ERASED';
            if ($s['isIncomplete']) $flags[] = 'INCOMPLETE';
            $flagStr  = $flags ? ' / ' . implode(' + ', $flags) : '';
        ?>
        <div class="sdata-panel <?= $i === 0 ? 'active' : '' ?>" id="sdata-panel-<?= $i ?>">
            <div class="sdata-size">
                Size : <?= $declSize ?> (Real : <?= $realSize ?>)<?= $flagStr ?>
            </div>
            <pre class="hex-dump"><?php
                for ($off = 0; $off < $len; $off += 16) {
                    // Adresse
                    echo sprintf('%06X: ', $off);

                    // Hex
                    $hex = '';
                    $asc = '';
                    for ($b = 0; $b < 16; $b++) {
                        if ($off + $b < $len) {
                            $byte = ord($data[$off + $b]);
                            $hex .= sprintf('%02X ', $byte);
                            $asc .= ($byte >= 0x20 && $byte < 0x7F) ? chr($byte) : '.';
                        } else {
                            $hex .= '   ';
                            $asc .= ' ';
                        }
                    }

                    echo htmlspecialchars($hex) . ' ' . htmlspecialchars($asc) . "\n";
                }
            ?></pre>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</div>
