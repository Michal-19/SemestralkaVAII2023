<?php
/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */

use App\Config\Configuration;

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= Configuration::APP_NAME ?></title>
    <link rel="stylesheet" href="/public/css/styl.css">
    <link rel="stylesheet" href="/public/css/login.form.css">
    <link rel="stylesheet" href="/public/css/home.index.css">
    <link rel="stylesheet" href="/public/css/foodType.index.css">
    <link rel="stylesheet" href="/public/css/foodOffer.index.css">
    <link rel="stylesheet" href="/public/css/foodOffer.add.form.css">
    <link rel="stylesheet" href="/public/css/foodOffer.detail.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/script.js"></script>
    <script src="/public/js/FoodTypesCreator.js" type="module" defer></script>
    <script src="/public/js/FoodTypesApi.js" type="module" defer></script>
    <script src="/public/js/FoodTypesService.js" type="module" defer></script>
    <script src="/public/js/RequestSender.js" type="module" defer></script>
</head>
<body>
<header>
    <div class="logo">Barbaricum</div>
    <div class="icone" onclick="navbarMenu()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li>
                <a href="?c=home" class="active">Domov</a>
            </li>
            <li>
                <a href="?c=foodType" class="active" id="food-types-offer">Ponuka jedál</a>
            </li>
            <li>
                <a href="" class="active">Ponuka nápojov</a>
            </li>
            <li>
                <?php if ($auth->isLogged()) { ?>
                    <a href="?c=auth&a=logout" class="active">Log out</a>
                <?php } else { ?>
                    <a href="?c=auth&a=login" class="active">Log in</a>
                <?php } ?>
            </li>
        </ul>
    </nav>
</header>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
</body>
</html>
