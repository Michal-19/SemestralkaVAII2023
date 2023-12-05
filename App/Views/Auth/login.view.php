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
<div class="backround-login"></div>
<div class="container-login">
    <h1>Reštaurácia Barbaricum</h1>
    <div class="text-center text-danger mb-3">
        <?= @$data['message'] ?>
    </div>
    <form class="form-signin" method="post" action="<?= \App\Config\Configuration::LOGIN_URL ?>">
        <div class="form-item">
            <label for="login">login</label><br>
            <input name="login" type="text" id="login" placeholder="Enter your login">
        </div>
        <div class="form-item">
            <label for="password">password</label><br>
            <input name="password" type="password" id="password" placeholder="Enter your password">
        </div>
        <div class="option">
            <button type="submit" name="submit" id="login-button">login</button>
            <button onclick="location.href='?c=home'" type="button" id="password-button">register</button>
        </div>
    </form>
</div>
</body>
</html>