
// remove cart item
function removeCartItem(itemId) {
    var itemToRemove = document.getElementById('removeItemForm' + itemId);
   itemToRemove.submit();
}
function addButton(id) {
    // get the id 
    var value = $('#quantityValue' + id);
    var txtPrice = $('#textPrice' + id);
    var unitPrice = $('#unitPrice' + id);
    var totalP = $('#totalPrice' + id);
    // get the value
    val = parseInt(value.val());
    price = parseInt(unitPrice.val());
    priceTotal = parseInt(totalP.val());
    // compute 
    val++;
    value.val(val);
    price = price * val;
    totalP.val(price);
    // display the value 
    txtPrice.text(price);
}
// minus qty button
function minusButton(id) {
    var value = $('#quantityValue' + id);
    var txtPrice = $('#textPrice' + id);
    var unitPrice = $('#unitPrice' + id);
    var totalP = $('#totalPrice' + id);

    val = parseInt(value.val());
    price = parseInt(unitPrice.val());
    priceTotal = parseInt(totalP.val());

    if(val > 0) {
        val --;
        value.val(val);
        value.val(val);
        price = price * val;
        totalP.val(price);
        // display the value 
        txtPrice.text(price);
    }
}

var checkAllItems = $('.checkAll');
var allItems = [];
var checkAll = $('.list');
var cartItemsCount = $('#countItems');
// Select or deselect all items in the cart
checkAllItems.on('click', function(){
    if($(this).prop('checked')) {
        
        checkAll.prop('checked', true);
        allItems = [];
        checkAll.each(function(){
            allItems.push($(this).val());
        });
    }
    else {
        checkAll.prop('checked', false);
        allItems = []; // Clear the set when unchecking all
    }

    $('#removeAll').val(allItems);
    cartItemsCount.text(allItems.length + " " );
});



// Add or remove specfic items from the cart
function updateCart(id){
    var checkbox = $('#cart' + id);
    if(checkbox.prop('checked')) {
        allItems.push(id);
    }   
    else {
        var index = allItems.indexOf(id);
        allItems.pop(id);
    }
    $('#removeAll').val(allItems);
    cartItemsCount.text(allItems.length + " " );
}

