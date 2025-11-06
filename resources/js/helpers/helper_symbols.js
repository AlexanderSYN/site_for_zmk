//============================================
// Helper for checking whether the text input 
// limit in textarea is exceeded for describing
// something (max: 500)
//
// Хелпер для проверки превышение лимита
// вводимого текста в textarea для
// описания чего-либо (max: 500)
//============================================

// check symbols
// проверить сиволы
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
        btn_add.style.cursor = "auto";
    } else {
        symbols.style.color = '';
        btn_add.style.backgroundColor = '#2C2C2C'; 
        btn_add.disabled = false;
        btn_add.style.cursor = "pointer";
    }
}
description.addEventListener('input', update_symbol_count);
document.addEventListener("DOMContentLoaded", function() {
    update_symbol_count();
});