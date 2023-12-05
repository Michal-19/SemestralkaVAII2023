<?php
/** @var Food $data */
use App\Models\Food;
?>
<form method="post" onsubmit="return validateFoodForm()" action="?c=foodOffer&a=store" name="crud-food">
    <?php if ($data->getId()) : ?>
        <input type="hidden" name="id" value="<?php echo $data->getId() ?>"
    <?php endif ?>
    <label>
        Jedlo :
        <br><input type="text" name="text" value="<?= $data->getName() ?>"><br>
        Cena :
        <br><input type="number" name="price" value="<?= $data->getPrice() ?>">
    </label>
    <br><input id="submit-button" type="submit" value="Pridať">
</form>
