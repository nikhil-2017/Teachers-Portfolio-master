<?php 
//index.php
$connect = mysqli_connect("localhost", "root", "", "xyz");
 $query = "SELECT * FROM graphw";
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
 $chart_data .= "{ day:'".$row["day"]."', duration:".$row["time_duration"]. "}, ";
}
$chart_data = substr($chart_data, 0, -1);
?>
 
 
<!DOCTYPE html>
<html>
 <head>
  <title>chart with PHP & Mysql | lisenme.com </title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <div id="area"></div>
  </div>
 </body>
</html>
 
<script>
Morris.Area({
 element : 'area',
 data:[<?php echo $chart_data; ?>],
 xkey:'day',
 ykeys:['duration'],
 labels:['day', 'duration'],
 hideHover:'auto',
 stacked:true
});
</script>