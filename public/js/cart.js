
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
var minusBtn = $('.minusBtn');
var addBtn = $('.addBtn');
var prodIdItems = [];
var itemsId = $('#itemsId');
var inputQuantity = [];
// for desktop view 
var desktopQuantityValue = $('.desktopQuantityValue');
var quantityDivDesktop = $('.quantityDivDesktop');
var minusBtnDesktop = $('.desktopMinusBtn');
var addBtnDesktop = $('.desktopAddButton');
var desktopTextPrice = $('.desktopTextPrice');

var quantityDivMobile = $('.quantityDivMobile');
var addBtnMobile = $('.addButtonMobile');
var minusBtnMobile = $('.minusButtonMobile');
var qtyValMobile = $('.quantityValueMobile');
var txtPriceMobile = $('.txtPriceMobile');
var productsId = $('.prodId');
// Select or deselect all items in the cart
checkAllItems.on('click', function(){
    var unitPrice = $('.unitPrice');
    var totalPrice = $('.desktopTextPrice');
    if($(this).prop('checked')) {
        checkAll.prop('checked', true);
        allItems = []; // clear before pushing items 
        itemsTotalAmount = [];
        prodIdItems = [];
        checkAll.each(function(){
            allItems.push($(this).val());
            quantityDivDesktop.addClass('font-bold');
            minusBtnDesktop.prop('disabled', false);
            addBtnDesktop.prop('disabled', false);

            quantityDivMobile.addClass('font-bold');
            minusBtnMobile.prop('disabled', false);
            addBtnMobile.prop('disabled', false);

        });
        desktopQuantityValue.each(function(){
            $(this).val(1); // Update the value of the input element
        });
        total.each(function(){
            itemsTotalAmount.push(parseFloat($(this).val())); //convert to float before getting the value of inputs
        });
        productsId.each(function(){
            prodIdItems.push(parseInt($(this).val()));
        })

    }
    else {
        
     
        checkAll.prop('checked', false);
        allItems = []; // Clear the array when unchecking all
        itemsTotalAmount = []; 
        prodIdItems = [];
        minusBtnDesktop.prop('disabled', true);
        addBtnDesktop.prop('disabled', true);
        quantityDivDesktop.removeClass('font-bold');
        desktopQuantityValue.each(function(){
            
            $(this).val(1); // Update the value of the input element
        });
        unitPrice.each(function(index){
            var value = parseInt($(this).val());
            totalPrice.eq(index).text(value);
        });
        qtyValMobile.each(function(){
            $(this).val(1); // Update the value of the input element
        });

        total.each(function(index){
            var value = parseInt($(this).val());
            txtPriceMobile.eq(index).text(value);
        });
        
    }

    $('#removeAll').val(allItems);
    cartItemsCount.text(allItems.length + " " );
    var totaledPrice = itemsTotalAmount.reduce(function(total, value){ 
        return total + value;
    },0) // sum of all items in itemsTotalAmount array 
    totalAmount.val(totaledPrice);  // assign the sum to the value of totalAmount input 
    totalAmountTxt.text(totaledPrice);
    itemsId.val(prodIdItems);
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
    var prodId = $('#productId' + id);

    var desktopTextPrice = $('#desktopTextPrice' + id);
    var minusBtnDesktop = $('#desktopMinusButton' + id);
    var desktopAddButton = $('#desktopAddButton' + id);
    var desktopQuantityDiv = $('#desktopQuantityDiv' + id);
    var desktopQuantityValue = $('#desktopQuantityValue' + id);
    quantity = parseInt(qty.val());
    itemTotal = parseFloat(total.val());
    productId = parseInt(prodId.val());
    if(checkbox.prop('checked')) {
        allItems.push(id); // push the id in the allItems  array
        itemsTotalAmount.push(itemTotal);  // push the amount in the itemsTotalAmount array
        minusBtn.prop('disabled', false); // enable the inc and decr button 
        minusBtnDesktop.prop('disabled', false);
        desktopAddButton.prop('disabled', false);
        addBtn.prop('disabled', false);
        quantityDiv.addClass('font-bold');
        desktopQuantityDiv.addClass('font-bold');
        prodIdItems.push(productId);
    }   
    else {
        
        var allItemsArrIndex = allItems.indexOf(id); //find the index of id 
        if(allItemsArrIndex != -1) { //remove from the allItems array 
            allItems.splice(allItemsArrIndex);
        }
        minusBtn.prop('disabled', true); //disabled the inc and decr buttons 
        addBtn.prop('disabled', true); // 
        minusBtnDesktop.prop('disabled', true);
        desktopAddButton.prop('disabled', true);
        price = parseInt(unitPrice.val()); //convert to int the value of unitPrice input 
        total.val(price); // replace the  total input to the default unit price of the item
        qty.val(1); //assign the valeu of the qty to 1 
        desktopQuantityValue.val(1);
        textPrice.text(price);
        quantityDiv.removeClass('font-bold');
        desktopQuantityDiv.removeClass('font-bold');
        desktopTextPrice.text(price);

        // after the total amount is set to default price of the item we can then iterate to array to remove all the 
        // items with the unit price 
        var itemsTotalAmountArrIndex;
        while ((itemsTotalAmountArrIndex = itemsTotalAmount.indexOf(price)) != -1) { 
                itemsTotalAmount.splice(itemsTotalAmountArrIndex, 1);
            }
        var prodIdIndex;
        while((prodIdIndex = prodIdItems.indexOf(productId)) != -1){
            prodIdItems.splice(prodIdIndex, 1);
        }
       }
   
    $('#removeAll').val(allItems);  // assign the items of array to the value of removeAll input
    cartItemsCount.text(allItems.length); // replace the text of allItems span 
    var totaledPrice = itemsTotalAmount.reduce(function(total, value){ 
        return total + value;
    },0) // sum of all items in itemsTotalAmount array 
    totalAmount.val(totaledPrice);  // assign the sum to the value of totalAmount input 
    totalAmountTxt.text(totaledPrice); // change the text content of span 
    itemsId.val(prodIdItems);
}

var inputQuantity = [];

function addButton(id) {
    // Mobile computation
    var value = $('#quantityValue' + id); // quantity input value 
    var txtPrice = $('#textPrice' + id); // text only 
    var unitPrice = $('#unitPrice' + id); // input value
    var checkBox = $('#cart' + id); // input checkbox
    var desktopTextTotalPrice = $('#desktopTextPrice' + id);
    // get the value
    unitPriced = parseInt(unitPrice.val());
    val = parseInt(value.val()); // Get the current quantity value and parse it as an integer
    // compute 
    val++; // Increment the quantity
    value.val(val);
    totalPriceMobile = unitPriced * val;

    // Desktop computation
    var desktopQuantityValue = $('#desktopQuantityValue' + id);
    dekstopVal = parseInt(desktopQuantityValue.val()); // Get the current quantity value and parse it as an integer
    dekstopVal++; // Increment the quantity
    desktopQuantityValue.val(dekstopVal);
    totalPriceDesktop = unitPriced * dekstopVal;

    // display the value 
    txtPrice.text(totalPriceMobile);
    desktopTextTotalPrice.text(totalPriceMobile);
    // Calculate total amount
    if (checkBox.prop('checked')) {
        itemsTotalAmount.push(unitPriced);
        var totaledPrice = itemsTotalAmount.reduce(function(total, price) {
            return total + price;
        })
        totalAmount.val(totaledPrice);
        totalAmountTxt.text(totaledPrice);
    }

    // Update inputQuantity based on the id
    var index = inputQuantity.findIndex(item => item.id === id);
    if (index !== -1) {
        inputQuantity[index].quantity = dekstopVal;
    } else {
        inputQuantity.push({ id: id, quantity: dekstopVal });
    }
    $('#quantitiesInput').val(JSON.stringify(inputQuantity));
    console.log(inputQuantity);
    $('#arrayList').val(itemsTotalAmount);
}




function minusButton(id) {
    var value = $('#quantityValue' + id);
    var txtPrice = $('#textPrice' + id);
    var unitPrice = $('#unitPrice' + id);
    var checkbox = $('#cart' + id);

    var val = parseInt(value.val());
    var unitPriced = parseInt(unitPrice.val());

    var desktopTextPrice = $('#desktopTextPrice' + id);
    var desktopQuantityValue = $('#desktopQuantityValue' + id);
    var desktopVal = parseInt(desktopQuantityValue.val());

   if( val != 1) {
     // for mobile
     val--;
     value.val(val);
     totalPriceMobile = unitPriced * val;
     txtPrice.text(totalPriceMobile);
 
     // for desktop
     desktopVal--;
     desktopQuantityValue.val(desktopVal);
     totalPriceDesktop = unitPriced * desktopVal;
     desktopTextPrice.text(totalPriceDesktop);
 
     // Update the total amount
     var itemsTotalAmountArrIndex = itemsTotalAmount.indexOf(unitPriced);
     if (itemsTotalAmountArrIndex != -1) {
         itemsTotalAmount.splice(itemsTotalAmountArrIndex, 1);
     }
  
 
     // Calculate total amount
     var totaledPrice = itemsTotalAmount.reduce(function(total, price) {
         return total + price;
     });
     totalAmount.val(totaledPrice);
     totalAmountTxt.text(totaledPrice);
 
     // Update inputQuantity based on the id
     var index = inputQuantity.findIndex(item => item.id === id);
     if (index !== -1) {
         inputQuantity[index].quantity = desktopVal;
     }
     $('#quantitiesInput').val(JSON.stringify(inputQuantity));
     console.log(inputQuantity);
 
     // Remove item from cart if quantity is 0
     if (val === 0) {
         checkbox.prop('checked', false);
         var index = itemsTotalAmount.indexOf(unitPriced);
         if (index !== -1) {
             itemsTotalAmount.splice(index, 1);
         }
     }
   }
    $('#arrayList').val(itemsTotalAmount);
}

$('#editBtnCart').on('click', () => {
    $('#removeBtnCart').toggle();
});



function showCheckOutDialog(){
    document.getElementById('checkoutDialog').showModal()
    let items = $('#itemsId').val();
    let itemsList = items.split(',');
    alert(itemsList);
}
function updateQuantities() {
    let quantityInputs = document.querySelectorAll('.desktopQuantityValue');
    let quantities = Array.from(quantityInputs).map(input => input.value);
    document.getElementById('quantitiesInput').value = JSON.stringify(quantities);
}
