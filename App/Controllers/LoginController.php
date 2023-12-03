<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

class LoginController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        return $this->html(viewName: "login.form");
    }
}