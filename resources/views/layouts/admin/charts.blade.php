{{-- <script>
// ============================ Revenue Statistics Chart start ===============================
var options = {
  series: [{
    name: 'Total Fee',
    data: [25, 35, 50, 60, 26, 20, 40, 20, 50, 16, 10, 40]
  }, {
    name: 'Collected Fee',
    data: [15, 16, 24, 30, 20, 15, 20, 10, 25, 10, 6, 20]
  }],
  chart: {
    type: 'bar',
    height: 250,
    stacked: true,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: true
    }
  },
  colors: ["#25A194", "#FF7A2C"],
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "50%",
      shape: "pyramid",
    },
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr',
      'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ],
  },
  yaxis: {
    labels: {
      formatter: function (value) {
        return "$" + value + "k";
      },
      style: {
        fontSize: "14px"
      }
    },
  },
  legend: {
    show: false,
  },
  fill: {
    opacity: 1
  }
};

var chart = new ApexCharts(document.querySelector("#revenueStatistic"), options);
chart.render()
// ============================ Revenue Statistics Chart End ===============================

// ===================== Income Vs Expense Start =============================== 
function createChartThree(chartId, color1, color2) {
  var options = {
    series: [{
      name: 'Income',
      data: [48, 35, 55, 32, 48, 30, 15, 50, 57]
    }, {
      name: 'Expense',
      data: [12, 20, 15, 26, 22, 60, 40, 32, 25]
    }],
    legend: {
      show: false
    },
    chart: {
      type: 'area',
      width: '100%',
      height: 260,
      toolbar: {
        show: false
      },
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'stepline',
      width: 2,
      colors: [color1, color2],
      lineCap: 'round'
    },
    grid: {
      show: true,
      borderColor: '#D1D5DB',
      strokeDashArray: 1,
      position: 'back',
      xaxis: {
        lines: {
          show: false
        }
      },
      yaxis: {
        lines: {
          show: true
        }
      },
      row: {
        colors: undefined,
        opacity: 0.2
      },
      column: {
        colors: undefined,
        opacity: 0.2
      },
      padding: {
        top: -20,
        right: 0,
        bottom: -10,
        left: 0
      },
    },
    colors: [color1, color2],
    markers: {
      colors: [color1, color2],
      strokeWidth: 1,
      size: 0,
      hover: {
        size: 10
      }
    },
    xaxis: {
      labels: {
        show: false
      },
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      tooltip: {
        enabled: false
      },
      labels: {
        formatter: function (value) {
          return value;
        },
        style: {
          fontSize: "14px"
        }
      }
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return "$" + value + "k";
        },
        style: {
          fontSize: "14px"
        }
      },
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy HH:mm'
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        type: "vertical",
        opacityFrom: 0.4,
        opacityTo: 0.05,
        stops: [0, 100]
      }
    }
  };

  var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
  chart.render();
}

createChartThree('incomeExpense', '#16a34a', '#FF9F29');
// ===================== Income Vs Expense End =============================== 

// ================================ New Admissions Chart Start ================================ 
var options = {
  series: [40, 87, 87, 30],
  colors: ['#0A51CE', '#25A194', '#FF7A2C', '#009F5E'],
  labels: ['Health', 'Business', 'Lifestyle', 'Entertainment'],
  legend: {
    show: false
  },
  chart: {
    type: 'donut',
    height: 270,
    sparkline: {
      enabled: true // Remove whitespace
    },
    margin: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0
    },
    padding: {
      top: 0,
      right: 0,
      bottom: 0,
      left: 0
    }
  },
  stroke: {
    width: 2,
  },
  dataLabels: {
    enabled: false
  },
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }],
};

var chart = new ApexCharts(document.querySelector("#newAdmissions"), options);
chart.render();
// ================================ New Admissions Chart End ================================ 
</script> --}}