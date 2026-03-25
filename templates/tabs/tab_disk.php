<div id="tab-disk" class="tab-panel active">
    <div class="spec-grid">
        <div class="spec-card">
            <span class="card-title">📋 Spécification</span>
            <table>
                <tr><td>Dump size</td><td><?= number_format($d['fileSize']) ?> octets (<?= FormatHelper::bytes($d['fileSize']) ?>)</td></tr>
                <tr><td>Creator</td><td><?= htmlspecialchars($d['creator']) ?></td></tr>
                <tr><td>Format</td><td><?= htmlspecialchars($d['format']) ?></td></tr>
                <tr><td>Sides</td><td><?= $d['nbSides'] ?></td></tr>
                <tr><td>Tracks formatted</td><td><?= $d['nbTracks'] ?></td></tr>
                <tr><td>Tracks per side</td><td><?= intdiv($d['nbTracks'], max(1, $d['nbSides'])) ?></td></tr>
                <?php for ($side = 1; $side <= $d['nbSides']; $side++): ?>
                <tr><td>Side <?= $side ?> : Tracks size declared</td><td><?= number_format($d['tracksDeclaredSize']) ?> octets (<?= FormatHelper::bytes($d['tracksDeclaredSize']) ?>)</td></tr>
                <tr><td>Side <?= $side ?> : Tracks size real</td><td><?= number_format($d['totalRealBytes']) ?> octets (<?= FormatHelper::bytes($d['totalRealBytes']) ?>)</td></tr>
                <tr><td>Side <?= $side ?> : All Sectors size declared</td><td><?= number_format($d['totalDeclaredBytes']) ?> octets (<?= FormatHelper::bytes($d['totalDeclaredBytes']) ?>)</td></tr>
                <tr><td>Side <?= $side ?> : Sum DATA</td><td><?= number_format($d['totalSumData']) ?></td></tr>
                <?php endfor; ?>
            </table>
        </div>
        <div class="spec-card">
            <span class="card-title">📊 Side 1 — Tailles de secteurs &amp; flags</span>
            <table>
                <?php
                $sizeLabels = [
                    0 => 'SectorSize 0 (128 octets)',
                    1 => 'SectorSize 1 (256 octets)',
                    2 => 'SectorSize 2 (512 octets)',
                    3 => 'SectorSize 3 (1024 octets)',
                    4 => 'SectorSize 4 (2048 octets)',
                    5 => 'SectorSize 5 (4096 octets)',
                    6 => 'SectorSize 6 FULL (8192 octets)',
                    7 => 'SectorSize 7 FULL (16384 octets)',
                    8 => 'SectorSize 8 FULL (32768 octets)',
                    9 => 'SectorSize &gt; 8',
                ];
                foreach ($sizeLabels as $n => $lbl):
                    $cnt = $d['sizeCounts'][$n] ?? 0;
                ?>
                <tr>
                    <td><?= $lbl ?></td>
                    <td style="text-align:right;<?= $cnt > 0 ? 'color:var(--accent);font-weight:700' : '' ?>"><?= $cnt ?></td>
                </tr>
                <?php endforeach; ?>
                <tr style="border-top:2px solid var(--border)">
                    <td><strong>TOTAL SECTORS</strong></td>
                    <td style="text-align:right;font-weight:700;color:var(--accent3)"><?= $d['totalSectors'] ?></td>
                </tr>
                <tr><td>Sector USED</td><td style="text-align:right;color:var(--green);font-weight:700"><?= $d['usedSectors'] ?></td></tr>
                <tr><td>Sector NOT USED</td><td style="text-align:right"><?= $d['totalSectors'] - $d['usedSectors'] ?></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>Incomplete Sector</td>
                    <td style="text-align:right;<?= $d['incompleteSectors'] > 0 ? 'color:var(--orange);font-weight:700' : '' ?>"><?= $d['incompleteSectors'] ?></td>
                </tr>
                <tr>
                    <td>SectorErased</td>
                    <td style="text-align:right;<?= $d['erasedSectors'] > 0 ? 'color:#84cfef;font-weight:700;background:rgba(132,207,239,.1)' : '' ?>"><?= $d['erasedSectors'] ?></td>
                </tr>
                <tr>
                    <td>Weak Sectors</td>
                    <td style="text-align:right;<?= $d['weakSectors'] > 0 ? 'color:var(--red);font-weight:700' : '' ?>"><?= $d['weakSectors'] ?></td>
                </tr>
                <tr>
                    <td>TOTAL - Weak Sectors</td>
                    <td style="text-align:right;<?= $d['totalWeakSectors'] > 0 ? 'background:rgba(255,68,68,.15);color:var(--red);font-weight:700' : '' ?>"><?= $d['totalWeakSectors'] ?></td>
                </tr>
                <tr><td>Sector with GAPS information</td><td style="text-align:right">0</td></tr>
                <tr><td>Sector with GAP2 information</td><td style="text-align:right">0</td></tr>
                <tr><td>FDC Errors</td><td style="text-align:right"><?= $d['weakSectors'] ?></td></tr>
            </table>
        </div>
    </div>
</div>
