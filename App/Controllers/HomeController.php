<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\FoodType;
use App\Models\Menu;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{
    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        switch ($action) {
            case "addMenu":
            case "editMenu":
            case "store":
            case "deleteMenu":
                return $this->app->getAuth()->isLogged();
            default:
                return true;
        }
    }

    /**
     * Example of an action (authorization needed)
     * @return \App\Core\Responses\Response|\App\Core\Responses\ViewResponse
     */
    public function index(): Response {
        $day = $this->request()->getValue("day");
        if (!isset($day)) {
            $day = date("l");
            $day = $this->translateDay($day);
            if (empty(trim($day))) {
                $day = "pondelok";
            }
        }
        $allMenus = Menu::getAll("day = ?", [$day]);
        return $this->html([
            "menu" => $allMenus,
            "day" => $day
        ]);
    }

    public function getAllMenuByDay() {
        $requestJSON = $this->request()->getRawBodyJSON();
        if (is_object($requestJSON) && property_exists($requestJSON, "day")) {
            if (empty(trim($requestJSON->day))) {
                throw new HTTPException(404, "Deň nie je vyplnený");
            }
            return $this->json(Menu::getAll("day = ?", [$requestJSON->day]));
        }
        throw new HTTPException(400, "Zlá štruktúra požiadavky");
    }

    public function addMenu(): Response {
        return $this->html([
            "menu" => new Menu(),
            "action" => "Pridať"
        ], "addMenu.form");
    }

    public function editMenu(): Response {
        $menuId = (int)$this->request()->getValue("id");
        $menuToEdit = Menu::getOne($menuId);
        if (!isset($menuToEdit)) {
            throw new HTTPException(404);
        }
        return $this->html([
            "menu" => $menuToEdit,
            "action" => "Edit"
        ], "addMenu.form");
    }

    public function store(): Response {
        $menuId = $this->request()->getValue("menuId");
        $data = [];
        if (isset($menuId)) {
            $menu = Menu::getOne($menuId);
            if (!isset($menu)) {
                return $this->redirect("?c=home");
            }
            $data["action"] = "Upraviť";
        } else {
            $menu = new Menu();
            $data["action"] = "Pridať";
        }

        $menuName = $this->request()->getValue("name");
        if (!isset($menuName)) {
            throw new HTTPException(400);
        } elseif (empty(trim($menuName))) {
            $data["errors"]["emptyName"] = "Názov menu musí byť vyplenený";
        } else {
            $menu->setName($menuName);
        }

        $soup = $this->request()->getValue("soup");
        if (!isset($soup)) {
            throw new HTTPException(400);
        } elseif (empty(trim($soup))) {
            $data["errors"]["emptySoup"] = "Polievka musí byť vyplenná";
        } else {
            $menu->setSoup($soup);
        }

        $mainFood = $this->request()->getValue("mainFood");
        if (!isset($mainFood)) {
            throw new HTTPException(400);
        } elseif (empty(trim($mainFood))) {
            $data["errors"]["emptyMainFood"] = "Hlavné jedlo musí byť vyplnené";
        } else {
            $menu->setMainFood($mainFood);
        }

        $day = $this->request()->getValue("day");
        if (!isset($day)) {
            throw new HTTPException(400);
        } elseif (empty(trim($day))) {
            $data["errors"]["emptyDay"] = "Deň musí byť vyplnený";
            $day = date("l");
            $day = $this->translateDay($day);
        } else {
            $menu->setDay($day);
        }

        $price = $this->request()->getValue("price");
        if (!isset($price)) {
            throw new HTTPException(400);
        } elseif (empty(trim($price))) {
            $data["errors"]["emptyPrice"] = "Suma menu musí byť byplnená";
        } elseif (!is_numeric($price) or $price < 0) {
            $data["errors"]["nonNumericPrice"] = "Cena menu musí byť kladné číslo";
        } else {
            $menu->setPrice($price);
        }

        $priceUnit = $this->request()->getValue("price-unit");
        if (!isset($priceUnit)) {
            throw new HTTPException(400);
        } elseif (empty(trim($priceUnit))) {
            $data["errors"]["emptyPriceUnit"] = "Mena sumy musí byť vyplnená";
        } else {
            $menu->setPriceUnit($priceUnit);
        }

        if (!isset($data["errors"])) {
            $menu->save();
            return $this->redirect('?c=home&day=' . $day);
        } else {
            $data["menu"] = $menu;
            return $this->html($data, "addMenu.form");
        }
    }

    public function deleteMenu(): Response {
        $idMenuToDelete = $this->request()->getRawBodyJSON();
        if (is_object($idMenuToDelete) &&
            property_exists($idMenuToDelete, "id")) {
            $menuToDelete = Menu::getOne($idMenuToDelete->id);
            if (isset($menuToDelete)) {
                $menuToDelete->delete();
                $menuToDelete->save();
                return $this->json($menuToDelete);
            }
            throw new HTTPException(404);
        }
        throw new HTTPException(400);
    }

    public function translateDay($day): string {
        return match ($day) {
            "Monday" => "pondelok",
            "Tuesday" => "utorok",
            "Wednesday" => "streda",
            "Thursday" => "štvrtok",
            "Friday" => "piatok",
            default => "",
        };
    }
}
