<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DSK Sector Viewer</title>
<link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<header class="site-header">
    <span class="logo">💾</span>
    <h1>DSK Sector Viewer</h1>
    <span class="sub">Amstrad CPC · Extended DSK Format</span>
</header>

<div class="container">

<?php if (!$diskData): ?>

    <?php include __DIR__ . '/upload.php'; ?>

<?php else:
    $d = $diskData;
?>

    <?php include __DIR__ . '/disk_banner.php'; ?>

    <div class="tabs-wrapper">
        <div class="tabs-nav">
            <button class="tab-btn active" onclick="showTab('disk', this)">💽 Disk</button>
            <button class="tab-btn" onclick="showTab('files', this)">📁 Files</button>
            <button class="tab-btn" onclick="showTab('map', this)">🗺 Map</button>
            <button class="tab-btn" onclick="showTab('sectors', this)">🔲 Sectors</button>
            <button class="tab-btn" onclick="showTab('tracks', this)">🎵 Tracks</button>
            <button class="tab-btn" onclick="showTab('infos', this)">ℹ️ Infos</button>
        </div>

        <?php include __DIR__ . '/tabs/tab_disk.php'; ?>
        <?php include __DIR__ . '/tabs/tab_files.php'; ?>
        <?php include __DIR__ . '/tabs/tab_map.php'; ?>
        <?php include __DIR__ . '/tabs/tab_sectors.php'; ?>
        <?php include __DIR__ . '/tabs/tab_tracks.php'; ?>
        <?php include __DIR__ . '/tabs/tab_infos.php'; ?>

    </div><!-- /tabs-wrapper -->

<?php endif; ?>

</div><!-- /container -->

<script src="public/assets/app.js"></script>
</body>
</html>
