<?php
include './funciones.php';

$link=Conexion();
$sql="SELECT * FROM lugares";
$res=mysqli_query($link,$sql);

?>

<!DOCTYPE html>
<html>
  <head>    
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>	
  </head>
  <body>
  <div id="map" style="height: 100%;"></div>
  <script>

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 6,
    center: {lat: -36, lng: -60}
  });

  setMarkers(map);
}

var lugares = [  
  <?php
	while($row = mysqli_fetch_assoc ($res)){
    //$imgsrc   ="./app/recupera_imagen.php?id=".$row['id'];
    //$contenido = "<p> NOMBRE: ".addslashes($row['nombre'])."<br><img src='data:;base64,".$imgsrc."' class='img-responsive' alt=''/><p>".substr(addslashes($row['descripcion']),0,60)."...</p>";
    
    //$contenido="<b>hola</b>";
    $contenido='<p><b> NOMBRE: '.addslashes($row['nombre']).'</b></p><br><img src="data:image/jpeg;base64,'.$row["imagen"].'" class="img-responsive" alt="'.addslashes($row['nombre']).'"> <p>'.substr(addslashes($row['descripcion']),0,55).'...</p>';

		//echo "['".$row['nombre']."',".$row['latitud'].",".$row['longitud'].",'".html_entity_decode($row['descripcion'])."',true],\n";		
    echo "['".$row['nombre']."',".$row['latitud'].",".$row['longitud'].",'".html_entity_decode($contenido)."',true],\n";   
	}
	@mysqli_close($link);
	?>
];

function setMarkers(map) {

  var icono={
    url: '../images/ico_mapa2.png',
    size: new google.maps.Size(32, 32),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(0, 0)
  };

  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
  
  var infoWindow = new google.maps.InfoWindow;
  
  for (var i = 0; i < lugares.length; i++) {
    var lugar = lugares[i];	
	
    var marker = new google.maps.Marker({
      position: {lat: lugar[1], lng: lugar[2]},
      map: map,
      icon:  icono,
      //shape: shape,
      title: lugar[0],
      zIndex: lugar[5]
     
    });	
	bindInfoWindow(marker, map, infoWindow, lugar[3]);
  }
}

function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {infoWindow.setContent(html);infoWindow.open(map, marker);});
}

</script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_SESSION['apy_key']; ?>&signed_in=true&callback=initMap"></script>
	<div id="datos" name="datos"></div>	
  </body>
</html>