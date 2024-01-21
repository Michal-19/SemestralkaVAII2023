import {MenuApi} from "./MenuApi.js";

class MenuService {
    #menuApi;
    constructor() {
        this.#menuApi = new MenuApi();
    }

    async deleteMenu(id) {
        let deletedMenu = await this.#menuApi.deleteMenu(id);
        if (deletedMenu.code === undefined) {
            let deletedMenuElement = document.getElementById(`menu-id-${id}`);
            deletedMenuElement.style.display = "none";
            alert("Typ jedla bol úspešne odstránený");
        } else {
            alert(deletedMenu.status);
        }
    }

    async getAllMenusByDay(day) {
        let allMenusByDay = await this.#menuApi.getAllMenuByDay(day);
        if (allMenusByDay.code === undefined) {
            let containerMenuElement = document.getElementById(`menu-container-id`);
            containerMenuElement.innerHTML = "";
            allMenusByDay.forEach((menu) => {
                containerMenuElement.innerHTML +=
                `<div class="menu" id="menu-id-${menu.id}">
                    <h1 class="menu-title"><strong>${menu.name}</strong></h1>
                    <label class="menu-soap-label">
                        <strong>Polievka</strong>
                    </label><br>
                    <div class="menu-soap">
                        ${menu.soup}
                    </div>
                    <label class="menu-main-food-label">
                        <strong>Hlavné jedlo</strong><br>
                    </label>
                    <div class="menu-main-food">
                        ${menu.mainFood}
                    </div>
                    <div class="menu-price">
                        <strong>Cena</strong>
                        ${menu.price} ${menu.priceUnit}
                    </div>
                    <a href="?c=home&a=editMenu&id=${menu.id}" class="btn btn-warning" id="menu-edit-btn">Edit</a>
                    <a class="btn btn-danger"
                       id="menu-delete-btn"
                       onClick="document.menuService.deleteMenu(${menu.id}">
                        Delete
                    </a>
                </div>`
            });
        } else {
            alert(allMenusByDay.status);
        }
    }
}

export {MenuService}