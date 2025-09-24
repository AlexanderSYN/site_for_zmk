//
// a function that allows you to display the menu after clicking
// on the arrow
//

// global variables
// screen size
const screenWidth = window.screen.width;

// btn arrows
const btn_show_menu = document.getElementById("btn_show_menu");
const btn_close_menu = document.getElementById("btn_close_menu");
const arrows = document.getElementById("arrows");

// header
const header_logo = document.getElementById("header_logo");
const header_menu_list = document.getElementById("header_menu");
const header_btn_entry = document.getElementById("header_actions");
const header = document.getElementById('up');


if (screenWidth > 768) {
        // hide btn for adaptive
        btn_show_menu.style.display = 'none';
        btn_close_menu.style.display = 'none';
        arrows.style.display = 'none';
        // show header
        header_logo.style.display = 'flex';
        header_menu.style.display = 'flex';
        header_btn_entry.style.display = 'initial';

        header.classList.toggle("show");
    } else if (screenWidth < 768 ){
        // visible btn
        arrows.style.display = 'inital';
        btn_show_menu.style.display = 'initial';
        btn_close_menu.style.display = 'none';  

        // hide header
        header_logo.style.display = 'none';
        header_menu.style.display = 'none';
        header_btn_entry.style.display = 'none';

        header.classList.remove("show");
        header.classList.toggle("close");
    }

// first we check the screen size
window.addEventListener('resize', (e) => {
    const screen_width = document.body.clientWidth;

    if (screen_width > 768) {
        // hide btn for adaptive
        arrows.style.display = 'none';
        btn_show_menu.style.display = 'none';
        btn_close_menu.style.display = 'none';
        // show header
        header_logo.style.display = 'flex';
        header_menu.style.display = 'flex';
        header_btn_entry.style.display = 'initial';

        header.classList.toggle("show");
    } else if (screen_width < 768 ){
        // visible btn
        arrows.style.display = 'flex';
        btn_show_menu.style.display = 'initial'; 
        btn_close_menu.style.display = 'none';  
        // hide header
        header_logo.style.display = 'none';
        header_menu.style.display = 'none';
        header_btn_entry.style.display = 'none';

        header.classList.remove("show");
        header.classList.toggle("close");
    }

    
});


