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
    const res = await fetch("/community_business/api/get_deduct-package_phumriang.php");
    const json = await res.json()
    return json;
  }

  var ctx = document.getElementById("myChartBar2");
  const my_dataAll = await get_total_goat();

  let res = []
  my_dataAll.forEach(obj => {
      let type = obj['type']
      let month = ''
      switch (obj['month']) {
          case "1" :
              month ='มกราคม'
              break;
          case "2" :
              month ='กุมภาพันธ์'
              break;
          case "3" :
              month ='มีนาคม'
              break;
          case "4" :
              month ='เมษายน'
              break;
          case "5" :
              month ='พฤษภาคม'
              break;
          case "6" :
              month ='มิถุนายน'
              break;
          case "7" :
              month ='กรกฎาคม'
              break;
          case "8" :
              month ='สิงหาคม'
              break;
          case "9" :
              month ='กันยายน'
              break;
          case "10" :
              month ='ตุลาคม'
              break;
          case "11" :
              month ='พฤศจิกายน'
              break;
          case "12" :
              month ='ธันวาคม'
              break; 
      }

      let deduct = obj['deduct']
      res[type] = res[type] || []
      res[type][month] = res[type][month] || []
      res[type][month] = deduct
  })

  var my_data = [];
  var my_label = [];
  var Unique_month = [];
  my_dataAll.forEach(item => {
      my_data.push(item.deduct);
      switch (item.month) {
          case "1" :
              my_label.push('มกราคม')
              break;
          case "2" :
              my_label.push('กุมภาพันธ์')
              break;
          case "3" :
              my_label.push('มีนาคม')
              break;
          case "4" :
              my_label.push('เมษายน')
              break;
          case "5" :
              my_label.push('พฤษภาคม')
              break;
          case "6" :
              my_label.push('มิถุนายน')
              break;
          case "7" :
              my_label.push('กรกฎาคม')
              break;
          case "8" :
              my_label.push('สิงหาคม')
              break;
          case "9" :
              my_label.push('กันยายน')
              break;
          case "10" :
              my_label.push('ตุลาคม')
              break;
          case "11" :
              my_label.push('พฤศจิกายน')
              break;
          case "12" :
              my_label.push('ธันวาคม')
              break; 
      }
      
  });

  for( var i=0; i<my_label.length; i++ ) {
      if ( Unique_month.indexOf( my_label[i] ) < 0 ) {
      Unique_month.push( my_label[i] );
      }
  } 

  console.log("my_data01 = "+ my_data);
  // console.log("my_label = "+ my_label);
  console.log("Unique_month01 = "+ Unique_month);
  console.log("------------------------------------------------");


  function getRandomArbitrary(min, max) {
      return Math.floor(Math.random() * (max - min) + min);
  }


  let backgroundColor = ["#eef73e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6","#87be7e","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206"]

  let borderColor = ["#eef73e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6","#87be7e","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206"]

  let labels = Unique_month
  let datasets = []
  let tasrgets = Object.keys(res)


  let color_index = 0

  tasrgets.forEach(tasrget => {
      let data = []
      labels.forEach(month => {
          let total = res[tasrget][month] || "0.00"
          data.push(total)
      })
      datasets.push({
          label: tasrget,
          data,
          backgroundColor: backgroundColor[color_index],
          borderColor: borderColor[color_index],
          borderWidth: 1
      })

      color_index = color_index+1
  })


  let data = { labels, datasets }
  // console.log("data = "+ data)

  var ctx = document.getElementById('myChartBar2');
  var myChartBar2 = new Chart(ctx, {
      type: 'bar',
      data ,
      options: {
          maintainAspectRatio: false,
          scales: {
              y: {
                  beginAtZero: true
              }
          },
          legend: {
              display: true
          }
      }
  });
});