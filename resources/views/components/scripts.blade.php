<script src="{{ asset('/js/script1.js') }}"></script>
<script src="{{ asset('/js/cart.js') }}"></script>
<script>
    var count = localStorage.getItem('count');
     $('.cart').text(count);
</script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>