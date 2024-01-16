<?php
use App\Models\Food;
/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Login</title>
</head>
<body>
<h1 id="nadpis"><?= $data["foodType"]?->getName() ?></h1>
<?php foreach ($data["foods"] as $food) { ?>
    <div class="jedlo-element">
        <div class="food-name"><?= $food->getName() ?></div>
        <div class="food-ingredients"><?= $food->getIngredients() ?></div>
        <div class="food-price">Cena: <?= $food->getPrice() ?> <?= $food->getPriceUnit() ?></div>
        <div class="food-weight">Obsah: <?= $food->getWeight() ?> <?= $food->getWeightUnit() ?></div><br>
        <?php if ($auth->isLogged()) { ?>
            <a href="?c=foodOffer&a=edit&id=<?= $food->getId() ?>" class="btn btn-warning">Edit</a>
            <a href="?c=foodOffer&a=delete&id=<?= $food->getId() ?>" class="btn btn-danger">Delete</a>
        <?php } ?>
        <a class="btn btn-primary" href="?c=foodOffer&a=getOneFood&foodId=<?= $food->getId() ?>">Ukáž jedla</a>
    </div>
<?php } ?>
<?php if ($auth->isLogged()) { ?>
    <div class="add-button">
        <a href="?c=foodOffer&a=add&foodTypeId=<?= $data["foodType"]?->getId() ?>" class="btn btn-success">Pridať jedlo</a>
    </div>
<?php } ?>
</body>
</html>

