<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> ESTABLECIMIENTO
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url().'encuesta/establecimiento/' . $information[0]["fk_id_manzana"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-automobile"></i> GEOLOCALIZACIÓN ESTABLECIMIENTO
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-warning">
										<strong>No. Formulario: </strong>
										<?php echo $information[0]['id_establecimiento']; ?>
										<br><strong>Nombre comercial, razón social o  nombre del propietario: </strong>
										<?php echo $information[0]['nombre_propietario']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>

					<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("encuesta/update_geolocalizacion/" . $information[0]["fk_id_manzana"]); ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $idEstablecimiento; ?>"/>
					

					<div class="col-sm-6">
						<div class="form-group">	
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="map" style="width: 100%; height: 170px"></div>	
								</div>
							</div>	
						</div>	
					</div>

					<div class="col-sm-6">
						<div class="form-group text-left">
								<label for="type" class="control-label">Ubicación : *</label>

								<input id="viewaddress" name="viewaddress" class="form-control" type="text" disabled value="<?php echo $information?$information[0]["address"]:""; ?>">
								<input id="latitud" name="latitud" type="hidden">					
								<input id="longitud" name="longitud" type="hidden">	
								<input id="address" name="address" type="hidden" value="<?php echo $information?$information[0]["address"]:""; ?>">									

								<a class="btn btn-success btn-circle" href=" <?php echo base_url().'encuesta/geolocalizacion/' . $information[0]['id_establecimiento']; ?> "><i class="fa fa-refresh "></i> </a> 
							
						</div>
					</div>
	
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<input type="submit" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
							</div>
						</div>
					</div>


					</form>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->


  <script>
    // The following example creates complex markers to indicate beaches near
	// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
	// to the base of the flagpole.

	var options = {
	  enableHighAccuracy: true,
	  timeout: 5000,
	  maximumAge: 0
	};

	function success(pos) {
	  var crd = pos.coords;

	  console.log('Your current position is:');
	  console.log('Latitude : ' + crd.latitude);
	  console.log('Longitude: ' + crd.longitude);
	  console.log('More or less ' + crd.accuracy + ' meters.');
	  $("#latitud").val(crd.latitude);
	  $("#longitud").val(crd.longitude);
	  var pos = {
				  lat: crd.latitude,
				  lng: crd.longitude
				};
	  map.setCenter(pos);
	  map.setZoom(14);
	  
	showLatLong(crd.latitude, crd.longitude);
	
  var contentString = '<div id="content">'+
      '<div id="bodyContent">'+
      '<p><b>Nota</b>: Si desea cambiar la ubicación guarde la información.</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });
	  
	  ultimaPosicionUsuario = new google.maps.LatLng(crd.latitude, crd.longitude);
      marcadorUsuario = new google.maps.Marker({
        position: ultimaPosicionUsuario,
        map: map,
		title: 'Ubicación establecimiento.'
      });
	  
	  

    infowindow.open(map, marcadorUsuario);
  

	  
	  
	  
	  
	};

	function error(err) {
	  console.warn('ERROR(' + err.code + '): ' + err.message);
	};

	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
							  'Error: Error en el servicio de localizacion.' :
							  'Error: Navegador no soporta geolocalizacion.');
	  }
	

/**
 * INICIO --- Capturar direccion
 * http://www.elclubdelprogramador.com/2012/04/22/html5-obteniendo-direcciones-a-partir-de-latitud-y-longitud-geolocalizacion/
 */
function showLatLong(lat, longi) {
var geocoder = new google.maps.Geocoder();
var yourLocation = new google.maps.LatLng(lat, longi);
geocoder.geocode({ 'latLng': yourLocation },processGeocoder);

}
function processGeocoder(results, status){

if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
document.forms[0].address.value=results[0].formatted_address;
document.forms[0].viewaddress.value=results[0].formatted_address;
} else {
error('Google no retorno resultado alguno.');
}
} else {
error("Geocoding fallo debido a : " + status);
}
}
/**
 * FIN
 */	
	
	function initMap() {
		var pais = new google.maps.LatLng(4.1249257,-73.6791013);
		var mapOptions = {
			center: pais,
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		
		
		
		//Inicializa el objeto geocoder
		geocoder = new google.maps.Geocoder();
				
		navigator.geolocation.getCurrentPosition(success, error, options);
		
		/*var infoWindow = new google.maps.InfoWindow({map: map});
		// Try HTML5 geolocation.
        if (navigator.geolocation) {
			  navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
				  lat: position.coords.latitude,
				  lng: position.coords.longitude
				};

				infoWindow.setPosition(pos);
				infoWindow.setContent('Su ubicacion.');
				map.setCenter(pos);
			  }, function() {
				handleLocationError(true, infoWindow, map.getCenter());
			  });
			} else {
			  // Browser doesn't support Geolocation
			  handleLocationError(false, infoWindow, map.getCenter());
			}
*/
	}	

  </script>

			
	<!--<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap">
		http://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap"
	</script>-->
	<script async defer		
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt__a_n1IUtBPqj9ntMD5cNG8gYlcovWM&libraries=places&callback=initMap">
	</script>