//---------------------------------------
// logic for showing and hiding password
//---------------------------------------
document.querySelectorAll('.password_control').forEach(function(button) {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        var targetId = this.getAttribute('data-target');
        var input = document.getElementById(targetId);
        
        if (input.getAttribute('type') == 'password') {
            this.classList.add('view');
            input.setAttribute('type', 'text');
        } else {
            this.classList.remove('view');
            input.setAttribute('type', 'password');
        }
    });
});