<?php
$host = "localhost";
$user = "root";
$pass = "12345";
$db = "forest_fire";
$conn = mysqli_connect($host,$user,$pass,$db);
$sql = "select * from node_data order by updated_on DESC";
$result = mysqli_query($conn,$sql);
$n = mysqli_num_rows($result);
$i = 0;
$row = array();
for ($i=0;$i<$n;$i++) {
    array_push($row,mysqli_fetch_assoc($result));
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Temperature & Humidity Monitoring - Full Log</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Plugin CSS -->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.4.min.js"></script>')</script>
    <script src="https://www.gstatic.com/firebasejs/3.5.2/firebase.js"></script>
</head>
<body>
<div class="col-md-4">
<!-- Example Tables Card -->
    <div class="card mb-3" style="width:950px;">
        <div class="card-header" style="width:950px;">
            <i class="fa fa-table"></i> Data Table <a href="index.php" style="margin-left:620px;">Click to go back to home</a>
        </div>
        <div class="card-block" style="width:950px;">
            <div  class="table-responsive" style="width:900px;">
            <input type="text" id="search" onkeyup="myFunction()" placeholder="Search by Date.." title="Type in Date">
                <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">Time</th>
                            <th class="text-center">Temperature</th>
                            <th class="text-center">Humidity</th>
                            <th class="text-center">Node</th>
                            <th class="text-center">Latitude</th>
                            <th class="text-center">Longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php     
                        $i = 0; 
                        for($i=0;$i<$n;$i++) {
                            if($row[$i]["temp"]>40){
                                printf("<tr bgcolor='red' style='color: white;'>
                                        <td> &nbsp;%s</td><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", $row[$i]["updated_on"], $row[$i]["temp"], $row[$i]["humidity"], $row[$i]["node_id"], $row[$i]["latitude"], $row[$i]["longitude"]);
                                }
                            else{
                                printf("<tr>
                                        <td> &nbsp;%s</td><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", $row[$i]["updated_on"], $row[$i]["temp"], $row[$i]["humidity"], $row[$i]["node_id"], $row[$i]["latitude"], $row[$i]["longitude"]);
                                }    
                            }    
                    ?>
                    </tbody>
                </table>
                
            </div>    
        </div>
        <div class="card-footer small text-muted">
        <?php date_default_timezone_set('Asia/Kolkata');echo "Updated on " . date("d-m-Y h:i:sa"); ?>
        </div>
    </div>
</div>
<script>


function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>