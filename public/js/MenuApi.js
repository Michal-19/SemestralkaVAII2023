import {RequestSender} from "./RequestSender.js";

class MenuApi {
    #requestSender

    constructor() {
        this.#requestSender = new RequestSender("home");
    }

    async deleteMenu(id) {
        return await this.#requestSender.sendRequest(
            "deleteMenu",
            "POST",
            204,
            {
                "id": id
            },
            false);
    }

    async getAllMenuByDay(day) {
        return await this.#requestSender.sendRequest(
            "getAllMenuByDay",
            "POST",
            200,
            {
                "day": day
            },
            false);
    }
}

export {MenuApi}