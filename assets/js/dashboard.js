function myfunc1() {
  // Graphs
  var ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#15476a',
        borderWidth: 4,
        pointBackgroundColor: '#15476a'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
      legend: {
        display: false
      }
    }
  });
}

function myfunc2() {
  // Graphs
  var ctx = document.getElementById('myChart2')
  // eslint-disable-next-line no-unused-vars
  var myChart2 = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: [
           '#ff6384',
          '#36a2eb',
           '#cc65fe',
           '#ffce56',
          '#15476a',
          '#212529',
          '#ee4035'
        ]
      }]
    }
  });
}

function myfunc3() {
  // Graphs
  var ctx = document.getElementById('myChart3')
  // eslint-disable-next-line no-unused-vars
  var myChart3 = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: [
           '#ff6384',
          '#36a2eb',
           '#cc65fe',
           '#ffce56',
          '#15476a',
          '#212529',
          '#ee4035'
        ]
      }]
    }
  });
}

function myfunc4() {
  // Graphs
  var ctx = document.getElementById('myChart4')
  // eslint-disable-next-line no-unused-vars
  var myChart4 = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          15339,
          21345,
          18483,
          24003,
          23489,
          24092,
          12034
        ],
        lineTension: 0,
        backgroundColor: [
           '#ff6384',
          '#36a2eb',
           '#cc65fe',
           '#ffce56',
          '#15476a',
          '#212529',
          '#ee4035'
        ]
      }]
    }
  });
}
function myfunc5() {
  // Graphs
  var ctx = document.getElementById('myChart5')
  // eslint-disable-next-line no-unused-vars
  var myChart5 = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      datasets: [{
        data: [
          322,
          132,
          18483,
          2222,
          23489,
          292,
          12034
        ],
        lineTension: 0,
        backgroundColor: [
           '#ff6384',
          '#36a2eb',
           '#cc65fe',
           '#ffce56',
          '#15476a',
          '#212529',
          '#ee4035'
        ]
      }]
    }
  });
}

$('a').click(function(){
  $('a.active').each(function(){
    $(this).removeClass('active');
  });
  $(this).addClass('active');
});

function start(){
myfunc1();
myfunc2();
myfunc3();
myfunc4();
myfunc5();

}

window.onload = start();
