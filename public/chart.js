const ctx = document.getElementById('myChart');


new Chart(ctx, {
  type: 'bar',
  data: {
    labels: listOfMonths,
    datasets: [{
      label: 'Registered Accounts',
      data: usersCount,
      borderWidth: 1
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

const ctx2 = document.getElementById('salesChart');
new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ['April','May', 'June', 'July','August'],
      datasets: [{
        label: 'Sales per month',
        data: [12, 25, 100, 2, 5],
        borderWidth: 1
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
    type: 'pie',
    data: {
      labels: ['Wrong Product','Different Colors', 'Wrong design', 'Reason 1','Reason 2','Reason 3','Reason 4'],
      datasets: [{
        data: [wrongProduct, differentColors, wrongDesign, reason1, reason2, reason3, reason4],
        borderWidth: 1
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
  const products = document.getElementById('products');
new Chart(products, {
    type: 'doughnut',
    data: {
      labels: ['April','May', 'June', 'July','August'],
      datasets: [{
        label: 'Sales per month',
        data: [12, 25, 100, 2, 5],
        borderWidth: 1
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