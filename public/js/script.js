function validateFoodForm() {
    let foodName = document.forms["crud-food"]["text"].value;
    let foodPrice = document.forms["crud-food"]["price"].value;
    if (foodName === "") {
        alert("Musíš zadať názov jedla!!!");
        return false;
    } else if (foodPrice < 0) {
        alert("Cena nemôže byť záporná");
        return false;
    } else if (foodPrice === "") {
        alert("Musíš zadať cenu jedla!!!");
        return false;
    } else {
        alert("Položku sa úspešne podarilo pridať");
        return true;
    }
}

function navbarMenu () {
    navbar = document.querySelector(".nav-bar");
    navbar.classList.toggle("active");
}