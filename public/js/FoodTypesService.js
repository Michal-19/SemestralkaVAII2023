import {FoodTypesApi} from "./FoodTypesApi.js";

class FoodTypesService {
    #foodTypeApi;
    constructor() {
        this.#foodTypeApi = new FoodTypesApi();
    }

    async addFoodType() {
        document.getElementById("food-type-btn-add-id").onclick = async () => {
            let foodTypeName = document.getElementById("food-type-input-add-id");
            let createdFoodType = await this.#foodTypeApi.createFoodType(foodTypeName.value);
            if (createdFoodType.code === 412) {
                alert("Typ jedla musí byť zadaný");
            } else if (createdFoodType.code === undefined) {
                foodTypeName.value = "";
                let loadedFoodTypes = document.getElementById("food-types-container-id").innerHTML;
                loadedFoodTypes += `<div class="food-type" id="food-type-id-${createdFoodType.id}">
                                        <input class="food-type-input-edit" 
                                               id="food-type-input-edit-id-${createdFoodType.id}" 
                                               value="${createdFoodType.name}">
                                        <br>
                                        <div class="food-type-created-by">Vytvorené používateľom: ${createdFoodType.createdBy}</div>
                                        <div class="food-type-created-time">Vytvorené: ${createdFoodType.createdTime}</div>
                                        <div class="food-type-edited-by">Naposledy upravené používteľom: ${createdFoodType.lastEditedBy}</div>
                                        <div class="food-type-edited-time">Naposledy vytvorené: ${createdFoodType.lastEditedTime}</div>
                                        <a class="btn btn-primary" href="?c=foodOffer&foodTypeId=${createdFoodType.id}">Ukáž jedla</a>   
                                        <a class="btn btn-warning" 
                                           id="food-type-btn-edit-id-${createdFoodType.id}" 
                                           onClick="document.foodTypesService.editFoodType(${createdFoodType.id})">Edit
                                        </a>
                                        <a class="btn btn-danger" 
                                           id="food-type-btn-delete-id" 
                                           onclick="document.foodTypesService.deleteFoodType(${createdFoodType.id})">Delete
                                        </a>
                                    </div>`;
                document.getElementById("food-types-container-id").innerHTML = loadedFoodTypes;
                alert("Typ jedla bol úspešne pridaný");
            } else {
                alert(createdFoodType.status);
            }
        }
    }
    async editFoodType(id) {
        let foodTypeInputElement = document.getElementById(`food-type-input-edit-id-${id}`);
        if (foodTypeInputElement !== undefined) {
            let editedFoodType = await this.#foodTypeApi.editFoodType(id, foodTypeInputElement.value);
            if (editedFoodType.code === undefined) {
                let lastEditedFoodTypeTyUserElement = document.getElementById(`food-type-edited-by-id-${id}`);
                lastEditedFoodTypeTyUserElement.innerText = "Naposledy upravené používateľom: " + editedFoodType.lastEditedBy;
                let lastEditedFoodTypeTimeElement = document.getElementById(`food-type-edited-time-id-${id}`);
                lastEditedFoodTypeTimeElement.innerText = "Naposledy upravené: " + editedFoodType.lastEditedTime;
                alert("Typ jedla bol úspešne zmenený");
            } else {
                alert(editedFoodType.status);
            }
        }
    }

    async deleteFoodType(id) {
        let deletedFoodType = await this.#foodTypeApi.deleteFoodType(id);
        if (deletedFoodType.code === undefined) {
            let deletedFoodTypeElement = document.getElementById(`food-type-id-${id}`);
            deletedFoodTypeElement.style.display = "none";
            alert("Typ jedla bol úspešne odstránený");
        } else {
            alert(deletedFoodType.status);
        }
    }
}

export {FoodTypesService}