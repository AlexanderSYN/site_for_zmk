//
// a function that allows you to display 
// the menu after clicking on the arrow
//

// global variables
// screen size
const screenWidth = window.screen.width;

// to check, click the show menu button
var is_clicked_show_menu = false;

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
    
    //
    // if the show menu button is already pressed, then display 
    // the menu
    // otherwise hide the menu
    //
    if (is_clicked_show_menu) {
        // hide buttons
        arrows.style.display = 'flex';
        btn_show_menu.style.display = 'none';
        btn_close_menu.style.display = 'initial'; 
        // show header
        header_logo.style.display = 'flex';
        header_menu.style.display = 'flex';
        header_btn_entry.style.display = 'initial';

        header.classList.remove("close");
        header.classList.toggle("show");
    } else {
        // show buttons
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

        //
        // if the show menu button is already pressed, then display 
        // the menu
        // otherwise hide the menu
        //
        if (is_clicked_show_menu) {
            // hide buttons
            arrows.style.display = 'flex';
            btn_show_menu.style.display = 'none';
            btn_close_menu.style.display = 'initial'; 
            // show header
            header_logo.style.display = 'flex';
            header_menu.style.display = 'flex';
            header_btn_entry.style.display = 'initial';

            header.classList.remove("close");
            header.classList.toggle("show");
        } else {
            // show buttons
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
    }
});


//
// if you click on the show menu button, 
// the menu will be displayed
//
btn_show_menu.addEventListener('click', function() {
    is_clicked_show_menu = true;

    // hide btn_show_menu and close menu button
    btn_show_menu.style.display = 'none';
    btn_close_menu.style.display = 'initial';

    // show header
    header_logo.style.display = 'flex';
    header_menu.style.display = 'flex';
    header_btn_entry.style.display = 'initial';
});

//
// if you click on the close menu button, 
// the menu will be hidden
//
btn_close_menu.addEventListener('click', function() {
    is_clicked_show_menu = false;

    // hide btn_show_menu and close menu button
    btn_close_menu.style.display = 'none';
    btn_show_menu.style.display = 'initial';
    // show header
    header_logo.style.display = 'none';
    header_menu.style.display = 'none';
    header_btn_entry.style.display = 'none';
});



