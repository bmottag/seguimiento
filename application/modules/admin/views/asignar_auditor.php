<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/asignar_delegado.js"); ?>"></script>

<div id="page-wrapper">

	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - ASIGNAR AUDITOR
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-building"></i> Información Puesto de Votación - Mesa
				</div>
				<div class="panel-body">
									
					<div class="row">
						<div class="col-lg-4">				
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-info">
										<strong>No. puesto de votación: </strong>
										<?php echo $infoPuesto[0]['numero_puesto_votacion']; ?>
										<br><strong>Puesto de votación: </strong><br>
										<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
										<br><strong>Circunscripción: </strong>
										<?php echo $infoPuesto[0]['circunscripcion']; ?>
									</div>
								</div>
							</div>	
						</div>
						
						<div class="col-lg-4">				
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-info">
										<strong>Departamento: </strong>
										<?php echo $infoPuesto[0]['nombre_departamento']; ?>
										
										<br><strong>Municipio: </strong>
										<?php echo $infoPuesto[0]['nombre_municipio']; ?>
										<br><strong>ID Localidad: </strong>
										<?php echo $infoPuesto[0]['id_localidad']; ?>
										<br><strong>Localidad: </strong>
										<?php echo $infoPuesto[0]['nombre_localidad']; ?>
									</div>
								</div>
							</div>	
						</div>
						
						<div class="col-lg-4">				
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-info">
										<strong>No. mesa: </strong>
										<?php echo $infoMesa[0]['numero_mesa']; ?>
										<br><strong>No. personas habilitadas para votar: </strong>
										<?php echo $infoMesa[0]['personas_habilitadas']; ?>
									</div>
								</div>
							</div>	
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url(). 'admin/mesas/' . $infoPuesto[0]["id_puesto_votacion"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-gears"></i> Asignar Auditor
				</div>
				<div class="panel-body">
				
					<p class="text-danger text-left">Los campos con * son obligatorios.</p>
					
					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("admin/guardar_auditor"); ?>" >
						<input type="hidden" id="hddIdMesa" name="hddIdMesa" value="<?php echo $infoMesa[0]["id_mesa"]; ?>"/>
						<input type="hidden" id="hddIdPuesto" name="hddIdPuesto" value="<?php echo $infoPuesto[0]["id_puesto_votacion"]; ?>"/>
						<input type="hidden" id="hddIdAuditorActual" name="hddIdAuditorActual" value="<?php echo $infoMesa[0]["fk_id_usuario_auditor"]; ?>"/>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="usuario">Usuario Auditor: *</label>
							<div class="col-sm-5">

							<?php if($usuarios){ ?>
							<select name="usuario" id="usuario" class="form-control" required>
								<option value=''>Select...</option>
								<?php for ($i = 0; $i < count($usuarios); $i++) { ?>
									<option value="<?php echo $usuarios[$i]["id_usuario"]; ?>" <?php if($infoMesa[0]["fk_id_usuario_auditor"] == $usuarios[$i]["id_usuario"]) { echo "selected"; }  ?>><?php echo  "C.C. " . $usuarios[$i]["numero_documento"] . " - " . $usuarios[$i]["nombres_usuario"] . " " . $usuarios[$i]["apellidos_usuario"]; ?></option>
								<?php } ?>
							</select>
							
							<?php }else{ 
									echo "No hay AUDITORES."; 
							} ?>
							
							
							</div>
						</div>
<?php if($usuarios){ ?>												
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								 <button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'>Guardar </button>
							</div>
						</div>
<?php } ?>
					</form>

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