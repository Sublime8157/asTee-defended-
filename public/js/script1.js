var signup = $('#signup');
var showSignupForm =  document.getElementById('signup_container');
var esc = $('#escape');
var navbar_main = $('#navbar-main');

// Fix the navbar to the top when scrolling
window.addEventListener("scroll", function(){
    var navbar = document.getElementById('navbar');
    navbar.classList.toggle('fixedNavBar', window.scrollY > 100);
    navbar_main.addClass('top-29');

});

// Reveale the signup form

function revealForm(){
    showSignupForm.showModal();
}
// Close  the signup Form
esc.on('click', function(){
    showSignupForm.setAttribute('closing', "");
    showSignupForm.addEventListener('animationend', () => {
        showSignupForm.removeAttribute('closing');
        showSignupForm.close();
    }, {once: true})
    
});

// Responsive navigation bar
function Menu(e) {    
    e.name === 'menu' ? (e.name =  'close', navbar_main.css('left', '0')) : (e.name = 'menu', navbar_main.css('left', '-200px'));
}

function showMessage(){
    var successMessage = $('#successMessage');
    successMessage.toggle();   
}


// Ajax request for the signup form 
$(document).ready(function(){
    $('#regForm').submit(function(e){
        e.preventDefault();
        var regFormData = new FormData(this);
        $.ajax({
            url: '/store',
            method: 'POST',
            data: regFormData,
            contentType: false,
            processData: false,
            success: function() {
                showMessage();
            },
            error: function(error) {
                if(error.responseJSON) {
                    var regError = error.responseJSON.message;
                    $('#errorMessage').text(regError);
                }
                else {
                    console.log('Error Occured', error.statusText);
                }
            }
        });
    });
});





// Loading Button 
signupButton = $('#submitRegister');

signupButton.on('click', function(){
    
    signupButton.addClass('submitButton');
    signupButton.css('color', '#e3a008');
    
    setTimeout(() => {
       
        signupButton.removeClass('submitButton');
        signupButton.css('color', 'black');
    }, 1000);

})

// Show and hide the password function 
var revPass = $('.revealPassword').on('click', function(){
    var password = $('.password');
    var revealPass = $('.revealPassword');


    if(password.prop('type') === 'password' && revealPass.attr('name') === 'eye-off-outline') {
        password.prop('type', 'text');
        revealPass.attr('name','eye-outline');
    }
    else {
        password.prop('type', 'password');
        revealPass.attr('name', 'eye-off-outline');
    }
})


