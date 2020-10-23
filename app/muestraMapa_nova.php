<?php
include './config.php';
include './funciones.php';
$link=Conexion();
$sql="SELECT * FROM lugares";
$res=mysqli_query($link,$sql) or die(Error($sql,$link));
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="Content-Language" content="es-ar">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Pragma" content="no-cache">
  <meta name="copyright" content="2017">
  <meta name="language" content="ES">
  <meta name="Description" content="Mapa PBA">
  <meta name="Keywords" content="mapa pba buenos">
    <title>Mapa</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
  <script language="javascript" src="./js/funciones.js" type="text/javascript"></script>
  <script language="javascript" src="./js/excellentexport.js" type="text/javascript"></script>
  </head>
  <body>
    <div id="map"></div>
    <script>

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 7,
    center: {lat: -37, lng: -55}
  });

  setMarkers(map);
}

var lugares = [  
  <?php
  while($row = mysqli_fetch_assoc ($res)){
    echo "['".$row['nombre']."',".$row['latitud'].",".$row['longitud'].",'".html_entity_decode($row['descripcion'])."',true],\n";   
  }
  @mysqli_close($link);
  ?>
];

function setMarkers(map) {

  var normal = {
    url: './img/home.png',
    size: new google.maps.Size(16, 16),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(0, 0)
  };
  
  var alerta = {
    url: './img/alerta.png',
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
  
  if (lugar[4]==true){
    estado=normal;
  }else{
    estado=alerta;
  }
  
    var marker = new google.maps.Marker({
      position: {lat: lugar[1], lng: lugar[2]},
      map: map,
      icon: estado,
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY-8hCAIxnohpQWSA8YGGgogAOdrq_nC8&signed_in=true&callback=initMap"></script>
  <div id="datos" name="datos" align="center"></div>  
  </body>
</html>