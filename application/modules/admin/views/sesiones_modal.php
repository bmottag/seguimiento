<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sesiones.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Sesiones
	<br><small>Adicionar/Editar Sesiones</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdGrupo" name="hddIdGrupo" value="<?php echo $idGrupo; ?>"/>
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_sesion"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="type" class="control-label">Sesión : *</label>
					<input type="text" id="sesion" name="sesion" class="form-control" value="<?php echo $information?$information[0]["sesion_prueba"]:""; ?>" placeholder="Sesion" required >
				</div>
			</div>
		</div>
		
		<?php 
			if($information){
				$timeIni = explode(":",$information[0]["hora_inicio_prueba"]);
				$hourIni = $timeIni[0];
				$minIni = $timeIni[1];
			}
		?>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Hora Inicio : *</label>
					<select name="hourIni" id="hourIni" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $hourIni) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>
				
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Min Inicio : *</label>
					<select name="minIni" id="minIni" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) 
						{
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $minIni) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
						<?php } ?>					
					</select>
				</div>
			</div>
		</div>
		
		<?php 
			if($information){
				$timeFin = explode(":",$information[0]["hora_fin_prueba"]);
				$hourFin = $timeFin[0];
				$minFin = $timeFin[1];
			}
		?>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Hora Fin : *</label>
					<select name="hourFin" id="hourFin" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 0; $i < 24; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $hourFin) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
						<?php } ?>									
					</select>
				</div>
			</div>
				
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Min Fin : *</label>
					<select name="minFin" id="minFin" class="form-control" required>
						<?php
						for ($xxx = 0; $xxx < 60; $xxx++) 
						{
							$xxx = $xxx<10?"0".$xxx:$xxx;
						?>
							<option value='<?php echo $xxx; ?>' <?php
							if ($information && $xxx == $minFin) {
								echo 'selected="selected"';
							}
							?>><?php echo $xxx; ?></option>
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