<?php

use App\Core\IAuthenticator;

/** @var IAuthenticator $auth */
/** @var Array $data */
/** @var string $elementName */
?>
<!DOCTYPE html>
<html lang="sk">
<body>
<h1 id="food-type-title">Ponuka jedál</h1>
<div id="food-types-container-id">
    <?php foreach ($data as $foodType) {
        if ($auth->isLogged()) { ?>
            <div class="food-type" id="food-type-id-<?= $foodType->getId() ?>">
                <label for="food-type-input-edit-id-<?= $foodType->getId() ?>"></label>
                <input class="food-type-input-edit"
                       id="food-type-input-edit-id-<?= $foodType->getId() ?>"
                       value="<?= $foodType->getName() ?>">
                <br>
                <div class="food-type-created-by">Vytvorené používateľom: <?= $foodType->getCreatedBy() ?></div>
                <div class="food-type-created-time">Vytvorené: <?= $foodType->getCreatedTime() ?></div>
                <div class="food-type-edited-by">Naposledy upravené používteľom: <?= $foodType->getLastEditedBy() ?></div>
                <div aria-disabled="true" class="food-type-edited-time">Naposledy vytvorené: <?= $foodType->getLastEditedTime() ?></div>
                <a class="btn btn-primary" href="?c=foodOffer&foodTypeId=<?= $foodType->getId() ?>">Ukáž jedla</a>
                <a class="btn btn-warning"
                   id="food-type-btn-edit-id-<?= $foodType->getId() ?>"
                   onclick="document.foodTypesService.editFoodType(<?= $foodType->getId() ?>)">Edit
                </a>
                <a class="btn btn-danger"
                   id="food-type-btn-delete-id"
                   onclick="document.foodTypesService.deleteFoodType(<?= $foodType->getId() ?>)">Delete
                </a>
            </div>
        <?php } else { ?>
            <div class="food-type">
                <a href="?c=foodOffer&foodTypeId=<?= $foodType->getId() ?>"
                   class="food-type-text"><?php echo $foodType->getName() ?>
                </a>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<?php if ($auth->isLogged()) { ?>
        <label for="food-type-input-add-id"></label>
    <input id="food-type-input-add-id" class="add-food-type-input" placeholder="Zadajte druh jedla">
    <div class="food-type-add-button">
        <a class="btn btn-success" id="food-type-btn-add-id" onclick="document.foodTypesService.addFoodType()">Pridať</a>
    </div>
<?php } ?>
</body>
</html>