function sideBarActions(){
    //opens and closes the filters section
    const button = document.querySelector("#filterPage button");

    if(!button){
        return;
    }

    const navbar = document.querySelector("#filterPage aside")

    button.onclick = function(event){
        navbar.classList.toggle("open");
    }
}

sideBarActions();