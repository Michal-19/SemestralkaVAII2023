<?php

/** @var string $contentHTML */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link rel="stylesheet" href="/public/css/styl.css">
    <script src="/public/js/script.js"></script>
</head>
<body>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
