window.addEventListener('DOMContentLoaded', async (event) => {
  // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Kanit';
    Chart.defaults.global.defaultFontColor = '#858796';
  
    function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }
  
    async function get_sale_All() {
      // const res = await fetch("api/get_sale_All.php");
      const res = await fetch("/community_business/api/get_sale_huaysai.php");
      const json = await res.json()
      return json;
    }
  
    const data = await get_sale_All();
    var my_data1 = [];
    var my_label = [];
    var Unique_label = [];

    data.forEach(item => {
      // console.log("my_data = "+ item.month);
      // console.log("my_data = "+ item.total);
      switch (item.month) {
          case "1 ":
              my_data1.push(item.total)
              break;
          case "2":
              my_data1.push(item.total)
              break;
          case "3":
              my_data1.push(item.total)
              break;
          case "4":
              my_data1.push(item.total)
              break;
          case "5":
              my_data1.push(item.total)
              break;
          case "6":
              my_data1.push(item.total)
              break;
          case "7":
              my_data1.push(item.total)
              break;
          case "8":
              my_data1.push(item.total)
              break;
          case "9":
              my_data1.push(item.total)
              break;
          case "10":
              my_data1.push(item.total)
              break;
          case "11":
              my_data1.push(item.total)
              break;
          case "12":
              my_data1.push(item.total)
              break;
          }
      
      switch (item.month) {
        case "1":
            my_label.push('มกราคม')
            break;
        case "2":
            my_label.push('กุมภาพันธ์')
            break;
        case "3":
            my_label.push('มีนาคม')
            break;
        case "4":
            my_label.push('เมษายน')
            break;
        case "5":
            my_label.push('พฤษภาคม')
            break;
        case "6":
            my_label.push('มิถุนายน')
            break;
        case "7":
            my_label.push('กรกฎาคม')
            break;
        case "8":
            my_label.push('สิงหาคม')
            break;
        case "9":
            my_label.push('กันยายน')
            break;
        case "10":
            my_label.push('ตุลาคม')
            break;
        case "11":
            my_label.push('พฤศจิกายน')
            break;
        case "12":
            my_label.push('ธันวาคม')
            break; 
      }
    });

    console.log("my_data1 = "+ my_data1);
    // console.log(my_data2);
    console.log("my_label = "+ my_label);
  
  
    for( var i=0; i<my_label.length; i++ ) {
      if ( Unique_label.indexOf( my_label[i] ) < 0 ) {
        Unique_label.push( my_label[i] );
      }
    } 
  
    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myAreaChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: Unique_label,
        datasets: [{
          // label: "ยอดขายสินค้า",
          lineTension: 0,
          backgroundColor: "rgba(78, 115, 223, 0.3)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: my_data1,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: true,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 12
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function(value, index, values) {
                return  number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' บาท';
            }
          }
        }
      }
    });
  });