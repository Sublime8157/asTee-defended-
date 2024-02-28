var sideNav = $('#nav');
var icon = true;
var addProdCloseBtn = $('#closeBtn');
var desc = $('#desc');
var quantity = $('#quantity');
var price = $('#price');
var saveMoreBtn = $('#saveMoreBtn');


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
function successMessage() {
    var showMessage = $('#successMessage');
    showMessage.css('display', 'block');

    setTimeout(function() {
        showMessage.css('display', 'none');
    }, 2000);
}

$('#updateTable').on('click', () => {
    location.reload();
})

// ajax function for adding a product in onhand table 
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
                successMessage();
                $('#desc').val('');
                $('#quantity').val('');
                $('#price').val('');
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

// Ajax for adding procuts in processing table 

// ajax function for adding a product in onhand table 
$(document).ready(function(){
    $('#submitFormProcess').submit(function(e){
       e.preventDefault();
        var regFormData = new FormData(this);
        $.ajax({
            url: '/storeProcessing',
            method: 'POST',
            data: regFormData,
            contentType: false,
            processData: false,
            success: function() {
                successMessage();
                $('#desc').val('');
                $('#quantity').val('');
                $('#price').val('');
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



