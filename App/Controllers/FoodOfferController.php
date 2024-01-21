<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\Food;
use App\Models\FoodType;

class FoodOfferController extends AControllerBase
{

    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        switch ($action) {
            case "add":
            case "store":
            case "edit":
            case "delete":
            case "editDescription":
            case "saveFile":
            case "deleteFile":
                return $this->app->getAuth()->isLogged();
            default:
                return true;
        }
    }

    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        $foodTypeId = (int)$this->request()->getValue("foodTypeId");
        $foodType = FoodType::getOne($foodTypeId);
        if ($foodType == null) {
            throw new HTTPException(404);
        }
        $foods = Food::getAll("foodTypeId_fk = ?", [$foodType->getId()]);
        return $this->html([
            "foods" => $foods,
            "foodType" => $foodType
        ]);
    }

    public function add(): Response {
        $foodTypeId = (int)$this->request()->getValue("foodTypeId");
        $foodType = FoodType::getOne($foodTypeId);
        if (isset($foodType)) {
            return $this->html([
                "food" => new Food(),
                "action" => "Pridať",
                "foodType" => $foodType], viewName: "add.form");
        } else {
            throw new HTTPException(404);
        }
    }

    public function store(): Response {
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
        if ($text == "") {
            $data["errors"]["text"] = "Text musí byť vyplnený";
        } else {
            $food->setName($text);
        }

        $price = $this->request()->getValue("price");
        if (!is_numeric($price)) {
            $data["errors"]["price"] = "Cena musí byť kladné číslo";
        } else {
            if ($price < 0) {
                $data["errors"]["price"] = "Cena musí byť kladné číslo";
            } else {
                $food->setPrice($price);
            }
        }

        $priceUnit = $this->request()->getValue("price-unit");
        if ($priceUnit == "") {
            $data["errors"]["priceUnit"] = "Jednotka sumy musí byť vyplnená";
        } else {
            $food->setPriceUnit($priceUnit);
        }

        $weight = $this->request()->getValue("weight");
        if ($weight != "") {
            if (!is_numeric($weight)) {
                $data["errors"]["weight"] = "Hmotnosť musí byť kladné číslo";
            } else {
                $weight = (int)$weight;
                if ($weight < 0) {
                    $data["errors"]["weight"] = "Hmotnosť musí byť kladné číslo";
                } else {
                    $food->setWeight($weight);
                }
            }
        }

        $weightUnit = $this->request()->getValue("weight-unit");
        if ($weight != "") {
            if ($weightUnit == "") {
                $data["errors"]["weightUnit"] = "Jednotka sumy musí byť vyplnená";
            } else {
                $food->setWeightUnit($weightUnit);
            }
        } else {
            $food->setWeightUnit("");
        }

        $ingredients = $this->request()->getValue("ingredients");
        if (empty(trim($ingredients))) {
            $data["errors"]["ingredients"] = "Zloženie jedla musí byť vyplnený";
            $food->setIngredients("");
        } else {
            $food->setIngredients($ingredients);
        }

        $foodTypeId = (int)$this->request()->getValue("foodTypeId");
        $foodType = FoodType::getOne($foodTypeId);
        if (!isset($foodType)) {
            $data["errors"]["foodType"] = "Zlý request";
        }

        if (!isset($data["errors"])) {
            $food->setFoodTypeIdFk($foodType->getId());
            $food->save();
            return $this->redirect("?c=foodOffer&foodTypeId=$foodTypeId");
        } else {
            $data["food"] = $food;
            $data["foodType"] = $foodType;
            return $this->html($data, viewName: "add.form");
        }
    }

    public function edit(): Response {
        $id = (int)$this->request()->getValue("id");
        $foodToEdit = Food::getOne($id);
        if (isset($foodToEdit)) {
            $foodType = FoodType::getOne($foodToEdit->getFoodTypeIdFk());
            return $this->html([
                "food" => $foodToEdit,
                "foodType" => $foodType,
                "action" => "Upraviť"], viewName: "add.form");
        }
        throw new HTTPException(404);

    }

    public function delete(): Response {
        $id = (int)$this->request()->getValue("id");
        $foodToDelete = Food::getOne($id);
        if (isset($foodToDelete)) {
            $foodTypeId = $foodToDelete->getFoodTypeIdFk();
            $foodToDelete->delete();
            return $this->redirect("?c=foodOffer&foodTypeId=$foodTypeId");
        }
        throw new HTTPException(404);
    }

    public function getOneFood(): Response {
        $foodId = (int)$this->request()->getValue("foodId");
        $food = Food::getOne($foodId);
        if (isset($food)) {
            $foodType = FoodType::getOne($food->getFoodTypeIdFk());
            return $this->html([
                "food" => $food,
                "foodType" => $foodType],
                "detail");
        } else {
            throw new HTTPException(404);
        }
    }

    public function editDescription(): Response {
        $data = [];
        $foodToEditId = (int)$this->request()->getValue("foodId");
        $foodToEdit = Food::getOne($foodToEditId);
        if (isset($foodToEdit)) {
            $description = $this->request()->getValue("description");
            $foodToEdit->setDescription($description);
            $foodToEdit->save();
            $data["food"] = $foodToEdit;
            $data["foodType"] = FoodType::getOne($foodToEdit->getFoodTypeIdFk());
            return $this->html($data, "detail");
        } else {
            throw new HTTPException(404);
        }
    }

    public function saveFile() {
        $foodId = (int)$this->request()->getValue("foodId");
        $food = Food::getOne($foodId);
        if (!isset($food)) {
            throw new HTTPException(404);
        }
        $foodTypeId = $food?->getFoodTypeIdFk();
        $foodType = FoodType::getOne($foodTypeId);
        $file = $this->request()->getFiles()["file"];
        if (isset($file)) {
            if (empty(trim($file["name"]))) {
                return $this->html([
                    "food" => $food,
                    "foodType" => $foodType,
                    "error" => "Nebol vybratý súbor"
                ], "detail");
            } else {
                if (!in_array($file['type'], ['image/jpg', 'image/jpeg', 'image/png'])) {
                    return $this->html([
                        "food" => $food,
                        "foodType" => $foodType,
                        "error" => "Súbor musí byť typu jpg/jpeg/png"
                    ], "detail");
                }
                $time = hrtime(true);
                $fileName = $time . "-" . $file["name"];
                $fullFilePath = "public/images/" . $fileName;
                if (move_uploaded_file($file["tmp_name"], $fullFilePath)) {
                    $picture = $food->getPicture();
                    if (isset($picture) && file_exists($picture)) {
                        unlink($food->getPicture());
                    }
                    $food->setPicture($fullFilePath);
                    $food->save();
                    return $this->html([
                        "food" => $food,
                        "foodType" => $foodType
                    ], "detail");
                } else {
                    return $this->html([
                        "food" => $food,
                        "foodType" => $foodType,
                        "error" => "Súbor sa nepodarilo nahrať"
                    ], "detail");
                }
            }
        } else {
            throw new HTTPException(400);
        }
    }

    public function deleteFile() {
        $foodId = $this->request()->getValue("foodId");
        $food = Food::getOne($foodId);
        if (isset($food)) {
            unlink($food->getPicture());
            $food->setPicture("");
            $food->save();
            $foodType = FoodType::getOne($food->getFoodTypeIdFk());
            return $this->html([
                "food" => $food,
                "foodType" => $foodType
            ], "detail");
        } else {
            throw new HTTPException(404);
        }
    }
}