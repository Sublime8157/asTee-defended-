
// $(document).ready(function(){
//     $('#filterForm').submit(function(e){
//         e.preventDefault();

//         var regFormData = new FormData(this);

//         $.ajax({
//             url: '/filterProducts',
//             method: 'GET',
//             data: regFormData,
//             processData: false,
//             contentType: false,
//             success: function(response) {
//                updateDOM(response)
//             },
//             error: function(xhr, status, error) {
//                 console.error(xhr.responseText);
//             }
//         });
//     });
// });

// function updateDOM(content) {
//    $('#filterData').html(content);
// }

