window.addEventListener('DOMContentLoaded', async (event) => {
// Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
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


  async function get_total_goat() {
    const res = await fetch("/community_business/api/get_profit_khongchaoun.php");
    const json = await res.json()
    return json;
  }

  var ctx = document.getElementById("myBarChart");
  const data = await get_total_goat();

  // console.log(data);
  var my_data02 = [];
  var my_label02 = [];
  data.forEach(item => {
    my_data02.push(item.profit);
    my_label02.push(item.Year);
  });
  console.log("my_data02 = "+ my_data02);
  console.log("my_label02 = "+ my_label02);

  // Bar Chart Example
  var ctx = document.getElementById('myBarChart');
  var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: my_label02,
          datasets: [{
          label: "ยอดกำไรในปุัจจุบัน",
          backgroundColor: "#17d1ae",
          borderColor: "#17d1ae",
          data: my_data02
          }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
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
                unit: 'month'
            },
            gridLines: {
                display: false,
                drawBorder: false
            },
            ticks: {
                maxTicksLimit: 12
            },
                maxBarThickness: 50,
            }],
        },
        legend: {
            display: true
        },
    }
  });
});