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

// function for inserting data into cancel or return products table 
$(document).ready(function(){
    // listen to the submitformcancelreturn id if it was submited 
    $('#submitFormCancelReturn').submit(function(e){
        // prevent the page from reloading 
       e.preventDefault();
        // store the form data in regformdata
        var regFormData = new FormData(this);
        $.ajax({
            // go the the storecancelreturn url where the storing happen 
            url: '/storeCancelReturn',
            method: 'POST',
            data: regFormData,
            contentType: false,
            processData: false,
            success: function() {
                // clear the fields when successfull
                successMessage();
                $('#desc').val('');
                $('#quantity').val('');
                $('#price').val('');
            },
            error: function(error) {
                if(error.responseJSON) {
                    // get the id errormessage and display in that id what is the error 
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

// function for showing the image, set a productId as a parameter so we  can get the value from the button 
function revealImage(productId) {
    // assign the productId(parameter) with imageDialog string 
    const dialogId = "imageDialog" + productId;
    // find the id in dom similar to the dialogId 
    const dialog =  document.getElementById(dialogId);
    // reveal the modal or the image 
    dialog.showModal();

}
