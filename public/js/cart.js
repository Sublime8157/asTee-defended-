
// remove cart item
function removeCartItem(itemId) {
    var itemToRemove = document.getElementById('removeItemForm' + itemId);
   itemToRemove.submit();
}
var checkAllItems = $('.checkAll');
var allItems = [];
var checkAll = $('.list');
var total = $('.total');
var cartItemsCount = $('#countItems');
var totalAmount = $('#totalAmountVal');
var itemsTotalAmount = [];
var totalAmountTxt = $('#totalAmountTxt');

// Select or deselect all items in the cart
checkAllItems.on('click', function(){
    if($(this).prop('checked')) {
        checkAll.prop('checked', true);
        allItems = []; // clear before pushing items 
        itemsTotalAmount = [];
        checkAll.each(function(){
            allItems.push($(this).val());
            
        });
        total.each(function(){
            itemsTotalAmount.push(parseFloat($(this).val())); //convert to float before getting the value of inputs
        })
    }
    else {
        checkAll.prop('checked', false);
        allItems = []; // Clear the array when unchecking all
        itemsTotalAmount = []; 
    }

    $('#removeAll').val(allItems);
    cartItemsCount.text(allItems.length + " " );

    
    var totaledPrice = itemsTotalAmount.reduce(function(total, value){ 
        return total + value;
    },0) // sum of all items in itemsTotalAmount array 
    totalAmount.val(totaledPrice);  // assign the sum to the value of totalAmount input 
    totalAmountTxt.text(totaledPrice);
});



// Add or remove specfic items from the cart
function updateCart(id){
    var checkbox = $('#cart' + id);
    var unitPrice = $('#unitPrice' + id);
    var total = $('#totalPrice' + id);
    var minusBtn = $('#minusButton' + id);
    var addBtn = $('#addButton' + id);
    var qty = $('#quantityValue' + id);
    var textPrice = $('#textPrice' + id);
    var quantityDiv = $('#quantityDiv' + id);
    itemTotal = parseFloat(total.val());
    
    if(checkbox.prop('checked')) {
        allItems.push(id); // push the id in the allItems  array
        itemsTotalAmount.push(itemTotal);  // push the amount in the itemsTotalAmount array
        minusBtn.prop('disabled', false); // enable the inc and decr button 
        addBtn.prop('disabled', false);
        quantityDiv.addClass('font-bold');
    }   
    else {
        
        var allItemsArrIndex = allItems.indexOf(id); //find the index of id 
        if(allItemsArrIndex != -1) { //remove from the allItems array 
            allItems.splice(allItemsArrIndex);
        }

        minusBtn.prop('disabled', true); //disabled the inc and decr buttons 
        addBtn.prop('disabled', true); // 
        price = parseInt(unitPrice.val()); //convert to int the value of unitPrice input 
        total.val(price); // replace the  total input to the default unit price of the item
        qty.val(1); //assign the valeu of the qty to 1 
        textPrice.text(price);
        quantityDiv.removeClass('font-bold');

        // after the total amount is set to default price of the item we can then iterate to array to remove all the 
        // items with the unit price 
        var itemsTotalAmountArrIndex;
        while ((itemsTotalAmountArrIndex = itemsTotalAmount.indexOf(price)) != -1) { 
                itemsTotalAmount.splice(itemsTotalAmountArrIndex, 1);
            }
    }

    $('#removeAll').val(allItems);  // assign the items of array to the value of removeAll input
    cartItemsCount.text(allItems.length); // replace the text of allItems span 
    var totaledPrice = itemsTotalAmount.reduce(function(total, value){ 
        return total + value;
    },0) // sum of all items in itemsTotalAmount array 
    totalAmount.val(totaledPrice);  // assign the sum to the value of totalAmount input 
    totalAmountTxt.text(totaledPrice); // change the text content of span 
}

function addButton(id) {
    // get the id 
    var value = $('#quantityValue' + id);
    var txtPrice = $('#textPrice' + id);
    var unitPrice = $('#unitPrice' + id);
    var totalP = $('#totalPrice' + id);
    var checkBox = $('#cart' + id);
    
    // get the value
    unitPriced = parseInt(unitPrice.val());
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
    

    if(checkBox.prop('checked')) { 
       
        itemsTotalAmount.push(unitPriced);
        var totaledPrice = itemsTotalAmount.reduce(function(total, price) {
            return total + price;
        })
        
        totalAmount.val(totaledPrice);
        totalAmountTxt.text(totaledPrice);
    }
    console.log(itemsTotalAmount);
}
// minus qty button
function minusButton(id) {
    var value = $('#quantityValue' + id);
    var txtPrice = $('#textPrice' + id);
    var unitPrice = $('#unitPrice' + id);
    var totalP = $('#totalPrice' + id);
    var checkbox = $('#cart' + id);

    val = parseInt(value.val());
    unitPriced = parseInt(unitPrice.val());
    price = parseInt(unitPrice.val());
    priceTotal = parseInt(totalP.val());

    if(val > 1) {
        val --;
        value.val(val);
        value.val(val);
        price = price * val;
        totalP.val(price);
        // display the value 
        txtPrice.text(price);

        var itemsTotalAmountArrIndex = itemsTotalAmount.indexOf(unitPriced);
        if(itemsTotalAmountArrIndex != -1) {
            itemsTotalAmount.splice(itemsTotalAmountArrIndex, 1);
        }
        
    }
    if(checkbox.prop('checked')) { 
    var totaledPrice = itemsTotalAmount.reduce(function(total, price) {
        return total + price;
    })
        totalAmount.val(totaledPrice);
     totalAmountTxt.text(totaledPrice);
    }
    
     
}


