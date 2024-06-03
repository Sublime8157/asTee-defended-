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
new Chart(ctx2, {
    type: 'line',
    data: {
      labels: soldMonths,
      datasets: [{
        label: 'Sales',
        data: totalAmount,
        borderWidth: 2
       
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
