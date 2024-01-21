<?php
use App\Core\IAuthenticator;

/** @var Array $data */
/** @var IAuthenticator $auth */
?>
<?php if (empty(trim($data["day"]))) { ?>
    <h1 class="main-title">Obedové menu sú iba v pracovných dňoch</h1>
<?php } else { ?>
    <h1 class="main-title">Dnešné obedové menu</h1>
<?php } ?>
<div class="menu-container" id="menu-container-id">
    <?php foreach ($data["menu"] as $menu) { ?>
        <div class="menu" id="menu-id-<?= $menu->getId() ?>">
            <h1 class="menu-title"><strong><?= $menu->getName() ?></strong></h1>
            <label class="menu-soap-label">
                <strong>Polievka</strong>
            </label><br>
            <div class="menu-soap">
                <?= $menu->getSoup() ?>
            </div>
            <label class="menu-main-food-label">
                <strong>Hlavné jedlo</strong><br>
            </label>
            <div class="menu-main-food">
                <?= $menu->getMainFood() ?>
            </div>
            <div class="menu-price">
                <strong>Cena:</strong>
                <?php echo $menu->getPrice(); echo " " . $menu->getPriceUnit()?>
            </div>
            <?php if ($auth->isLogged()) { ?>
                <a href="?c=home&a=editMenu&id=<?= $menu->getId() ?>" class="btn btn-warning" id="menu-edit-btn">Edit</a>
                <a class="btn btn-danger"
                   id="menu-delete-btn"
                   onclick="document.menuService.deleteMenu(<?= $menu->getId() ?>)">
                    Delete
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php if ($auth->isLogged()) { ?>
    <label class="menu-day-label">
        Vyberte deň menu<br>
        <select class="menu-day-select" name="day" onchange="document.menuService.getAllMenusByDay(this.value)">
            <option value="pondelok" <?php echo ($data["day"] == "pondelok" || $data["day"] == "") ? "selected" : ""; ?>>pondelok</option>
            <option value="utorok" <?php echo ($data["day"] == "utorok") ? "selected" : ""; ?>>utorok</option>
            <option value="streda" <?php echo ($data["day"] == "streda") ? "selected" : ""; ?>>streda</option>
            <option value="štvrtok" <?php echo ($data["day"] == "štvrtok") ? "selected" : ""; ?>>štvrtok</option>
            <option value="piatok" <?php echo ($data["day"] == "piatok") ? "selected" : ""; ?>>piatok</option>
        </select>
    </label><br>
    <a class="btn btn-success menu-add-btn" href="?c=home&a=addMenu">Pridať obedové menu</a>
<?php } ?>
