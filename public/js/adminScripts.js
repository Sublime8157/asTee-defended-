

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

$('#updateBtn').on('click', () => {
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
                $('#submitForm')[0].reset();
                $('#imagePreview').css('display','none');
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
// ajax function for adding a product in processing table 
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
                $('#submitFormProcess')[0].reset();
                $('#imagePreview').css('display','none');
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
                $('#submitFormCancelReturn')[0].reset();
                $('#imagePreview').css('display','none');
                $('#specify').css('display','none');
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
   // get the input in a tag with image id assign to parameter 
   function previewImage(input) {
    // check the parameter if there are file input happen  
    if(input.files && input.files[0]) {
        // create a new object for file reader 
        var reader = new FileReader();
        // when the file input done loading createa run this function 
        reader.onload = function (e) {
            // get the image-preview set its src attribute to whatever is insid the input file 
            $('#imagePreview').attr('src', e.target.result); 
            // change the image preview from display none to display block 
            $('#imagePreview').css('display','block');
        }
        // read the user input file 
        reader.readAsDataURL(input.files[0]);
    }
}
function clearField(){
    $('#imagePreview').css('display','none');
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

// Search user with id, name or email  
$(document).ready(function(){
    $('#searchUser').on('keyup', function(){
       var formData ={
        searchAll: $(this).val()

       };
       $.ajax({
        url: '/searchUser',
        type: 'GET',
        data: formData,
        success: function(response) {
            $('#userLists').html(response);
        }
       });
    });
});

// sort users  
$(document).ready(function(){
    $('.sortBy').on('change', function(){
        var sortBy = $('#sortBy').val();
        var orderBy = $('#orderBy').val();
        var formData = {
            sortBy: sortBy,
            orderBy: orderBy
        };
        $.ajax({
            url: '/sortUsers',
            type: 'GET',
            data: formData,
            success: function(response) {
                $('#userLists').html(response);
            }
        });
    });
});

// show the menu for action
function showMenus(btnNum) {
    var showMenuBtn = "actionMenu" + btnNum;
    $("#" + showMenuBtn).toggle();
}



// the userId parameter retrieve from the parameters in onclick which the user id 
function removeUser(UserId) {
    // alert confirmation
    if(confirm('Are you sure you want to delete this user?')) {
        // prevent the page reload 
        event.preventDefault();
        // get the id attribute from removeForm concat with whatever the userId holds and listen to it when submit 
        // when the id attribute was submitted a form it will run the action of that form 
        document.getElementById('removeForm' + UserId).submit();
    }
}

// block a user 
function blockUser(UserId) {
    // alert confirmation
    if(confirm('Are you sure you want to block this user?')) {
        // prevent the page reload 
        event.preventDefault();
        // get the id attribute from removeForm concat with whatever the userId holds and listen to it when submit 
        // when the id attribute was submitted a form it will run the action of that form 
          document.getElementById('blockUser' + UserId).submit();
        
    }
}

// unblock a user
function unblockUser(UserId) {
    // alert confirmation
    if(confirm('Are you sure you want to block this user?')) {
        // prevent the page reload 
        event.preventDefault();
        // get the id attribute from removeForm concat with whatever the userId holds and listen to it when submit 
        // when the id attribute was submitted a form it will run the action of that form 
          document.getElementById('unblockUser' + UserId).submit();
        
    }
}



// sort for blocked users 
$(document).ready(function(){
    $('.sortBlockUserBy').on('change', function(){
        var sortBlockUserBy = $('#sortBlockUserBy').val();
        var orderBlockUserBy = $('#orderBlockUserBy').val();
        var formData = {
            sortBlockUserBy: sortBlockUserBy,
            orderBlockUserBy: orderBlockUserBy
        };
        $.ajax({
            url: '/sortBlockUsers',
            type: 'GET',
            data: formData,
            success: function(response) {
                $('#userLists').html(response);
            }
        });
    });
});



// search blocked users 
$(document).ready(function(){
    $('#searchBlockedUser').on('keyup', function(){
       var formData ={
        searchAllBlockedUsers: $(this).val()

       };
       $.ajax({
        url: '/searchBlockedUsers',
        type: 'GET',
        data: formData,
        success: function(response) {
            $('#userLists').html(response);
        }
       });
    });
});

// get the remove product form 
function removeProduct(prodId) {
    var  confirmRemove = confirm('Are you sure you want to remove this product?');
    if(confirmRemove) {
        document.getElementById('removeProduct' + prodId).submit();
    }
    
}


// edit the product 
function editProduct(prodId) {
    var editProdDialog = document.getElementById("editProductDialog" + prodId);
    console.log(editProdDialog);
    editProdDialog.showModal();
}

// move a product 
function moveProduct(prodId) {
    var moveProductDialog = document.getElementById("moveProductDialog" + prodId);
    moveProductDialog.showModal();
}



function moveProductOption(prodId) {
    var moveTo = document.getElementById('moveProductOption' + prodId);
    var prodIdInput = document.getElementById('prodIdInput' + prodId);
   if(moveTo.value == 2 ){
    prodIdInput.style.display =  'block';
   }
  
   else {
    prodIdInput.style.display =  'none';
   }
}
// sort product in on hand table 
$(document).ready(function(){
    $('.sortProd').on('change', () => {
        var sortProductBy = $('#sortProductBy').val();
        var orderProductBy = $('#orderProductBy').val();
        var formData = {
            sortProductBy: sortProductBy,
            orderProductBy: orderProductBy
        };
        $.ajax({
            url: '/sortProduct',
            type: 'GET',
            data: formData,
            success: function(response){
                $('#productTableBody').html(response);
            }
        });
    });
});


// sort product in processing table 
$(document).ready(function(){
    $('.sortProcessingProduct').on('change', () => {
        var sortProductBy = $('#sortProductBy').val();
        var orderProductBy = $('#orderProductBy').val();
        var formData = {
            sortProductBy: sortProductBy,
            orderProductBy: orderProductBy
        };
        $.ajax({
            url: '/sortProcessingProduct',
            type: 'GET',
            data: formData,
            success: function(response){
                $('#productTableBody').html(response);
            }
        });
    });
});

// sort Products in canel or return table 
$(document).ready(()=> {
    $('.sortCancelReturnProduct').on('change', () => {
        var sortProductBy = $('#sortProductBy').val();
        var orderProductBy = $('#orderProductBy').val();
        var formData = {
            sortProductBy: sortProductBy,
            orderProductBy: orderProductBy
        };
        $.ajax({
            url: '/sortCancelReturnProduct',
            type: 'GET',
            data: formData,
            success: function(response) {
                $('#productTableBody').html(response);
            }
        });
    });
});

function editStatus(prodId) {
    var statusDialog = document.getElementById('prodStatus' + prodId);
    statusDialog.showModal();
}

$('#adminSettingsBtn').on('click', ()=> {
    $('#adminSettingsProfile').toggle();
});

function adminLogoutBtn() {
    $('#adminLogOut').submit();
}

$('#reason').on('change', () => {
   
})

$('#reason').on('change', function() {
    value = parseInt($(this).val());
    if(value == 7) {
        $('#specify').css('display', 'block');
    }
    else {
        $('#specify').css('display', 'none');
    }
   
})

function featured(id) {
    
    $('#featureForm' + id).submit();
}
$(document).ready(function(){
    $('[id^="updateStatusBtn"]').click(function(){ // get all the id whose have updateStatusBtn in their id attr 
        let prodId = $(this).attr('id').replace('updateStatusBtn','');  // in its id remove the updateStatusBtn into empty string so we can only extract the ID 
        let formData = new FormData($('#updateStatusForm' + prodId)[0]); // get the form assign to formdata so we can access its form 
        let select = $('#updateStatusSelect' + prodId); 
        let selectedValue = select.val();
        let status = $('#status' + prodId);

        $.ajax({
            url: $('#updateStatusForm' + prodId).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                switch(selectedValue) {
                    case '1': 
                        status.text('To Pay');
                        break;
                    case '2': 
                        status.text('To Ship');
                        break;
                    case '3': 
                        status.text('To Recieve');
                        break;
                    case '4': 
                        status.text('To Review');
                        break;
                    default: 
                        alert('Undefined');
                        
                }
                document.getElementById('prodStatus' + prodId).close();
            },
            error: function(error) {
                console.log('error Occured', error);
            } 
        })
    })
})