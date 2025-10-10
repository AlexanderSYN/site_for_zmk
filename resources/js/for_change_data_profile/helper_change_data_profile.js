//----------------------------------------------
// getting all inputs
//----------------------------------------------
const input_profile_name = document.getElementById('profile_name');
const input_profile_last_name = document.getElementById('profile_last_name');
const input_profile_patronymic = document.getElementById('profile_patronymic');
const input_profile_login = document.getElementById('profile_login');
const input_profile_email = document.getElementById('profile_email');

//----------------------------------------------
// getting all buttons
//----------------------------------------------
const btn_edit = document.getElementById('btn_edit');
const btn_done = document.getElementById('btn_done');

//----------------------------------------------
// checking by clicking on the edit button
//----------------------------------------------
btn_edit.addEventListener('click', function() {
    //----------------------------------------------
    // enable the done button and all inputs
    //----------------------------------------------
    btn_done.disabled = false;
    btn_done.classList.add('show');
    btn_done.style = "background: #34C759";

    input_profile_name.disabled = false;
    input_profile_last_name.disabled = false;
    input_profile_patronymic.disabled = false;
    input_profile_login.disabled = false;
    input_profile_email.disabled = false;

    //----------------------------------------------
    // disabled the edit button
    //----------------------------------------------
    btn_edit.style = "background-color: gray; cursor: auto";
    btn_edit.disabled = true;
});

