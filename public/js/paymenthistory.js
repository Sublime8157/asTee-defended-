$(document).ready(function() {
    $('#paymentSubmitForm').submit(function(e){
        // prevent the reload of the form 
        e.preventDefault(); 
        // encapsulate the form to paymentForm 
        var paymentForm = new FormData(this);
        // initiate an ajax 
        $.ajax({
            url: '/paymentForm',    // route url 
            method: 'POST', 
            data: paymentForm,  // data to process 
            contentType: false,
            processData: false, 
            success: function(response){ // if succcess the response must be a json 
                if (response.status === 'fail') { 
                    $('#failMessageBox').removeClass('hidden'); 
                    $('#successMessageBox').addClass('hidden'); 
                    $('#failMessage').html(response.message); 
                }
                else if (response.status === 'success'){
                    $('#paymentSubmitForm')[0].reset(); 
                    $('#successMessageBox').removeClass('hidden');
                    $('#failMessageBox').addClass('hidden'); 
                    $('#successMessage').html(response.message); 
                }
            },
            error: function(error) {
                if(error.responseJSON) {
                    var submitError = error.responseJSON.message; 
                    $('#failMessageBox').removeClass('hidden').text(submitError); 
                    $('#successMessageBox').addClass('hidden');
                }
                else {
                    console.log('Error Occured', error.statusText);
                }
            }
        })
    })
})

$(document).ready(() => {
    $('.sortPayments').on('change', () => {
        var sortBy = $('#sortBy').val(); 
        var orderBy = $('#orderBy').val(); 
        var filterData = {
            sortBy: sortBy,
            orderBy: orderBy
        };
        $.ajax({
            url: '/filterPayments',
            method: 'GET',
            data: filterData,
            success: function(response) {
                $('#paymentData').html(response); 
            }
        })

    })
})

$(document).ready(() => {
    $('.filterPaymentsDate').on('change', () => {
        var startDate = $('#startDate').val(); 
        var endDate = $('#endDate').val(); 
        var filterDate = {
            startDate: startDate, 
            endDate: endDate
        };
        $.ajax({
            url: '/filterPaymentsDate',
            method: 'GET',
            data: filterDate,
            success: function(response) {
                $('#paymentData').html(response); 
            }
        })
    })
})
$(document).ready(() => {
    $('#bank').on('change', function() {
        var bank = $(this).val(); 
        $.ajax({
            url: '/filterbyBank',
            method: 'GET',
            data: {bank: bank}, 
            success: function(response) {
                $('#paymentData').html(response); 
            }
        })
    })
})
$(document).ready(() => {
    $('.filterPrice').on('keyup', () => {
        var min = $('#min').val(); 
        var max = $('#max').val(); 
        var filterData = {
            min: min, 
            max: max
        };
        $.ajax({
            url: '/filterPrice',
            method: 'GET',
            data: filterData,
            success: function(response) {
                $('#paymentData').html(response); 
            }
        })
    })
})

$(document).ready(() => {
    $('#searchOnPayments').on('keyup', function()  {
        var searchBar =  $('#searchOnPayments').val();
        $.ajax({
            url: '/searchIdPayments',
            method: 'GET',
            data: { searchBar: searchBar },
            success: function(response) {
                $('#paymentData').html(response); 
            }
        })

    })
})

$(document).ready(() => {
    $('#orders').on('change', () => {
        var ids = $('#orders').val(); 
        $.ajax({
            url: '/ordersIdAmount',
            method: 'GET',
            data: { ids: ids},
            success: function(response) {
              $('#userId').val(response.userId);
              $('#amount').val(response.total);  
            }
        })
    })
})