
// Function for the user profile that hides and reaveal the side navigation 
function showSideNav(e) {
    var sideNav = $('#sideNav');
    var sideIcon = $('#arrowIcon');

    if(e.name === 'chevron-back-sharp') {
        e.name = 'chevron-forward-sharp';
        sideNav.css('position','absolute');
        sideNav.css('left', '-0');
        sideIcon.css('left', '12rem')
    }
    else {
        e.name = 'chevron-back-sharp';
        sideNav.css('position','absolute');
        sideNav.css('left','-195px');
       sideIcon.css('left', '12rem');
    }
}

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



