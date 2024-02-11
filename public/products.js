
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
//                 // Assuming the response is JSON data
//                 // Update the DOM with the received data
//                 updateDOM(response.filteredData);
//             },
//             error: function(xhr, status, error) {
//                 console.error(xhr.responseText);
//             }
//         });
//     });
// });

// function updateDOM(data) {
//     // Update the DOM with the received data
//     // For example, if you have an element with ID 'filteredData', you can update its content like this:
//     $('#filterProduct').html(data);
// }

