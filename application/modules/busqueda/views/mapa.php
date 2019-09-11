    <style>
      #map {
        height: 550px;
        width: 100%;
       }
    </style>
<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-users"></i> GEOLOCALIZACIÓN DEL ESTABLECIMIENTO
				</div>
				<div class="panel-body">
				
    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $info[0]['latitud'];?>, lng: <?php echo $info[0]['longitud'];?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
		
		var contentString = '<div id="content">'+
		  '<div id="siteNotice">'+
		  '</div>'+
		  '<div id="bodyContent">'+
		  '<p><b><?php echo $info[0]['nombre_propietario'];?></b></p>'+
		  '<p><b>Dirección: </b>'+'<?php echo $info[0]['direccion_normalizada'];?>'+
		  '<br><b>Comuna: </b>'+'<?php echo $info[0]['fk_id_comuna'];?>'+
		  '</p>'+
		  '</div>'+
		  '</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
		
		infowindow.open(map, marker);
		
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoRXVDwlASd0KepKmu-5Mh5G3yGlb_mV4&callback=initMap">
    </script>
	
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