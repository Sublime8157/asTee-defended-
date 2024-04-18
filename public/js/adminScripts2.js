const toDeleteArr = [];
// remove all using checkbox
$('#checkAll').on('click', function(){
    toDeleteArr.length = 0; // clear the array before passing all  
    if($(this).prop('checked')) { 
        $('.checkBox').each(function(){ // get all the class with checkBox 
            $(this).prop('checked', true);  // check all 
            var value = parseInt($(this).val()); // parse its value to int
            toDeleteArr.push(value); // push its value to array 
            $(this).closest('tr').addClass('bg-gray-200'); // change the bg of parent 
        });
    }
    else {
        $('.checkBox').each(function(){ 
            $(this).prop('checked', false);
            toDeleteArr.length = 0; // clear the array 
            $(this).closest('tr').removeClass('bg-gray-200'); // remove the bg 
        });
    }
    $('#toRemove').val(toDeleteArr); // pass the array to hidden input 
})
// remove specific using checkbox
$('.checkBox').on('click', function(){ // listen to click for all of the tags with chekBox classes 
    var value = parseInt($(this).val()); // parse its value whatever was  clicked 
    if($(this).prop('checked')) { 
        toDeleteArr.push(value); // push its value to array 
        $(this).closest('tr').addClass('bg-gray-200'); // change its parent background 
    }
    else {
        var checkBoxIndex = toDeleteArr.indexOf(value); // get the index from array
        if(checkBoxIndex != -1) { // validate if it was not -1 
            toDeleteArr.splice(checkBoxIndex, 1); // remove from array 
            $(this).closest('tr').removeClass('bg-gray-200'); //remove the bg 
        }
    }
    $('#toRemove').val(toDeleteArr); // assign the value to input 
})

function chosenMultiple() {
    var functionToDo = $('#chooseMultiple').val();
    switch(functionToDo) {
        case '1':
            document.getElementById('confirmDialog').showModal();
            break;
        case '2': 
            var movedValue = $('#toUpdate').val(toDeleteArr);
            movedValue = parseInt(movedValue.val());
            document.getElementById('confirmDialogUpdate').showModal();
            break;
        case '3':
            alert('You want to move? ');
            break;
        case '4': 
            alert('Please specify');
            break;
    }
}