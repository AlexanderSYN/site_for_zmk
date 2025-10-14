//-------------------------------------------
// if the privaty policy checkbox is not 
// checked, then the register button is
// disabled, otherwise it is active
//-------------------------------------------
const btn_register = document.getElementById('btn_register');
const checkbox_private_policy = document.getElementById('check_privacy_policy');

checkbox_private_policy.addEventListener('change', function() {
    if (this.checked) {
        btn_register.disabled = false;
        btn_register.style = "background: #2C2C2C;";
    }
    else {
        btn_register.style = "background: gray;";
        btn_register.disabled = true;
    }
});