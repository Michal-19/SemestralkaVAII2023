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
        return $this->html(new Food(), viewName: "add.form");
    }

    public function store() {
        $id = $this->request()->getValue("id");
        if ($id) {
            $food = Food::getOne($id);
        } else {
            $food = new Food();
        }
        $food->setName($this->request()->getValue("text"));
        $food->setPrice($this->request()->getValue("price"));
        $food->save();
        return $this->redirect("?c=foodOffer");
    }

    public function edit() {
        $id = $this->request()->getValue("id");
        $foodToEdit = Food::getOne($id);
        return $this->html($foodToEdit, viewName: "add.form");
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