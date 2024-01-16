<?php
/** @var Array $data */
?>
<form class="form-add-food" action="?c=foodOffer&a=store" method="post" name="crud-food">
    <?php if ($data["food"]->getId()) { ?>
        <input type="hidden" name="id" value="<?= $data["food"]->getId() ?>">
    <?php } ?>
    <input type="hidden" name="foodTypeId" value="<?= $data["foodType"]?->getId() ?>">
    <label class="label-add-food-name">
        Názov<br>
        <input class="input-jedlo input-prop" type="text" name="text" value="<?= $data["food"]->getName() ?>">
    </label>
    <label class="label-add-food-price">
        Cena<br>
        <input class="input-price input-prop" type="text" name="price" value="<?= $data["food"]->getPrice() ?>">
        <select id="price-unit" name="price-unit">
            <option value="EUR" <?php echo ($data["food"]->getPriceUnit() == "EUR") ? "selected" : ""; ?>>EUR</option>
            <option value="CZK" <?php echo ($data["food"]->getPriceUnit() == "CZK") ? "selected" : ""; ?>>CZK</option>
            <option value="PLN" <?php echo ($data["food"]->getPriceUnit() == "PLN") ? "selected" : ""; ?>>PLN</option>
        </select>
    </label>
    <label class="label-add-food-weight">
        Hmotnosť<br>
        <input class="input-weight input-prop" type="text" name="weight" value="<?= $data["food"]->getWeight() ?>">
        <select id="weight-unit" name="weight-unit">
            <option value="g" <?php echo ($data["food"]->getWeightUnit() == "g") ? "selected" : ""; ?>>g</option>
            <option value="ml" <?php echo ($data["food"]->getWeightUnit() == "ml") ? "selected" : ""; ?>>ml</option>
            <option value="kg" <?php echo ($data["food"]->getWeightUnit() == "kg") ? "selected" : ""; ?>>kg</option>
            <option value="l" <?php echo ($data["food"]->getWeightUnit() == "l") ? "selected" : ""; ?>>l</option>
            <option value="dcl" <?php echo ($data["food"]->getWeightUnit() == "dcl") ? "selected" : ""; ?>>dcl</option>
        </select>
    </label>
    <label class="label-add-food-ingredients">Suroviny<br>
        <textarea id="textarea-add-food-ingredients" name="ingredients" rows="2">
            <?= $data["food"]->getIngredients() ?>
        </textarea>
    </label><br>
    <input class="input-prop" id="submit-button" type="submit" value="<?= $data["action"] ?>"><br>
    <?php if (isset($data["errors"])) {
        foreach ($data["errors"] as $error) { ?>
            <span class="errors"><?= $error ?></span><br>
        <?php } ?>
    <?php } ?>
</form>
