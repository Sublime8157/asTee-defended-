const { Modal } = require("flowbite");

// Toggle the updating result in updateStatus div 
function updateSuccess(){
    var successUpdate = $('#updateStatus');
    successUpdate.text('You Successfully Updated your Profile!');
    successUpdate.css('color','yellow');
}   
// Create an ajax for the update form 
$(document).ready(function(){
    $('#updateForm').submit(function(e){
        e.preventDefault();
        var updateFormData = new FormData(this);
        var confirmUpdate = confirm('Are you sure you want to update your profile?');
        if(confirmUpdate){
            $.ajax({
                url: '/updateProfile',
                method: 'POST',
                data: updateFormData,
                contentType: false,
                processData: false,
                success: function(){
                    updateSuccess();
                },
                error: function(error){
                    if(error.responseJSON) {
                        var errorUpdate = error.responseJSON.message;
    
                        $('#updateStatus').text(errorUpdate);
                    }
                    else {
                        console.log("Error Occureed");
                    }
                }
            })
        }    
    })
})

// show the image preview before saving 
function imagePreview(input) {
    // check if there are files 
    if(input.files && input.files[0]) {
        // create filereader object 
        var reader = new FileReader();
        // load the file 
        reader.onload = function(e) {
            // change the file src
            $('#imagePreview').attr('src', e.target.result);
            // display 
            $('#imagePreview').css('display', 'block');
        }
        // read file 
        reader.readAsDataURL(input.files[0]);
    }
}
// show the dialog 
function showConfirmationDialog(id) {
     document.getElementById('confirmationDialog' + id).showModal();
}
// close the confirmation dialog 
function closeConfirmationModal(id) {
    document.getElementById('confirmationDialog' + id).close();
}
// submit the form 
function orderRecieved(id) {
    var orderRecieved = $('#orderRecieved' + id);
    orderRecieved.submit();
}


// show the review modal
function reviewButton(id) {
    document.getElementById('feedBackModal' + id).showModal();
}
// close the review modal
function closeReviewDialog(id) {
    document.getElementById('feedBackModal' + id).close();
}