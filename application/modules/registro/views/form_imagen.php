<div id="page-wrapper">
	<br>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info btn-xs" href=" <?php echo base_url().'registro/presidente/' . $infoMesa[0]['id_mesa']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-photo"></i> <strong>Foto acta escrutinio</strong>
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
										<strong>Auditor: </strong><br>
										<?php 
											echo $this->session->userdata("firstname"); 
											echo " "; 
											echo $this->session->userdata("lastname"); 
										?>
										<br><strong>No. mesa: </strong>
										<?php echo $infoMesa[0]['numero_mesa']; ?>

									</div>
								</div>
							</div>	
						</div>
					</div>

									
				</div>
					
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Foto acta escrutinio</strong>
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

		<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("registro/do_upload_foto"); ?>">
		<input type="hidden" id="hddIdMesa" name="hddIdMesa" value="<?php echo $infoMesa[0]['id_mesa']; ?>"/>
		
		<div class="col-lg-6">					
				<div class="col-lg-12">				
					<div class="form-group">					
						<label class="col-sm-4 control-label" for="hddTask">Foto: *</label>
						<div class="col-sm-5">
							 <input type="file" name="userfile" capture="camera" accept="image/*">
						</div>
					</div>
				</div>
					
				<div class="col-lg-12">				
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								<button type="submit" id="btnSubmit" name="btnSubmit" class='btn btn-primary'>
									Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
								</button>
							</div>
						</div>
					</div>
				</div>
		</div>
		</form>
		
		<div class="col-lg-6">	

					<?php if($error){ ?>
					<div class="col-lg-12">
						<div class="alert alert-danger">
						<?php 
							echo "<strong>Error :</strong>";
							pr($error); 
						?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
						</div>
					</div>
					<?php } ?>
					
				<div class="col-lg-12">
					<div class="alert alert-danger">
							<strong>Nota :</strong><br>
							Formato permitido: gif - jpg - png<br>
							Peso máximo: 3000 KB<br>
							Ancho máximo: 3200 pixeles<br>
							Altura máxima: 2400 pixeles
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
	
</div>
<!-- /#page-wrapper -->