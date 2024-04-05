<script>
    var id = {{$item->id}}
    var price = $('#price' + id).text();
    price = parseInt(price);
    var quantity = $('#quantity' + id).text();
    quantity = parseInt(quantity);
    var total = price * quantity;
    $('#totalAmount' + id).text(total);
</script>