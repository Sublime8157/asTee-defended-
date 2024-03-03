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
    $('#errorMessage').toggle();
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


// make sure the html file was loaded before processing to this function
$(document).ready(function(){
    //  set a "change" listener for the tag with the image id 
    $('#image').change(function(){
        // pass the user input to the function below using the this keyword
        previewImage(this);
    });
});

// get the input in a tag with image id assign to parameter 
function previewImage(input) {
    // check the parameter if there are file input happen  
    if(input.files && input.files[0]) {
        // create a new object for file reader 
        var reader = new FileReader();
        // when the file input done loading createa run this function 
        reader.onload = function (e) {
            // get the image-preview set its src attribute to whatever is insid the input file 
            $('#image-preview').attr('src', e.target.result); 
            // change the image preview from display none to display block 
            $('#image-preview').css('display', 'block');
        }
        // read the user input file 
        reader.readAsDataURL(input.files[0]);
    }
}
// for filtering products in on hand tab 
$(document).ready(function(){
    $('#filterOnHandForm').submit(function(e){
       e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/filterOnHandProducts',
            type: 'GET',
            data: formData,
            success: function(response) {
               $('#productTableBody').html(response);
            }
        });
    });
});

// for filtering products in on processing tab 
$(document).ready(function(){
    $('#filterProcessingForm').submit(function(e){
       e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/filterProcessingProducts',
            type: 'GET',
            data: formData,
            success: function(response) {
               $('#productTableBody').html(response);
            }
        });
    });
});

// for filtering products in on processing tab 
$(document).ready(function(){
    $('#filterReturnCancelForm').submit(function(e){
       e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/filterCancelReturn',
            type: 'GET',
            data: formData,
            success: function(response) {
               $('#productTableBody').html(response);
            }
        });
    });
});