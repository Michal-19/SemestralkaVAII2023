<?php
/** @var Array $data */
?>
<h1 class="register-title">Registrácia užívateľa</h1>
<form class="register-form" method="post" action="?c=auth&a=store">
    <label class="register-form-login-label">Login<br>
        <input class="register-form-login-input input-prop" type="text" name="login" value="<?= $data["user"]->getLogin() ?>">
    </label><br>
    <label class="register-form-password-label">Heslo<br>
        <input class="register-form-password-input input-prop" type="password" name="password">
    </label><br>
    <label class="register-form-password-again-label">Zopakujte heslo<br>
        <input class="register-form-password-again-input input-prop" type="password" name="password-again">
    </label><br>
    <input class="input-prop" id="submit-button" type="submit" value="<?= $data["action"] ?>"><br>
    <?php if (isset($data["errors"])) {
        foreach ($data["errors"] as $error) { ?>
            <span class="errors"><?= $error ?></span><br>
        <?php } ?>
    <?php } ?>
</form>
