
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
    var textArea = $('#specify' + id);
    textArea.val("");
    document.getElementById('feedBackModal' + id).showModal();
}
// close the modal with confirmation
function closeReviewDialog(id) {
    var specifyValue = $('#specifyValue' +id).val();
    if (specifyValue == "") {
        document.getElementById('feedBackModal' + id).close();
    }
    else {
        if(confirm("Are you sure you want to quit reviewing? your progress will be loss")) {
            document.getElementById('feedBackModal' + id).close();
        }
    }
}
function showOtherRatings(id, e){
    e.name === 'chevron-down-outline' ? (e.name = 'chevron-up-outline') : (e.name  = 'chevron-down-outline');
    $('#productServiceRatings' + id).toggle();
}
//ratings for overall
// select all with a class name overAll
var overAllLists = document.querySelectorAll('.overAll');
// loop trough overAlllists and each of it runs a function with a callback function overAll that holds the ul and index 
overAllLists.forEach(function(overAll, index){
    // assign to icons all the ion-icon inside the current ul, and inside of li 
    var icons = overAll.querySelectorAll('li ion-icon');
    // loop trough icons or ion-icon get each one of them and assign to icon callback 
    icons.forEach(function(icon, index1) {
        // add an event listener on each of the returned value of loop 
        icon.addEventListener('click', () => {
            var input = overAll.querySelectorAll('input');
            input.forEach(function(val, inputIndex){
                val.value = index1 + 1;              
            })
            // loop trough icons 
            icons.forEach(function(icon, index2){
                // if index1 is greater than or equal to index 2 
                if(index1 >= index2) {  
                   // add a clast list to icon 
                    icon.classList.add('text-yellow-300');
                }
                else {
                    // remvoe the class list if not less than 
                    icon.classList.remove('text-yellow-300');
                }
            })
        });
    });
});

//ratings for quality 
const qualityList = document.querySelectorAll('.quality');
$(qualityList).each(function(qualityIndex, quality) {
    var icons = $(quality).find('li ion-icon');
    icons.each(function(iconIndex, icon) {
        $(icon).on('click', function() {
            var input = $(quality).find('input');
            input.each(function(valIndex, val){
                    val.value  = iconIndex +1;
            })
            icons.each(function(icon2Index, icon2) {
                if (iconIndex >= icon2Index) {
                    $(icon2).addClass('text-yellow-300');
                } else {
                    $(icon2).removeClass('text-yellow-300');
                }
            });
        });
    });
});
// for services 
const serviceLists = $('.service');
$(serviceLists).each(function(serviceIndex, service)  {
    var icons = $(service).find('li ion-icon');
    icons.each(function(iconIndex, icon)  {
        $(icon).on('click', function() {
            var input = $(service).find('input');
            input.each((valIndex, val) => {
                    val.value = iconIndex + 1;
            })
            icons.each(function(icon1Index, icon1){
                iconIndex >= icon1Index ? $(icon1).addClass('text-yellow-300') :  $(icon1).removeClass('text-yellow-300');
            })
        })
    })
})

function submitReview(id) {
  var specifyText = $('#specify' + id).text();
  var valueToSubmit = $('#specifyValue' +id);
  alert(specifyText);
}

function getTheText(id) {
   var text = $('#specify' + id).val();
   var specifyValue = $('#specifyValue' +id);
   specifyValue.val(text);
}
function submitReview(id) {
    $('#reviewForm' + id).submit();
}

setTimeout(function(){
    $('#successMessage').css('display','none');
},3000)

// cancellation dialogs 
function showCancelForm(id) {
    // open form
    document.getElementById('cancelDialog' + id).showModal();
}
function openCancelConfirmation(id) {
    // show confirmation 
    document.getElementById('cancelConfirmation' + id).showModal();
}
function closeCancelDialog(id) {
    //close form  
    document.getElementById('cancelDialog' +id).close();
}
function submitCancel(id) {
    // submit form 
    $('#cancelForm' + id).submit();
}
function closeConfirmationModal(id) {
    // close confirmation 
    document.getElementById('cancelConfirmation' + id).close();
}


