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
    const res = await fetch("api/get_costprice.php");
    const json = await res.json()
    return json;
  }

  var ctx = document.getElementById("myBarChart");
  const data = await get_total_goat();
  // var my_data1 = [];
  // var my_data2 = [];
  // var my_data3 = [];
  // var my_label = [];
  // var Unique_label = [];

  console.log(data);
  let DataFormatForChartJS = (req) => {
    // let req = [ { "month": "9", "mf_name": "จานกาบหมาก", "mf_price": "7468.00", "sum_price": "2800.00" } ]
    
    let color_list = ["#c33e22", "#ec9206", "#eef73e", "#87be7e", "#2aa251", "#17d1ae", "#256ae3", "#8450ca", "#ef34f6", "#ec396e", "#6a4903", "#9f9f9f"]

    let month_list = [
        { number: "1", label: "มกราคม", ignore: true },
        { number: "2", label: "กุมภาพันธ์", ignore: true },
        { number: "3", label: "มีนาคม", ignore: true },
        { number: "4", label: "เมษายน", ignore: true },
        { number: "5", label: "พฤษภาคม", ignore: true },
        { number: "6", label: "มิถุนายน", ignore: true },
        { number: "7", label: "กรกฎาคม", ignore: true },
        { number: "8", label: "สิงหาคม", ignore: true },
        { number: "9", label: "กันยายน", ignore: true },
        { number: "10", label: "ตุลาคม", ignore: true },
        { number: "11", label: "พฤศจิกายน", ignore: true },
        { number: "12", label: "ธันวาคม", ignore: true },
    ]

    let unique_iten_name = []
    req.forEach(item => {
        if (!unique_iten_name.includes(item['mf_name'])) {
            unique_iten_name.push(item['mf_name'])
        }
    })

    let unique_iten_month = []
    req.forEach(item => {
        if (!unique_iten_month.includes(item['month'])) {
            unique_iten_month.push(item['month'])
        }
    })

    for (const [key, val] of Object.entries(month_list)) {
        unique_iten_month.forEach(month => {
            if (val.label = month) month_list[key].ignore = false
        })
    }

    let new_format_req_1 = {}
    unique_iten_name.forEach(name => {
        req.forEach(item => {
            if (item['mf_name'] == name) {
                new_format_req_1[name].push({
                    month: item['month'],
                    mf_price: item['mf_price'],
                    sum_price: item['sum_price']
                })
            }
        })
    })
    req = undefined
    req = new_format_req_1
    // let req = { ["จานกาบหมาก"]: { "month": "9", "mf_price": "7468.00", "sum_price": "2800.00" } }

    let new_format_req_2 = []
    month_list.forEach(month => {
        if (!month.ignore) {
            for (const [key, val] of Object.entries(req)) {
                new_format_req_2[key] = new_format_req_2[key] || {}
                new_format_req_2[key][month.label] = {
                    mf_price: val.mf_price,
                    sum_price: val.sum_price
                }
            }
        }
    })
    req = undefined
    req = new_format_req_2
    // let req = { ["จานกาบหมาก"]: { ["กันยายน"]: { "mf_price": "7468.00", "sum_price": "2800.00" } } }

    let res = {
        labels: month_list.map(data => {
            if (!data.ignore) {
                return data.label
            }
        }),
        datasets: []
    }

    let color_id = 0
    for (const [key, val] of Object.entries(req)) {
        let color = color_list[color_id] || '#a9a9a9'
        let dataset = {
            label: key,
            data: [],
            borderColor: color,
            backgroundColor: Utils.transparentize(color, 0.5),
        }
        for (const [k, v] of Object.entries(val)) {
            dataset.data.push(v)
        }
        color_id = color_id + 1
        res.datasets.push(dataset)
    }

    return res
}


  data.forEach(item => {
    switch (item.gg_type) {
      case '1':
        switch (item.month) {
          case '1':
            my_data1.push(item.total)
            break;
          case '2':
            my_data1.push(item.total)
            break;
          case '3':
            my_data1.push(item.total)
            break;
          case '4':
            my_data1.push(item.total)
            break;
          case '5':
            my_data1.push(item.total)
            break;
          case '6':
            my_data1.push(item.total)
            break;
          case '7':
            my_data1.push(item.total)
            break;
          case '8':
            my_data1.push(item.total)
            break;
          case '9':
            my_data1.push(item.total)
            break;
          case '10':
            my_data1.push(item.total)
            break;
          case '11':
            my_data1.push(item.total)
            break;
          case '12':
            my_data1.push(item.total)
            break;
        }
      break;
      case '2':
        switch (item.month) {
          case '1':
            my_data2.push(item.total)
            break;
          case '2':
            my_data2.push(item.total)
            break;
          case '3':
            my_data2.push(item.total)
            break;
          case '4':
            my_data2.push(item.total)
            break;
          case '5':
            my_data2.push(item.total)
            break;
          case '6':
            my_data2.push(item.total)
            break;
          case '7':
            my_data2.push(item.total)
            break;
          case '8':
            my_data2.push(item.total)
            break;
          case '9':
            my_data2.push(item.total)
            break;
          case '10':
            my_data2.push(item.total)
            break;
          case '11':
            my_data2.push(item.total)
            break;
          case '12':
            my_data2.push(item.total)
            break;
        }
      break;
      case '3':
        switch (item.month) {
          case '1':
            my_data3.push(item.total)
            break;
          case '2':
            my_data3.push(item.total)
            break;
          case '3':
            my_data3.push(item.total)
            break;
          case '4':
            my_data3.push(item.total)
            break;
          case '5':
            my_data3.push(item.total)
            break;
          case '6':
            my_data3.push(item.total)
            break;
          case '7':
            my_data3.push(item.total)
            break;
          case '8':
            my_data3.push(item.total)
            break;
          case '9':
            my_data3.push(item.total)
            break;
          case '10':
            my_data3.push(item.total)
            break;
          case '11':
            my_data3.push(item.total)
            break;
          case '12':
            my_data3.push(item.total)
            break;
        }
      break;
      
    }
    switch (item.month) {
      case '1':
        my_label.push('ม.ค.')
        break;
      case '2':
        my_label.push('ก.พ.')
        break;
      case '3':
        my_label.push('มี.ค.')
        break;
      case '4':
        my_label.push('เม.ษ.')
        break;
      case '5':
        my_label.push('พ.ค.')
        break;
      case '6':
        my_label.push('มิ.ย.')
        break;
      case '7':
        my_label.push('ก.ค.')
        break;
      case '8':
        my_label.push('ส.ค.')
        break;
      case '9':
        my_label.push('ก.ย.')
        break;
      case '10':
        my_label.push('ต.ค.')
        break;
      case '11':
        my_label.push('พ.ย.')
        break;
      case '12':
        my_label.push('ธ.ค.')
        break; 
    }
  });

  for( var i=0; i<my_label.length; i++ ) {
    if ( Unique_label.indexOf( my_label[i] ) < 0 ) {
      Unique_label.push( my_label[i] );
    }
  } 

  // console.log("my_data1 => "+ my_data1);
  // console.log("my_data2 => "+ my_data2);
  // console.log("my_data3 => "+ my_data3);
  // console.log("my_label => "+ Unique_label);

  // Bar Chart Example
  var ctx = document.getElementById('myBarChart');
  var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: Unique_label,
          datasets: [{
          label: "ยอดตามเป้าหมาย",
          backgroundColor: "#2a86e9",
          borderColor: "#2a86e9",
          data: my_data1
          },{
          label: "ยอดที่ส่งไปแล้ว",
          backgroundColor: "#2ae955",
          borderColor: "#2ae955",
          data: my_data2
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
            yAxes: [{
                ticks: {
                    min: 0,
                    max: 100000,
                }
            }],
        },
        legend: {
            display: true
        },
    }
  });
});