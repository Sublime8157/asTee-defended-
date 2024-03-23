
// remove cart item
function removeCartItem(itemId) {
    var itemToRemove = document.getElementById('removeItemForm' + itemId);
   itemToRemove.submit();
}

// check and unchecked all the products
var checkall = $('#checkAll');
var check = true;
checkall.on('click', function(){
    var checkAll = $.find('input[type="checkbox"]');
    
    if(check) {
        checkAll.forEach(function(checkAll){
            checkAll.checked = true;
        })
        check = false;
    }
    else if(!check) {
        checkAll.forEach(function(checkAll){
            checkAll.checked = false;
        })
        check = true;
    }
})

// count the items inside the cart

