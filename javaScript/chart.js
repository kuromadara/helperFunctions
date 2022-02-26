function chart(){
  var ctx = document.getElementById("myChart").getContext("2d");
  var myChart = new Chart(ctx, {
  type: "doughnut",
  data: {
      labels: ["HSIL", "LSIL", "ASCUS", "NILM"    ],
      datasets: [{
      backgroundColor: [
          "#d50000",
          "#003cff",
          "#ffff00",
          "#00e676"
      ],
      data: [{{hs}}, {{ls}}, {{as}}, {{nl}}]
      }]
  },
  options: {
      legend: {
          labels: {
              fontColor: "black",
              fontSize: 15,
              fontStyle: "bold"


          }
      }
  }
  });

}

<canvas id="myChart"></canvas>
