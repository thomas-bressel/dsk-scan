<div id="tab-tracks" class="tab-panel">
    <div class="table-scroll">
    <table class="data-table">
        <thead>
            <tr>
                <th>TRACK</th>
                <th>SECTORS</th>
                <th>SECTOR SIZE</th>
                <th>GAP</th>
                <th>FILLER</th>
                <th>Sum DATA</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($d['tracks'] as $t): ?>
        <tr>
            <td class="center"><?= $t['num'] ?></td>
            <td class="center"><?= $t['spt'] ?></td>
            <td><?= number_format($t['totalBytes']) ?> octets (<?= FormatHelper::bytes($t['totalBytes']) ?>)</td>
            <td class="mono center"><?= FormatHelper::hex($t['gap']) ?></td>
            <td class="mono center"><?= FormatHelper::hex($t['filler']) ?></td>
            <td class="mono"><?= number_format($t['sumData']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background:var(--bg3);font-weight:700">
                <td colspan="2" style="color:var(--text-dim)"><?= count($d['tracks']) ?> piste(s)</td>
                <td><?= number_format($d['totalSectors']) ?> secteurs</td>
                <td colspan="2"></td>
                <td class="mono"><?= number_format($d['totalSumData']) ?></td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
