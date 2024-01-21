<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\User;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     *
     * @return RedirectResponse|Response
     */
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Login a user
     * @return RedirectResponse|\App\Core\Responses\ViewResponse
     */
    public function login(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        $logged = null;
        if (isset($formData['submit'])) {
            $logged = false;
            $user = User::getOne($formData['login']);
            if (isset($user)) {
                $logged = $this->app->getAuth()->login($formData['password'], $user->getPassword(), $user->getLogin());
                if ($logged) {
                    return $this->redirect('?c=home');
                }
            }
        }

        $data["errors"] = ($logged === false ? ['message' => 'Zlý login alebo heslo!'] : []);
        return $this->html($data);
    }

    /**
     * Logout a user
     * @return \App\Core\Responses\ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->html(viewName: "logout");
    }

    public function register(): Response {
        return $this->html([
            "user" => new User(),
            "action" => "Register"
        ], viewName: "register.form");
    }

    public function store(): Response {
        $login = $this->request()->getValue("login");
        $password = $this->request()->getValue("password");
        $passwordAgain = $this->request()->getValue("password-again");
        $user = new User();
        if (isset($login) && isset($password) && isset($passwordAgain)) {
            $user->setLogin($login);
            if (empty(trim($login))) {
                $data["errors"]["login"] = "Login musí byť vyplnený";
            } else if (User::getOne($login)) {
                $data["errors"]["login"] = "Užívateľ s loginom " . $login . " už existuje";
            }
            if (empty(trim($password)) && empty(trim($passwordAgain))) {
                $data["errors"]["password"] = "Heslá musia byť vyplnené";
            }
            if ($password != $passwordAgain) {
                $data["errors"]["password"] = "Heslá sa nezhodujú";
            }
            if (!isset($data["errors"])) {
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
                $user->save();
                return $this->redirect(Configuration::LOGIN_URL);
            }
        } else {
            $data["errors"]["password"] = "Nesprávne meno alebo heslo";
        }
        return $this->html([
            "user" => $user,
            "action" => "Register",
            "errors" => $data["errors"]
        ], viewName: "register.form");
    }
}