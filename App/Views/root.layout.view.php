<?php
/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link rel="stylesheet" href="/public/css/styl.css">
    <link rel="stylesheet" href="/public/css/login.form.css">
    <link rel="stylesheet" href="/public/css/home.index.css">
    <link rel="stylesheet" href="/public/css/foodOffer.index.css">
    <script src="/public/js/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Dnešné menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=<?= $link->url("FoodOffer.index") ?>>Ponuka Jedál</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Ponuka nápojov</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=<?= $link->url("Login.index") ?>>Log In</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
