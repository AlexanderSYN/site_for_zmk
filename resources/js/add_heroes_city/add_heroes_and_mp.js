// Используем правильный id из HTML
const image_hero = document.getElementById('get_image_hero');
const name_image_hero = document.getElementById('name_image_hero');
const image_hero_inp = document.getElementById('img_hero_input');

const image_hero_qr = document.getElementById('get_image_hero_qr');
const name_image_hero_qr = document.getElementById('name_image_hero_qr');
const image_hero_qr_inp = document.getElementById('img_hero_qr_input');


// добавить проверку на 10мб

image_hero.addEventListener('change', function() {
    name_image_hero.innerHTML = this.files[0].name;
    image_hero_inp.value = this.files[0].name;
});

// Добавляем обработчик для QR кода
image_hero_qr.addEventListener('change', function() {
    name_image_hero_qr.innerHTML = this.files[0].name;
    image_hero_qr_inp.value = this.files[0].name;
});