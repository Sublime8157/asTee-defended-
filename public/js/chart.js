const ctx = document.getElementById('myChart');

var now = new Date();
var yearToday = now.getFullYear();

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: listOfMonths,
    datasets: [{
      label: 'Registered Accounts '+ yearToday,
      data: usersCount,
      backgroundColor: 'rgba(153, 201, 255)',
      borderWidth: 1
    }]
  },
  options: {
    plugins : {
      colors: {
        enabled: true
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const ctx2 = document.getElementById('salesChart');
let salesChart = new Chart(ctx2, {
    type: 'line',
    data: {
      labels: soldMonths,
      datasets: [{
        label: 'Sales',
        data: totalAmount,
        borderWidth: 2,
       
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

const productReturn = document.getElementById('returnCancel');
new Chart(returnCancel, {
    type: 'doughnut',
    data: {
      labels: ['Wrong Product','Different Colors', 'Wrong design', 'Change my mind','Order Details','Change order','Other reasons'],
      datasets: [{
        data: returnProdData,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            font: {
              size: '10'
            }
          }
        }
      }
    }
  });

  function updateSales(data){
    salesChart.data.labels = data.dates; // update the salesChart from our parameter retrieve from the ajax response 
    salesChart.data.datasets[0].data = data.sales;  // update the sales 
    salesChart.update(); // render the data 
  }

  $(document).ready(() => {
    $('#filterSales').on('click', () => {
       var dateFrom = $('#dateSalesFrom').val(); 
       var dateTo = $('#dateSalesTo').val();
       var datesToFilter = {
          dateFrom: dateFrom,
          dateTo: dateTo
       };
      
       $.ajax({
            url: '/filterSalesDate',
            method: 'GET',
            data: datesToFilter,
            success: function(response){
              updateSales(response);  
            } 
       })
    })
  });


  $('#downloadSales').on('click', () => {
    var canvas = ctx2.toDataURL('image/jpg'); 
    var a = document.createElement('a');
    a.href = canvas; 
    a.download = 'Sales_report.jpg'; 
    document.body.appendChild(a); 
    a.click();
    document.body.removeChild(a);
  }); 
