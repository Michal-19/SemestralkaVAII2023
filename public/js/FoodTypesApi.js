import {RequestSender} from "./RequestSender.js";

class FoodTypesApi {
    #requestSender

    constructor() {
        this.#requestSender = new RequestSender("foodType");
    }

    async getAllFoodTypes() {
        return await this.#requestSender.sendRequest(
            "getAllFoodTypes",
            "POST",
            200,
            null,
            []);
    }

    async createFoodType(foodTypeName) {
        return await this.#requestSender.sendRequest(
            "createFoodType",
            "POST",
            200,
            {
                'foodTypeName': foodTypeName,
            },
            false);
    }

    async editFoodType(id, newFoodTypeName) {
        return await this.#requestSender.sendRequest(
            "editFoodType",
            "POST",
            200,
            {
                "id": id,
                "foodTypeName": newFoodTypeName
            },
            false);
    }

    async deleteFoodType(id) {
        return await this.#requestSender.sendRequest(
            "deleteFoodType",
            "POST",
            204,
            {
                "id": id
            },
            false);
    }
}

export {FoodTypesApi}