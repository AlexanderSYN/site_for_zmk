// for image
const image_hero = document.getElementById('get_image_hero');
const name_image_hero = document.getElementById('name_image_hero');
const image_hero_inp = document.getElementById('img_hero_input');

const image_hero_qr = document.getElementById('get_image_hero_qr');
const name_image_hero_qr = document.getElementById('name_image_hero_qr');
const image_hero_qr_inp = document.getElementById('img_hero_qr_input');

// check symbols
const symbols = document.getElementById('max_symbols');
const description = document.getElementById('description');
const btn_add = document.getElementById('btn_add');

let max_len = 500;
let len_symb = 0;

//================================
// logic character checking
// проверка на превышение лимита
// текста
//================================
function update_symbol_count() {
    const current_len = description.value.length;
    len_symb = current_len;
    symbols.innerHTML = `символов ${current_len} / ${max_len}`;

    // change the color if there are more than 500 characters.
    if (current_len > max_len) {
        symbols.style.color = 'red';
        btn_add.style.backgroundColor = 'gray'; 
        btn_add.disabled = true;
    } else {
        symbols.style.color = '';
        btn_add.style.backgroundColor = '#2C2C2C'; 
        btn_add.disabled = false;
    }
}
description.addEventListener('input', update_symbol_count);
document.addEventListener("DOMContentLoaded", function() {
    update_symbol_count();
});


//================================
// checking the hero's picture
//================================
image_hero.addEventListener('change', function() {
    const file = this.files[0];
    const file_size = file.size / 1024 / 1024;
    const file_type = file.type;

    const allowed_types = ["image/gif", "image/png", "image/jpg", "image/jpeg"];

    // check type
    if (!allowed_types.includes(file_type)) {
        name_image_hero.style.color = 'red';
        name_image_hero.innerHTML = "неверный формат файла!"
        this.value = '';

        btn_add.style.backgroundColor = 'gray'; 
        btn_add.disabled = true;
        return;
    } else {
        name_image_hero.style.color = "black";
    }

    // check size
    if (file_size >= 10) {
        name_image_hero.innerHTML = "превышен лимит!"
        name_image_hero.style.color = 'red';
        this.value = '';

        btn_add.style.backgroundColor = 'gray'; 
        btn_add.disabled = true;
    } else {
        name_image_hero.style.color = "black";
        name_image_hero.innerHTML = this.files[0].name;
        image_hero_inp.value = this.files[0].name;

        btn_add.style.backgroundColor = '#2C2C2C'; 
        btn_add.disabled = false;
    }

});

//==================================
// Added a handler for the QR code
// checking the hero's qr picture
//==================================
image_hero_qr.addEventListener('change', function() {
    const file = this.files[0];
    const file_size = file.size / 1024 / 1024;
    const file_type = file.type;

    const allowed_types = ["image/gif", "image/png", "image/jpg", "image/jpeg"];

    // check type
    if (!allowed_types.includes(file_type)) {
        name_image_hero_qr.style.color = 'red';
        name_image_hero_qr.innerHTML = "неверный формат файла!"
        this.value = '';

        btn_add.style.backgroundColor = 'gray'; 
        btn_add.disabled = true;
        return;
    } else {
        name_image_hero_qr.style.color = "black";
    }

    // check size
    if (file_size >= 10) {
        name_image_hero_qr.innerHTML = "превышен лимит!"
        name_image_hero_qr.style.color = 'red';
        this.value = '';

        btn_add.style.backgroundColor = 'gray'; 
        btn_add.disabled = true;
    } else {
        name_image_hero_qr.style.color = "black";
        name_image_hero_qr.innerHTML = this.files[0].name;
        image_hero_qr_inp.value = this.files[0].name;

        btn_add.style.backgroundColor = '#2C2C2C'; 
        btn_add.disabled = false;
    }
});