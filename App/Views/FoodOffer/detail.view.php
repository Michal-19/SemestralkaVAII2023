<?php
use App\Core\IAuthenticator;

/** @var Array $data */
/** @var IAuthenticator $auth */
?>
<div class="food-detail-container">
    <h1 class="food-detail-title">
        <?= $data["food"]?->getName() ?>
    </h1>
    <label class="default-label line" for="food-detail-foodType-id">Typ jedla</label><br>
    <div class="food-detail-foodType" id="food-detail-foodType-id">
        <?= $data["foodType"]?->getName() ?>
    </div>
    <label class="default-label line" for="food-detail-ingredients-id">Zloženie</label><br>
    <div class="food-detail-ingredients" id="food-detail-ingredients-id">
        <?= $data["food"]?->getIngredients() ?>
    </div>
    <?php if ($auth->isLogged()) { ?>
        <form class="food-detail-description-form" method="post" action="?c=foodOffer&a=editDescription&foodId=<?= $data["food"]?->getId() ?>">
            <label class="default-label" for="food-detail-description-edit-id">
                Popis
                <textarea id="food-detail-description-edit-id"
                          class="food-detail-description-edit"
                          rows="5"
                          name="description"
                          placeholder="Zadajde popis jedla...">
                    <?= $data["food"]?->getDescription() ?>
                </textarea>
            </label>
            <input class="btn btn-primary"
                   id="food-detail-description-edit-btn-id"
                   type="submit"
                   value="<?= $data["food"]?->getDescription() == "" ? "Add" : "Edit" ?>"><br>
        </form><br>
    <?php } else if ($data["food"]?->getDescription() !== null) { ?>
        <label class="default-label" for="food-detail-description-id">Popis</label><br>
        <div class="food-detail-description" id="food-detail-description-id">
            <?= $data["food"]?->getDescription() ?>
        </div><br>
    <?php } ?>
    <?php if ($auth->isLogged()) { ?>
        <img class="food-detail-picture-img" src="<?= $data["food"]?->getPicture() ?>" alt="">
        <form action="?c=foodOffer&a=saveFile&foodId=<?= $data["food"]->getId() ?>" method="post" enctype="multipart/form-data">
            <label for="file"></label>
            <input type="file" name="file" id="file" accept=".jpg, .jpeg, .png">
            <br>
            <input id="food-detail-file-save" type="submit" name="submit" value="Upload">
            <?php if ($data["food"]?->getPicture() != "") { ?>
                <a href="?c=foodOffer&a=deleteFile&foodId=<?= $data["food"]->getId() ?>"
                   class="food-detail-picture-delete-btn btn btn-danger">Delete file</a>
            <?php } ?>
            <?php if (isset($data["error"])) { ?>
                <span class="errors"><?= $data["error"] ?></span><br>
            <?php } ?>
        </form>
    <?php } else { ?>
        <img class="food-detail-picture-img" src="<?= $data["food"]?->getPicture() ?>" alt="">
    <?php } ?>
    <?php if ($data["food"]?->getWeight() !== null) { ?>
        <div class="food-detail-weight">
            <strong>Obsah jedla: </strong>
            <?php echo $data["food"]?->getWeight(); echo " " . $data["food"]->getWeightUnit() ?>
        </div>
    <?php } ?>
    <div class="food-detail-price">
        <strong>Cena: </strong><?php echo $data["food"]?->getPrice(); echo " " . $data["food"]?->getPriceUnit() ?>
    </div>
</div>
