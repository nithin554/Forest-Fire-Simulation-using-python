<?php
$host = "localhost";
$user = "root";
$pass = "12345";
$db = "forest_fire";
$conn = mysqli_connect($host,$user,$pass,$db);
$sql = "select * from node_data order by updated_on DESC limit 8";
$result = mysqli_query($conn,$sql);
$n = mysqli_num_rows($result);
$i = 0;
$row = array();
for ($i=0;$i<$n;$i++) {
    array_push($row,mysqli_fetch_assoc($result));
}
$i=0;
$temp = array();
$humidity = array();
$max_temp = 0;
$max_humidity = 0;
$lat = 0;
$long = 0;
$node_no = 0;
for ($i=0;$i<$n;$i++) {
    if($max_temp<$row[$i]["temp"]){
        $max_temp = $row[$i]["temp"];
        $max_humidity = $row[$i]["humidity"];
        $lat = $row[$i]["latitude"];
        $long = $row[$i]["longitude"];
        $node_no = $row[$i]["node_id"];
    }
    array_push($temp,$row[$i]["temp"]);
    array_push($humidity,$row[$i]["humidity"]);
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Temperature & Humidity Monitoring</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.4.min.js"></script>')</script>
    <meta http-equiv="refresh" content="5">
</head>
<script>
//var counter = 0;
//localStorage.setItem(counter, "0");
</script>
<body>
    <nav id="mainNav" class="navbar static-top navbar-toggleable-md navbar-inverse bg-inverse">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Forest Fire Monitoring</a>
        <div class="collapse navbar-collapse" id="navbarExample">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper py-3">

        <div class="container-fluid">

                <div class="row">
                      <div class="col-md-8">
            <div class="card mb-3">
            <div class="card-block text-center">
            	<div class="row">
            	<div class="col-md-3">
            		<img src="temp.png" class="rounded float-center" height="40" width="40">
            		</br>
            	<h6 id="hahatemp" class="text-center"></h6>
            	</div>
            	<div class="col-md-3">
            		<img src="hum.png" class="rounded float-center" height="40" width="40">
            		</br>
            	<h6 id="hahahumi" class="text-center"></h6>
            	</div>
            	<div class="col-md-3">
                    <h6>At Node:</h6>
                      <h6 id="hahanode" class="text-center"></h6>
                </div>

                    <div class="col-md-3">
                      <h6>Chances of Fire:</h6>
                      <h6 id=chancesfire class="text-center"></h6>
                    </div>
            	</div>

            </div>
            </div>

<!-- Area Chart Example -->

<div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-area-chart"></i> Data Chart
            </div>
            <div class="card-block text-center">
            <canvas id="myChart" width="100%" height="40"></canvas>
           <!--<div id="parent">-->
           <!--</div>-->

<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [1,2,3,4,5,6,7,8],
        datasets: [
            {
            label: 'Temperature',
            data: <?php echo json_encode($temp); ?>,
           	backgroundColor: 'rgba(75, 192, 192, 0.3)',
            borderColor:'rgba(75, 192, 192, 1)',
            borderWidth: 1
            },
            {
            label: 'Humidity',
            data: <?php echo json_encode($humidity); ?>,
            backgroundColor: 'rgba(153, 102, 255, 0.3)',
            borderColor:'rgba(153, 102, 255, 0.2)',
            borderWidth: 1
            },
            ]
    },
    options: {
        scales: {
            yAxes: [{
                type: "linear",
                animationSteps: 5,
            }]
        }
    }
});
        var temp = <?php echo $max_temp ?>;
        var humid = <?php echo $max_humidity ?>;
       document.getElementById("hahatemp").innerHTML = "Temperature: " + "<?php echo $max_temp ?>" +"°C";
	
       if(temp > 40 && humid < 50){
        document.getElementById("chancesfire").innerHTML = "Fire Might Occur";
		//counter = 1;
		//localStorage.setItem("1",counter);
	}
     
	else if (temp > 40 && humid>=50){
	document.getElementById("chancesfire").innerHTML = "High humidity Fire May Not Occur";
	//console.log(counter)
	}

    else if (temp <= 40)
	{
        document.getElementById("chancesfire").innerHTML = "No Fire";
    }
       humval = <?php echo $max_humidity ?>;
       document.getElementById("hahahumi").innerHTML = "Humidity: " + "<?php echo $max_humidity ?>" + "%";
       document.getElementById("hahanode").innerHTML = "<?php echo $node_no ?>";
       //rainval = 22;
       //document.getElementById("haharain").innerHTML = rainval;
       //timeval = "10:25:20";
    /*
     $('#dataTable').load('index.php #dataTable');
     myChart.data.datasets[0].data.shift();
     myChart.data.datasets[1].data.shift();
     myChart.data.labels.shift();
     myChart.data.datasets[0].data[7] = temp;
     myChart.data.datasets[1].data[7] = humval;
     myChart.data.labels[4] = timeval;
     myChart.update();
     */
</script>
                      
            </div>
            <div class="card-footer small text-muted">
                <?php date_default_timezone_set('Asia/Kolkata');echo "Updated on " . date("d-m-Y h:i:sa"); ?>
            </div>
              </div>


<div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-area-chart"></i> Location
            </div>
            <div class="card-block text-center">
	    	<style>
      		#map {
        	height: 400px;
        	width: 100%;
       		}
    </style>
    		<div id="map"></div>
            <p>Last seen highest temperature at : Node => <?php echo($node_no) ?> Latitude => <?php echo($lat) ?> , Longitude => <?php echo($long) ?></p>
    <script>
      function initMap() {
        var location_node = {lat: <?php echo $lat ?>, lng: <?php echo $long ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: location_node
        });
        var marker = new google.maps.Marker({
          position: location_node,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=yourgoogleapikey&callback=initMap">
    </script>
	    </div>
</div>
                      </div>
                      <div class="col-md-4">
                        <!-- Example Tables Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <i class="fa fa-table"></i> Data Table
                                </div>
                                <div class="card-block">
                                    <div  class="table-responsive" >

                                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Time</th>
                                                    <th class="text-center">Temperature</th>
                                                    <th class="text-center">Humidity</th>
                                                    <th class="text-center">Node</th>
                                                </tr>
                                            </thead>
                                            <script type="text/javascript">
                                              //$(document).ready(function() {
                                                //setInterval(function () {
                                                  //$('#dataTable').load('index.php #dataTable')
                                                //}, 2000);
                                              //});
                                            </script>
                                            <tbody>
                                            <?php     
                                            $i = 0; 
                                            for($i=0;$i<$n;$i++) {
                                                if($row[$i]["temp"]>40){
                                                    printf("<tr bgcolor='red' style='color: white;'>
                                                        <td> &nbsp;%s</td><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", $row[$i]["updated_on"], $row[$i]["temp"], $row[$i]["humidity"] ,$row[$i]["node_id"]);
                                                }
                                                else{
                                                printf("<tr>
                                                        <td> &nbsp;%s</td><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", $row[$i]["updated_on"], $row[$i]["temp"], $row[$i]["humidity"] ,$row[$i]["node_id"]);
                                                    }    
                                                }    
                                            ?>
                                            </tbody>
                                        </table>
                                        <a href="full_log.php">Click to view full log</a>
                                    </div>
                                    
                                </div>
                                <div class="card-footer small text-muted">
                                    <?php date_default_timezone_set('Asia/Kolkata');echo "Updated on " . date("d-m-Y h:i:sa"); ?>
                                </div>
                            </div>
                      </div>
                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->

    <a class="scroll-to-top rounded" href="#">
        <i class="fa fa-chevron-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>  
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Custom scripts for this template <script src="js/sb-admin.min.js"></script>-->
    <script src="js/sb-admin.js"></script>
    <!-- Plugin JavaScript<script src="vendor/datatables/jquery.dataTables.min.js"></script>-->
    
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script> 
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>
