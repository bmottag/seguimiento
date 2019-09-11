<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/establecimiento.js"); ?>"></script>

<script>
$(document).ready(function () {
	
    $('#tipo_documento').change(function () {
        $('#tipo_documento option:selected').each(function () {
            var tipo_documento = $('#tipo_documento').val();
            $('#digitoConfirm').val("");
			$('#digito').val("");
			$('#documento').val("");
			$('#documentosConfirm').val("");
			
			if (tipo_documento == 1) {
				$("#div_digito").css("display", "inline");
				$("#div_digito_confirmar").css("display", "inline");
            } else {
				$("#div_digito").css("display", "none");
				$("#div_digito_confirmar").css("display", "none");
            }
			
            if (tipo_documento == 4 || tipo_documento == 5) {
				$("#div_cedula").css("display", "none");
				$("#div_cedula_confirmar").css("display", "none");
				$("#div_digito").css("display", "none");
				$("#div_digito_confirmar").css("display", "none");
            } else {
				$("#div_cedula").css("display", "inline");
				$("#div_cedula_confirmar").css("display", "inline");
            }
			
        });
    });
    
});
</script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Identificación del establecimiento y/o propietario
	<br><small>Adicionar/Editar</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_establecimiento"]:""; ?>"/>		
		<input type="hidden" id="hddIdManzana" name="hddIdManzana" value="<?php echo $idManzana; ?>"/>


		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="nombre">Nombre comercial, razón social o  nombre del propietario : *</label>
					<input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $information?$information[0]["nombre_propietario"]:""; ?>" placeholder="Nombre del propietario" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="address2">Dirección del establecimiento : *</label>
					<input type="text" id="address2" name="address2" class="form-control" value="<?php echo $information?$information[0]["direccion"]:""; ?>" placeholder="Dirección" >
				</div>
			</div>
		</div>
		
		<div class="row" style="display: none">
			<div class="col-sm-12">
						<div class="form-group">	
							<div class="row" align="center">
								<div style="width:80%;" align="center">
									<div id="map" style="width: 100%; height: 150px"></div>	
								</div>
							</div>	
						</div>	
			</div>
		</div>

		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
						<label for="type" class="control-label">Ubicación : *</label>

						<input id="viewaddress" name="viewaddress" class="form-control" type="text" disabled value="<?php echo $information?$information[0]["address"]:""; ?>">
						<input id="latitud" name="latitud" type="hidden">					
						<input id="longitud" name="longitud" type="hidden">	
						<input id="address" name="address" type="hidden" value="<?php echo $information?$information[0]["address"]:""; ?>">									
						
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="telefono">Teléfono y/o celular del establecimiento : *</label>
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["telefono"]:""; ?>" placeholder="Teléfono" >
				</div>
			</div>
		</div>

		
		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="tipo_documento">Tipo documento del establecimiento : *</label>
					<select name="tipo_documento" id="tipo_documento" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["tipo_documento"] == 1) { echo "selected"; }  ?>>NIT/RUT</option>
						<option value=2 <?php if($information[0]["tipo_documento"] == 2) { echo "selected"; }  ?>>Cédula de ciudadanía C.C.</option>
						<option value=3 <?php if($information[0]["tipo_documento"] == 3) { echo "selected"; }  ?>>Cédula de extranjería C.E.</option>
						<option value=4 <?php if($information[0]["tipo_documento"] == 4) { echo "selected"; }  ?>>No tiene</option>
						<option value=5 <?php if($information[0]["tipo_documento"] == 5) { echo "selected"; }  ?>>NS/NR</option>
					</select>
				</div>
			</div>
		</div>

<?php 
	$mostrar2 = "inline";
	if($information){
		if($information[0]["tipo_documento"]==4 || $information[0]["tipo_documento"]==5){
			$mostrar2 = "none";
		}
	}else{
		$mostrar2 = "none";
	}
?>
		
		<div class="row" id="div_cedula" style="display: <?php echo $mostrar2; ?>">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="documento">No. Documento : *</label>
					<input type="text" id="documento" name="documento" class="form-control" value="<?php echo $information?$information[0]["cedula"]:""; ?>" placeholder="No. Documento" >
				</div>
			</div>			
		</div>
		
		
<?php 
	$mostrar = "none";
	if($information && $information[0]["tipo_documento"]==1){
		$mostrar = "inline";
	}
?>
						
		<div class="row" id="div_digito" style="display: <?php echo $mostrar; ?>">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="digito">Digito de Verificación D.V.  : </label>
					<input type="text" id="digito" name="digito" class="form-control" value="<?php echo $information?$information[0]["digito"]:""; ?>" placeholder="Digito de Verificación D.V." >
				</div>
			</div>					
		</div>
		
		<div class="row" id="div_cedula_confirmar" style="display: <?php echo $mostrar2; ?>">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="documentosConfirm">Confirmar No. Documento : *</label>
					<input type="text" id="documentosConfirm" name="documentosConfirm" class="form-control" value="<?php echo $information?$information[0]["cedula"]:""; ?>" placeholder="Confirmar No. Documento" >
				</div>
			</div>			
		</div>
		
		<div class="row" id="div_digito_confirmar" style="display: <?php echo $mostrar; ?>">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="digitoConfirm">Confirmar Digito de Verificación D.V.  : </label>
					<input type="text" id="digitoConfirm" name="digitoConfirm" class="form-control" value="<?php echo $information?$information[0]["digito"]:""; ?>" placeholder="Confirmar Digito de Verificación D.V." >
				</div>
			</div>			
		</div>
		
		
<!-- campo para aprobar encuesta, solo se habilita para los supervisores o coordinaores -->
<?php 

if($information){
$userRol = $this->session->userdata("rol");
if($userRol == 2){ //SUPERVISOR
?>

		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=0 <?php if($information[0]["aprobacion_supervisor"] == 0) { echo "selected"; }  ?>>Desaprobada</option>
						<option value=3 <?php if($information[0]["aprobacion_supervisor"] == 3) { echo "selected"; }  ?>>Aprobada</option>
					</select>
				</div>
			</div>
		</div>
<?php
}elseif($userRol == 4 && $information[0]["aprobacion_supervisor"] == 3){ //COORDINADOR
?>

		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=1 <?php if($information[0]["aprobacion_coordinador"] == 1) { echo "selected"; }  ?>>Desaprobada</option>
						<option value=4 <?php if($information[0]["aprobacion_coordinador"] == 4) { echo "selected"; }  ?>>Aprobada</option>
					</select>
				</div>
			</div>
		</div>
<?php
}}
?>
		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<input type="button" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div id="div_load" style="display:none">		
				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
						<span class="sr-only">45% completado</span>
					</div>
				</div>
			</div>
			<div id="div_error" style="display:none">			
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj"></span></div>
			</div>	
		</div>
			
	</form>
</div>


<?php if(!$information){ ?>
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
	  
	  ultimaPosicionUsuario = new google.maps.LatLng(crd.latitude, crd.longitude);
      marcadorUsuario = new google.maps.Marker({
        position: ultimaPosicionUsuario,
        map: map
      });
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
		var pais = new google.maps.LatLng(51.0209884,-114.1591999);
		var mapOptions = {
			center: pais,
			zoom: 11,
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
	
<?php } ?>