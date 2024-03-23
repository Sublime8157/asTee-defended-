// filter products 
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

// show filter  icon 
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

// clear radio buttons 
function clearRadio(){
    var radioButtons = document.querySelectorAll('input[type="radio"]')
    
   radioButtons.forEach(function(radioButtons){
    radioButtons.checked = false;
   })
}

// quantity 
var addBtn = $('#addButton');
var minusBtn = $('#minusButton');
var quantityValue = $('#quantityValue');
var value;
// add button 
addBtn.on('click', () => {
    value = parseInt(quantityValue.val());
    value++;
    quantityValue.val(value);
});
// minus button 
minusBtn.on('click', () => {
    var value = parseInt(quantityValue.val());
   if(value > 0 ) {
        value--;
        quantityValue.val(value);
   }
});

// add to cart ajax 
$(document).ready(function(){
    $('.addToCartForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this)
        $.ajax({
            url: '/storeCart',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function() {
                console.log("Success");
            }
        })
    })
})

