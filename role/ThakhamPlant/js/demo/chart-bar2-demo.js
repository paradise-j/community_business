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
    const res = await fetch("/community_business/api/get_export.php");
    const json = await res.json()
    return json;
  }

  var ctx = document.getElementById("myBarChart");
  const my_dataAll2 = await get_total_goat();


  let res_1 = []
  my_dataAll2.forEach(obj => {
      let name = obj['veg_name']
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

      let total = obj.export_quan
      res_1[name] = res_1[name] || []
      res_1[name][month] = res_1[name][month] || []
      res_1[name][month] = total
  })
  console.log(res_1)

  var my_data3 = [];
  var my_label3 = [];
  var Unique_month3 = [];
  my_dataAll2.forEach(item => {
      my_data3.push(item.export_quan);
      switch (item.month) {
          case "1" :
              my_label3.push('มกราคม')
              break;
          case "2" :
              my_label3.push('กุมภาพันธ์')
              break;
          case "3" :
              my_label3.push('มีนาคม')
              break;
          case "4" :
              my_label3.push('เมษายน')
              break;
          case "5" :
              my_label3.push('พฤษภาคม')
              break;
          case "6" :
              my_label3.push('มิถุนายน')
              break;
          case "7" :
              my_label3.push('กรกฎาคม')
              break;
          case "8" :
              my_label3.push('สิงหาคม')
              break;
          case "9" :
              my_label3.push('กันยายน')
              break;
          case "10" :
              my_label3.push('ตุลาคม')
              break;
          case "11" :
              my_label3.push('พฤศจิกายน')
              break;
          case "12" :
              my_label3.push('ธันวาคม')
              break; 
      }
      
  });

  for( var i=0; i<my_label3.length; i++ ) {
      if ( Unique_month3.indexOf( my_label3[i] ) < 0 ) {
      Unique_month3.push( my_label3[i] );
      }
  } 

  console.log("my_data3 = "+ my_data3);
  console.log("Unique_month3 = "+ Unique_month3);


  function getRandomArbitrary(min, max) {
      return Math.floor(Math.random() * (max - min) + min);
  }


  let backgroundColor = ["#256ae3","#8450ca","#ef34f6","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206","#eef73e","#87be7e","#2aa251","#17d1ae"]

  let borderColor = ["#256ae3","#8450ca","#ef34f6","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206","#eef73e","#87be7e","#2aa251","#17d1ae"]

  let labels = Unique_month3
  let datasets = []
  let tasrgets = Object.keys(res_1)


  let color_index = 0

  tasrgets.forEach(tasrget => {
      let data = []
      labels.forEach(month => {
          let total = res_1[tasrget][month] || "0.00"
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
  console.log("data = "+ data);
  
  var ctx = document.getElementById('myBarChart2');
  var myBarChart2 = new Chart(ctx, {
      type: 'bar',
      data: data ,
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