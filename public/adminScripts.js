var sideNav = $('#nav');
var icon = true;
var addProdCloseBtn = $('#closeBtn')
// This is just for showing and hiding the nav 
function Menu(e) {
   if(icon) {
    sideNav.css({
        'position' : 'fixed',
        'left' : '-200px'
    });
    icon = false;
   }
   else {
    sideNav.css({
        'position' : 'relative',
        'left' : '0px'
    });
    icon = true;
   }
}
// Function for revealing and hiding the add product form 

var addProductForm = document.getElementById('addProdForm');
function revealForm() {
    addProductForm.showModal();
}

addProdCloseBtn.on('click', () => {
    addProductForm.setAttribute('closing', "");
    addProductForm.addEventListener('animationend', () => {
        addProductForm.removeAttribute('closing');
        addProductForm.close();
    }, {once: true})
})


function showMessage(){
    var successMessage = $('#successMessage');
    successMessage.toggle();   
}


$(document).ready(function(){
    $('#submitForm').submit(function(e){
       e.preventDefault();
        var regFormData = new FormData(this);
        $.ajax({
            url: '/addProducts',
            method: 'POST',
            data: regFormData,
            contentType: false,
            processData: false,
            success: function() {
               location.reload();
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
        })
    })
})
