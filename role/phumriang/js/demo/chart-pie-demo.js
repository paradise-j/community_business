// Set new default font family and font color to mimic Bootstrap's default styling
window.addEventListener('DOMContentLoaded', async (event) => {
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  // Pie Chart Example
  async function get_total_InEx() {
    const res = await fetch("/community_business/api/get_InEx_phumriang.php");
    const json = await res.json()
    return json;
  }


  var ctx = document.getElementById("myPieChart");

  const data = await get_total_InEx();
  var my_data = [];
  var my_label = [];
  data.forEach(item => {
    my_data.push(item.money)
    switch (item.inex_type) {
      case "รายรับ":
        my_label.push('รายรับ')
        break;
      case "รายจ่าย":
        my_label.push('รายจ่าย')
        break;
    }
  });
  // console.log(my_data);
  // console.log(my_label);

  var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: my_label,
      datasets: [{
        data: my_data,
        backgroundColor: ['#c33e22', '#1cc88a'],
        hoverBackgroundColor: ['#c33e22', '#17a673'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
     
    },
  });
});