
$(document).ready(function(){
    $('#filterForm').submit(function(e){
        e.preventDefault();

       
        var formData = $(this).serialize();
        $.ajax({
            url: '/filterProducts',
            method: 'GET',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#filteredData').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

function displayFilter(icon) {  
    
    if(icon.name == 'caret-forward-outline') {
        icon.name = 'caret-down-outline';
        $('#filterSettings').css('display', 'block');
    }
    else {
        icon.name = 'caret-forward-outline';
        $('#filterSettings').css('display', 'none');
    }
}

function clearRadio(){
    var radioButtons = document.querySelectorAll('input[type="radio"]')
    
   radioButtons.forEach(function(radioButtons){
    radioButtons.checked = false;
   })
}