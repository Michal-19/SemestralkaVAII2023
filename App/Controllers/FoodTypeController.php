<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\Response;
use App\Models\Food;
use App\Models\FoodType;

class FoodTypeController extends AControllerBase
{

    /**
     * Authorize controller actions
     * @param $action
     * @return bool
     */
    public function authorize($action)
    {
        switch ($action) {
            case "createFoodType":
            case "editFoodType":
            case "deleteFoodType":
                return $this->app->getAuth()->isLogged();
            default:
                return true;
        }
    }

    public function index(): Response
    {
        $foodTypes = FoodType::getAll();
        return $this->html($foodTypes);
    }

    public function getAllFoodTypes(): Response
    {
        $foodTypes = FoodType::getAll();
        $jsonData = $this->json($foodTypes);
        return $jsonData;
    }

    public function createFoodType(): Response
    {
        $foodTypeToCreate = $this->request()->getRawBodyJSON();
        if (is_object($foodTypeToCreate) &&
            property_exists($foodTypeToCreate, "foodTypeName")) {
            if (!empty(trim($foodTypeToCreate->foodTypeName))) {
                $foodType = new FoodType();
                $foodType->setName($foodTypeToCreate->foodTypeName);
                $loggerUserName = $this->app->getAuth()->getLoggedUserName();
                if (isset($loggerUserName)) {
                    $foodType->setCreatedBy($loggerUserName);
                    $foodType->setCreatedTime(date("Y-m-d H:i:s"));
                    $foodType->setLastEditedBy($loggerUserName);
                    $foodType->setLastEditedTime(date("Y-m-d H:i:s"));
                    $foodType->save();
                    return $this->json($foodType);
                } else {
                    throw new HTTPException(403, "Unauthorized");
                }
            } else {
                throw new HTTPException(412, "foodTypeName is empty");
            }
        } else {
            throw new HTTPException(400, 'Bad foodType structure');
        }
    }

    public function editFoodType(): Response {
        $newFoodTypeProperties = $this->request()->getRawBodyJSON();
        if (is_object($newFoodTypeProperties) &&
            property_exists($newFoodTypeProperties, "id") &&
            property_exists($newFoodTypeProperties, "foodTypeName")) {
            if (empty(trim($newFoodTypeProperties->id))) {
                throw new HTTPException(412, "Id je prázdne");
            } elseif (empty(trim($newFoodTypeProperties->foodTypeName)))  {
                throw new HTTPException(412, "Typ jedla musí byť vyplnený");
            } else {
                $foodTypeToEdit = FoodType::getOne($newFoodTypeProperties->id);
                if ($foodTypeToEdit != null) {
                    $foodTypeToEdit->setName($newFoodTypeProperties->foodTypeName);
                    $foodTypeToEdit->setLastEditedBy($this->app->getAuth()->getLoggedUserName());
                    $foodTypeToEdit->setLastEditedTime(date("Y-m-d H:i:s"));
                    $foodTypeToEdit->save();
                    return $this->json($foodTypeToEdit);
                } else {
                    throw new HTTPException(404,"Typ jedla s id " . $newFoodTypeProperties->id . " neexistuje");
                }
            }
        } else {
            throw new HTTPException(400, 'Zlá štruktúra požiadavky');
        }
    }

    public function deleteFoodType(): Response {
        $idFoodTypeToDelete = $this->request()->getRawBodyJSON();
        if (is_object($idFoodTypeToDelete) &&
            property_exists($idFoodTypeToDelete, "id")) {
            $foodTypeToDelete = FoodType::getOne($idFoodTypeToDelete->id);
            if ($foodTypeToDelete == null) {
                throw new HTTPException(
                    404,
                    "Typ jedla s id " . $idFoodTypeToDelete->id . " nexistuje");
            }
            $foodCountWithFoodTypeToDelete = count(Food::getAll("foodTypeId_fk = ?", [$foodTypeToDelete->getId()]));
            if ($foodCountWithFoodTypeToDelete > 0) {
                throw new HTTPException(
                    400,
                    "Tento typ jedla obsahuje svoje jedla. Pre odstránenie odstráňte najprv jedlá tohoto typu");
            }
            $foodTypeToDelete->delete();
            $foodTypeToDelete->save();
            return $this->json($foodTypeToDelete);
        } else {
            throw new HTTPException(400, 'Zlá štruktúra požiadavky');
        }
    }
}