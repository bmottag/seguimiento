<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/partido.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Partido
	<br><small>Adicionar/Editar Partido</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_partido"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Nombre Partido : *</label>
					<input type="text" id="nombrePartido" name="nombrePartido" class="form-control" value="<?php echo $information?$information[0]["nombre_partido"]:""; ?>" placeholder="Nombre Partido" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Sigla : *</label>
					<input type="text" id="sigla" name="sigla" class="form-control" value="<?php echo $information?$information[0]["sigla"]:""; ?>" placeholder="Sigla" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Número orden partido : *</label>
					<select name="numeroOrden" id="numeroOrden" class="form-control" required>
						<option value='' >Select...</option>
						<?php
						for ($i = 1; $i < 15; $i++) {
							?>
							<option value='<?php echo $i; ?>' <?php
							if ($information && $i == $information[0]["numero_orden_partido"]) {
								echo 'selected="selected"';
							}
							?>><?php echo $i; ?></option>
								<?php } ?>									
					</select>
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