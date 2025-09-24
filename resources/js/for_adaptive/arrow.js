//
// a function that allows you to display the menu after clicking
// on the arrow
//

// global variables
// for elements header
const btn_show_menu = document.getElementById("btn_show_menu");
const btn_close_menu = document.getElementById("btn_close_menu");

// first we check the screen size
window.addEventListener('resize', (e) => {
    const screenWidth = document.body.clientWidth;
    const header = document.getElementById("header_menu");

    if (screenWidth > 768) {
        btn
        header.classList.toggle("show");
    } else if (screenWidth < 768 ){

        header.classList.remove("show");
        header.classList.toggle("close");
    }

    
});

