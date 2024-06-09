$(document).ready(() => {
   $('.filterDateCancelReturn').on('change', () => {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val(); 
        var formData = {
            startDate: startDate,
            endDate: endDate
        };
        $.ajax({
            url: '/filterReturnedCancelDate',
            method: 'GET',
            data: formData,
            success: function(response){
                $('#productTableBody').html(response); 
            }
        })
   })
})

$(document).ready(() => {
    $('.filterDateProcessing').on('change', () => {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var formData = {
            startDate: startDate,
            endDate: endDate
        };
        $.ajax({
            url: '/filterDateProcessing',
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#productTableBody').html(response);
            }
        })
    })
})