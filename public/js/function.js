var ePass = document.getElementById('fPass');
var eHide = document.getElementById('eHide');

var hidePass = function(){
    var status  = ePass.type;
    
    if(status === 'text'){
        ePass.type = 'password';
        eHide.className = 'far fa-eye-slash';
    }else{
        ePass.type = 'text';
        eHide.className = 'far fa-eye';
    }
}
function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}