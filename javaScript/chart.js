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


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>

/**
 * Dynamically generate Chart
 */

window.onload = function chart() {

  var data = JSON.parse(`<?php echo $no_of_employees; ?>`);
  // access dname from data
    var code = data.map(function(d) { return d.code; });
    var empCount = data.map(function(d) { return d.empCount; });
    // console.log(dname);


  var ctx = document.getElementById("myChart").getContext("2d");
  var myChart = new Chart(ctx, {
  type: "bar",
  data: {
      labels: code,
      datasets: [{
      backgroundColor: [
          "#d50000",
          "#003cff",
          "#ffff00",
          "#00e676"
      ],
      data: empCount,
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


public function index()
 {
     $no_of_employees = DB::table('employees')
         ->select('departments.code','departments.name as dname',\DB::raw('count(employees.id) as empCount'))
         ->join('departments', 'departments.id', '=', 'employees.department_id')
         ->groupBy('departments.code')
         ->get();


     // dd($no_of_employees);

     return view('hr.employee-strength-report',compact('no_of_employees'));
 }
