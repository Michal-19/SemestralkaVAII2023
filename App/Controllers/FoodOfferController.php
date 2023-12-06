<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Food;

class FoodOfferController extends AControllerBase
{

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $foods = Food::getAll();
        return $this->html($foods);
    }

    public function add() {
        return $this->html(["food" => new Food(),
                            "action" => "Pridať"], viewName: "add.form");
    }

    public function store() {
        $id = $this->request()->getValue("id");
        $data = [];
        if ($id) {
            $food = Food::getOne($id);
            if (!$food) {
                return $this->redirect("?c=foodOffer");
            }
            $data["action"] = "Upraviť";
        } else {
            $food = new Food();
            $data["action"] = "Pridať";
        }
        $text = $this->request()->getValue("text");
        $price = $this->request()->getValue("price");
        $food->setName($text);
        $food->setPrice($price);
        if ($text && $price) {
            $food->save();
            return $this->redirect("?c=foodOffer");
        } else {
            $data["food"] = $food;
            if (!$text) {
                $data["errors"]["text"] = "text musí byť vyplnený";
            }
            if (!$price) {
                $data["errors"]["price"] = "price musí byť vyplnená";
            }
            return $this->html($data, viewName: "add.form");
        }

    }

    public function edit() {
        $id = $this->request()->getValue("id");
        $foodToEdit = Food::getOne($id);
        return $this->html(["food" => $foodToEdit,
                            "action" => "Upraviť"], viewName: "add.form");
    }

    public function delete() {
        $id = $this->request()->getValue("id");
        $foodToDelete = Food::getOne($id);
        if ($foodToDelete) {
            $foodToDelete->delete();
        }
        return $this->redirect("?c=foodOffer");
    }
}