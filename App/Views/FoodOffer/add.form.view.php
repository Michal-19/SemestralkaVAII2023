<?php
/** @var Array $data */
?>
<form class="add-food-offer-form" action="?c=foodOffer&a=store" method="post" onsubmit="validateFoodForm()" name="crud-food">
    <?php if ($data["food"]->getId()) : ?>
        <input type="hidden" name="id" value="<?php echo $data["food"]->getId() ?>">
    <?php endif ?>
    <label class="label-food">
        Jedlo :
        <br><input class="input-jedlo" type="text" name="text" value="<?= $data["food"]->getName() ?>">
    </label>
    <?php if (isset($data["errors"]["text"])) : ?>
        <span style="color: red"><?php echo $data["errors"]["text"] ?></span><br>
    <?php endif ?>
    <label class="label-price">
        Cena :
        <br><input class="input-price" type="number" name="price" value="<?= $data["food"]->getPrice() ?>">
    </label>
    <?php if (isset($data["errors"]["price"])) : ?>
        <span style="color: red"><?php echo $data["errors"]["price"] ?></span><br>
    <?php endif ?>
    <input id="submit-button" type="submit" value="<?php echo $data["action"] ?>">
</form>
