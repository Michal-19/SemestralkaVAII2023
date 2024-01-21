<?php
use App\Core\IAuthenticator;

/** @var Array $data */
/** @var IAuthenticator $auth */
?>
<form class="add-menu-form" action="?c=home&a=store" method="post">
    <?php if ($data["menu"]->getId()) { ?>
        <h1 class="add-menu-title">Editácia menu</h1>
        <input type="hidden" name="menuId" value="<?= $data["menu"]->getId() ?>">
    <?php } else { ?>
        <h1 class="add-menu-title">Pridanie menu</h1>
    <?php } ?>
    <label class="add-menu-name-label">
        Názov menu<br>
        <input class="add-menu-name-input input-prop" type="text" name="name" value="<?= $data["menu"]->getName() ?>">
    </label><br>
    <label class="add-menu-soup-label">
        Polievka<br>
        <input class="add-menu-soup-input input-prop" type="text" name="soup" value="<?= $data["menu"]->getSoup() ?>">
    </label><br>
    <label class="add-menu-main-food-label">
        Hlavné jedlo<br>
        <input class="add-menu-main-food-input input-prop" name="mainFood" type="text" value="<?= $data["menu"]->getMainFood() ?>">
    </label><br>
    <label class="add-menu-day-label">
        Menu podávané v
        <select class="add-menu-day-select" name="day">
            <option value="pondelok" <?php echo ($data["menu"]->getDay() == "pondelok") ? "selected" : ""; ?>>pondelok</option>
            <option value="utorok" <?php echo ($data["menu"]->getDay() == "utorok") ? "selected" : ""; ?>>utorok</option>
            <option value="streda" <?php echo ($data["menu"]->getDay() == "streda") ? "selected" : ""; ?>>streda</option>
            <option value="štvrtok" <?php echo ($data["menu"]->getDay() == "štvrtok") ? "selected" : ""; ?>>štvrtok</option>
            <option value="piatok" <?php echo ($data["menu"]->getDay() == "piatok") ? "selected" : ""; ?>>piatok</option>
        </select>
    </label><br>
    <label class="add-menu-price-label">
        Cena<br>
        <input class="add-menu-price-input input-prop" name="price" type="text" value="<?= $data["menu"]->getPrice() ?>">
        <select class="add-menu-price-unit-select" name="price-unit">
            <option value="EUR" <?php echo ($data["menu"]->getPriceUnit() == "EUR") ? "selected" : ""; ?>>EUR</option>
            <option value="CZK" <?php echo ($data["menu"]->getPriceUnit() == "CZK") ? "selected" : ""; ?>>CZK</option>
            <option value="PLN" <?php echo ($data["menu"]->getPriceUnit() == "PLN") ? "selected" : ""; ?>>PLN</option>
        </select>
    </label>
    <input class="btn btn-success" id="add-menu-add-button" type="submit" value="<?= $data["action"] ?>"><br>
    <?php if (isset($data["errors"])) {
        foreach ($data["errors"] as $error) { ?>
            <span class="errors"><?= $error ?></span><br>
        <?php } ?>
    <?php } ?>
</form>
