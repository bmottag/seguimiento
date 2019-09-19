<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/puesto_votacion.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/ajaxMcpio.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Puesto de Votación
	<br><small>Adicionar/Editar Puesto de Votación</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_puesto_votacion"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Número puesto de votación : *</label>
					<input type="text" id="numeroPuesto" name="numeroPuesto" class="form-control" value="<?php echo $information?$information[0]["numero_puesto_votacion"]:""; ?>" placeholder="Número puesto de votación" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Nombre puesto de votación : *</label>
					<input type="text" id="nombrePuesto" name="nombrePuesto" class="form-control" value="<?php echo $information?$information[0]["nombre_puesto_votacion"]:""; ?>" placeholder="Nombre puesto de votación" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Departamento : *</label>
					<select name="depto" id="depto" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
							<option value="<?php echo $departamentos[$i]["codigo_departamento"]; ?>" <?php if($information[0]["fk_id_departamento"] == $departamentos[$i]["codigo_departamento"]) { echo "selected"; }  ?>><?php echo $departamentos[$i]["nombre_departamento"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Municipio : *</label>

					<select name="mcpio" id="mcpio" class="form-control" required>					
						<?php if($information){ ?>
						<option value=''>Select...</option>
							<option value="<?php echo $information[0]["codigo_municipio"]; ?>" selected><?php echo $information[0]["nombre_municipio"]; ?></option>
						<?php } ?>
					</select>
				
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">ID Localidad : *</label>
					<input type="text" id="idLocalidad" name="idLocalidad" class="form-control" value="<?php echo $information?$information[0]["id_localidad"]:""; ?>" placeholder="ID Localidad" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Localidad : *</label>
					<input type="text" id="localidad" name="localidad" class="form-control" value="<?php echo $information?$information[0]["nombre_localidad"]:""; ?>" placeholder="Localidad" required >
				</div>
			</div>
		</div>
		
		<div class="row">			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Número total de mesas : *</label>
					<input type="text" id="numeroMesas" name="numeroMesas" class="form-control" value="<?php echo $information?$information[0]["total_mesas"]:""; ?>" placeholder="Número total de mesas" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Circunscripción : *</label>
					<input type="text" id="circunscripcion" name="circunscripcion" class="form-control" value="<?php echo $information?$information[0]["circunscripcion"]:""; ?>" placeholder="Circunscripción" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Latitud : </label>
					<input type="text" id="latitud" name="latitud" class="form-control" value="<?php echo $information?$information[0]["latitud"]:""; ?>" placeholder="Latitud" >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Longitud : </label>
					<input type="text" id="longitud" name="longitud" class="form-control" value="<?php echo $information?$information[0]["longitud"]:""; ?>" placeholder="Longitud" >
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row" align="center">
				<div style="width:50%;" align="center">
					<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
						Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
					</button>
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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
			</div>	
		</div>
			
	</form>
</div>