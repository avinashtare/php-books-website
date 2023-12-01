let show_menu_btn = document.getElementById("show-menu")
let navigation_menu_area = document.querySelector(".navigation-menu-area")

show_menu_btn.addEventListener("click", () => {
    if(navigation_menu_area.classList[1] == "hide"){
        navigation_menu_area.classList.remove("hide");
    }
    else{
        navigation_menu_area.classList.add("hide");
    }
});