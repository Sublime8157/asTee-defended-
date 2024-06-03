$(document).ready(function(){
    $('#searchOrders').on('keyup', function(){
        var formData = { 
            searchOrders: $(this).val()
        };
        $.ajax({
            url: '/searchOrder',
            method: 'GET',
            data: formData,
            success: function(response){
                $('#orderTableBody').html(response);
            }
        });
    });
});

$(document).ready(() => {
    $('.sort_order').on('change', () => {
        var sortBy = $('#sortBy').val();
        var orderBy = $('#orderBy').val();
        var formData = {
            sortBy: sortBy,
            orderBy: orderBy
        };
        $.ajax({
            url: '/sortOrders',
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#orderTableBody').html(response);
            }
        })
    })
});

$(document).ready(() => {
    $('.filterDate').on('change', () => {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var formData = {
            startDate: startDate, 
            endDate: endDate
        };
        $.ajax({
            url: '/filterDate',
            method: 'GET',
            data: formData,
            success: function(response){
                $('#orderTableBody').html(response);
            }
        })
    })
})