<?php

/** @var Array $data */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Pizzeria Barbaricum</title>
</head>
<body>
<h1 class="login-title">Reštaurácia Barbaricum</h1>
<form class="login-form" method="post" action="<?= \App\Config\Configuration::LOGIN_URL ?>">
    <label class="login-form-login-label" for="login">login<br>
        <input class="login-form-login-input" name="login" type="text" id="login" placeholder="Enter your login">
    </label>
    <label class="login-form-password-label" for="password">password<br>
        <input class="login-form-password-input" name="password" type="password" id="password" placeholder="Enter your password"><br>
    </label><br>
    <div class="login-form-buttons">
        <button class="btn btn-success" type="submit" name="submit" id="login-button">login</button>
        <button class="btn btn-primary" onclick="location.href='?c=auth&a=register'" type="button" id="password-button">register</button>
    </div>
    <?php if (isset($data["errors"])) {
        foreach ($data["errors"] as $error) { ?>
            <span class="errors"><?= $error ?></span><br>
        <?php } ?>
    <?php } ?>
</form>
</body>
</html>