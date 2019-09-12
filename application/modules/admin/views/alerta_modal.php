<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/alerta.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Alerta
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_alerta"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="descripcion">Descripción : *</label>
					<textarea id="descripcion" name="descripcion" class="form-control" rows="1"><?php echo $information?$information[0]["descripcion_alerta"]:""; ?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Tipo de Alerta : *</label>
					<select name="tipoAlerta" id="tipoAlerta" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($tipoAlerta); $i++) { ?>
							<option value="<?php echo $tipoAlerta[$i]["id_tipo_alerta"]; ?>" <?php if($information[0]["fk_id_tipo_alerta"] == $tipoAlerta[$i]["id_tipo_alerta"]) { echo "selected"; }  ?>><?php echo $tipoAlerta[$i]["nombre_tipo_alerta"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="estado">Activar / Desactivar Alarma</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["estado_alerta"] == 1) { echo "selected"; }  ?>>Activar</option>
						<option value=2 <?php if($information[0]["estado_alerta"] == 2) { echo "selected"; }  ?>>Desactivar</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="mensaje">Mensaje : *</label>
					<textarea id="mensaje" name="mensaje" class="form-control" rows="1"><?php echo $information?$information[0]["mensaje_alerta"]:""; ?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="type" class="control-label">Tipo de Mensaje : *</label>
					<select name="tipoMensaje" id="tipoMensaje" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["tipo_mensaje"] == 1) { echo "selected"; }  ?>>Notificar por APP</option>
						<option value=3 <?php if($information[0]["tipo_mensaje"] == 3) { echo "selected"; }  ?>>Notificar por EMAIL</option>
						<option value=2 <?php if($information[0]["tipo_mensaje"] == 2) { echo "selected"; }  ?>>Notificar por EMAIL y APP</option>
					</select>
				</div>
			</div>

		</div>		

		<?php 
			if($information){
				$time = explode(":",$information[0]["hora_alerta"]);
				$hour = $time[0];
				$min = $time[1];
			}
		?>
		<div class="row">	
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Hora Inicio: *</label>
					<select name="hour" id="hour" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {
							
							$i = $i<10?"0".$i:$i;
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $hour) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>
				
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Min. Inicio : *</label>
					<select name="min" id="min" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) {
							
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $min) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">	
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Duración (en minutos): *</label>
					<select name="duracion" id="duracion" class="form-control" required>	
						<?php
						for ($xxx = 1; $xxx < 61; $xxx++) {
							
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
						<?php } ?>
						<option value='120' <?php
							if ($information && '120' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>2 horas</option>
							
						<option value='180' <?php
							if ($information && '180' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>3 horas</option>
							
						<option value='240' <?php
							if ($information && '240' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>4 horas</option>
							
						<option value='300' <?php
							if ($information && '300' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>5 horas</option>
							
						<option value='360' <?php
							if ($information && '360' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>6 horas</option>
							
						<option value='420' <?php
							if ($information && '420' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>7 horas</option>
							
						<option value='480' <?php
							if ($information && '480' == $information[0]["tiempo_duracion_alerta"]) {
								echo 'selected="selected"';
							}
							?>>8 horas</option>
							
							
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Rol : *</label>
					<select name="rol" id="rol" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($roles); $i++) { ?>
							<option value="<?php echo $roles[$i]["id_rol"]; ?>" <?php if($information[0]["fk_id_rol"] == $roles[$i]["id_rol"]) { echo "selected"; }  ?>><?php echo $roles[$i]["nombre_rol"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="type" class="control-label">Prueba / Grupo de Instrumentos / Fecha / Sesión : *</label>
					<select name="sesion" id="sesion" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($infoPruebas); $i++) { ?>
							<option value="<?php echo $infoPruebas[$i]["id_sesion"]; ?>" <?php if($information[0]["fk_id_sesion"] == $infoPruebas[$i]["id_sesion"]) { echo "selected"; }  ?>><?php echo $infoPruebas[$i]["nombre_prueba"] . " / " . $infoPruebas[$i]["nombre_grupo_instrumentos"] . " / " . $infoPruebas[$i]["fecha"] . " / " . $infoPruebas[$i]["sesion_prueba"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>


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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
			</div>	
		</div>
			
	</form>
</div>