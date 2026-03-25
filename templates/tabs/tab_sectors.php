<div id="tab-sectors" class="tab-panel">
    <div class="table-scroll">
    <table class="data-table">
        <thead>
            <tr>
                <th>Track</th>
                <th>Sector ID</th>
                <th>Size</th>
                <th>Real Size</th>
                <th>Sum DATA</th>
                <th>FDC FLAGS</th>
                <th>GAPS</th>
                <th>GAP2</th>
                <th>Erased</th>
                <th>Weak</th>
                <th>Used</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($d['sectors'] as $s): ?>
        <tr>
            <td class="center"><?= $s['track'] ?></td>
            <td class="mono center"><?= FormatHelper::hex($s['R']) ?></td>
            <td class="center"><?= $s['declSize'] ?></td>
            <td class="center<?= $s['isIncomplete'] ? '" style="color:var(--orange)' : '' ?>"><?= $s['realSize'] ?></td>
            <td class="mono"><?= number_format($s['sumData']) ?></td>
            <td class="mono center"><?= FormatHelper::fdcBinary($s['sr1']) ?></td>
            <td class="mono center">-</td>
            <td class="mono center">-</td>
            <td class="center"><?= FormatHelper::badge($s['isErased'], 'YES', 'erased', '-') ?></td>
            <td class="center"><?= FormatHelper::badge($s['isWeak'],   'YES', 'weak',   '-') ?></td>
            <td class="center"><?= FormatHelper::badge($s['isUsed'],   'YES', 'yes',    '-') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:var(--bg3);font-weight:700">
                <td colspan="3" style="color:var(--text-dim)">Total</td>
                <td class="center"><?= number_format($d['totalRealBytes']) ?></td>
                <td class="mono"><?= number_format($d['totalSumData']) ?></td>
                <td colspan="6"></td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
