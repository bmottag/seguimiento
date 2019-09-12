<script>
$(function(){ 
	$(".btn-danger").click(function () {	
			
			//Activa icono guardando
			if(window.confirm('Esta seguro de eliminar los registros de la Base de Datos?'))
			{
					$(".btn-danger").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'admin/eliminar_db',
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-danger").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-danger").removeAttr('disabled');

								var url = base_url + "admin/atencion_eliminar";
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-danger").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-danger").removeAttr('disabled');
						}

					});
			}
	});
	
	$(".btn-warning").click(function () {	
			
			//Activa icono guardando
			if(window.confirm('Esta seguro de eliminar los registros de la Base de Datos?'))
			{
					$(".btn-warning").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'admin/eliminar_sitios_db',
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-warning").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-warning").removeAttr('disabled');

								var url = base_url + "admin/atencion_eliminar";
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-warning").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-warning").removeAttr('disabled');
						}

					});
			}
	});
	
	$(".btn-info").click(function () {	
			
			//Activa icono guardando
			if(window.confirm('Esta seguro de eliminar los registros de la Base de Datos?'))
			{
					$(".btn-info").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'admin/eliminar_usuarios_db',
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-info").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-info").removeAttr('disabled');

								var url = base_url + "admin/atencion_eliminar";
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-info").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-info").removeAttr('disabled');
						}

					});
			}
	});
	
	$(".btn-atencion").click(function () {	
			
			//Activa icono guardando
			if(window.confirm('Esta seguro de eliminar los registros de la Base de Datos?'))
			{
					$(".btn-atencion").attr('disabled','-1');
					$.ajax ({
						type: 'POST',
						url: base_url + 'admin/eliminar_respuestas_db',
						cache: false,
						success: function(data){
												
							if( data.result == "error" )
							{
								alert(data.mensaje);
								$(".btn-atencion").removeAttr('disabled');							
								return false;
							} 
											
							if( data.result )//true
							{	                                                        
								$(".btn-atencion").removeAttr('disabled');

								var url = base_url + "admin/atencion_eliminar";
								$(location).attr("href", url);
							}
							else
							{
								alert('Error. Reload the web page.');
								$(".btn-atencion").removeAttr('disabled');
							}	
						},
						error: function(result) {
							alert('Error. Reload the web page.');
							$(".btn-atencion").removeAttr('disabled');
						}

					});
			}
	});
	
	
});
</script>

<div id="page-wrapper">

	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - ELIMINAR REGISTROS DE LA BASE DE DATOS
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
					<i class="fa fa-gears"></i> ELIMINAR REGISTROS DE LA BASE DE DATOS
				</div>
				<div class="panel-body">
				
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 
					<div class="row">
						<div class="col-lg-4">	
							<div class="alert alert-danger">
								<strong>Atención:</strong> <br>Al aceptar borrará toda la información de Alertas, 
								Sesiones, Grupo de Instrumentos, Sesiones asignadas a cada Sitio, Novedades y las respuestas de los Representantes.
								
								<br><br>
								<button type="button" class="btn btn-danger btn-xs" >
									Aceptar <span class="fa fa-times fa-fw" aria-hidden="true">
								</button>						
							</div>
						</div>

						<div class="col-lg-4">	
							<div class="alert alert-warning">
								<strong>Borrar Examinandos, Holguras y Sitios:</strong> <br>Al aceptar borrará toda la información de Examinandos, Holguras y Sitios.
								<br><br>
								<button type="button" class="btn btn-warning btn-xs" >
									Aceptar <span class="fa fa-times fa-fw" aria-hidden="true">
								</button>						
							</div>
						</div>
						
						<div class="col-lg-4">	
							<div class="alert alert-info">
								<strong>Borrar usuarios:</strong> <br>Al aceptar borrará los Delegados, Operadores y Coordinadores.
								
								<br><br>
								<button type="button" class="btn btn-info btn-xs" >
									Aceptar <span class="fa fa-times fa-fw" aria-hidden="true">
								</button>						
							</div>
						</div>
						
						<div class="col-lg-4">	
							<div class="alert alert-atencion">
								<strong>Borrar Respuestas y Novedades:</strong> <br>Al aceptar borrará las respuestas de los usuarios y las novedades.
								
								<br><br>
								<button type="button" class="btn btn-atencion btn-xs" >
									Aceptar <span class="fa fa-times fa-fw" aria-hidden="true">
								</button>						
							</div>
						</div>
						
					</div>
					
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-gears"></i> SUBIR REGISTROS A LA BASE DE DATOS
				</div>
				<div class="panel-body">
									
					<div class="row">
						
						<div class="col-lg-4">	
							<div class="alert alert-success">
								Subir registros a la tabla <strong>Sitios</strong>.
								<br><br>
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/subir_archivo/cargar_archivo'; ?> ">
Subir Sitios <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
						
							</div>
						</div>
						
						<div class="col-lg-4">	
							<div class="alert alert-success">
								Subir registros a la tabla <strong>Examinandos</strong>. Tener en cuenta que primero debe subir la información de sitios. <br><strong>Solo subir como máximo de a 33mil registros a la vez.</strong>
								<br><br>
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/subir_archivo/cargar_examinandos'; ?> ">
Subir Examinandos <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
						
							</div>
						</div>
						
						<div class="col-lg-4">	
							<div class="alert alert-success">
								Subir registros a la tabla <strong>Usuarios</strong>.
								<br><br>
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/subir_archivo/cargar_usuarios'; ?> ">
Subir Usuarios <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 

								<br><br>
								Actualizar la tabla de sitios con los registros de los representantes.
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/update_sitios_representantes'; ?> ">
Actualizar <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
						
							</div>
						</div>
					</div>
					
					
					<div class="row">
					
						<div class="col-lg-4">	
							<div class="alert alert-success">
								Subir registros a la tabla <strong>Holguras</strong>.
								<br><br>
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/subir_archivo/cargar_holguras'; ?> ">
Subir Holguras <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
						
							</div>
						</div>

						<div class="col-lg-4">	
							<div class="alert alert-success">
								Subir relación <strong>Sitio - Sesión</strong>.
								<br><br>
<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/subir_archivo/cargar_sitio_sesion'; ?> ">
Subir Sitio - Sesión <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
						
							</div>
						</div>

						
					</div>
					
					
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	
	
	
	
	
</div>
<!-- /.row -->
