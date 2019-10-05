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
			<div class="panel panel-danger">
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
								<strong>Atención:</strong> <br>Al aceptar borrará toda la información de Registro de Alertas, 
								Registro de Votos, Sumatoria de votos y Estados de mesas.
								
								<br><br>
								<button type="button" class="btn btn-danger btn-xs" >
									Aceptar <span class="fa fa-times fa-fw" aria-hidden="true">
								</button>						
							</div>
						</div>

						<div class="col-lg-4">	
							<div class="alert alert-warning">
								<strong>Borrar usuarios:</strong> <br>Al aceptar borrará los Auditores y Operadores.
								
								<br><br>
								<button type="button" class="btn btn-warning btn-xs" >
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

</div>
<!-- /.row -->
