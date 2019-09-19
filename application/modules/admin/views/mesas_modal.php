<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/mesa.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Mesas
	<br><small>Adicionar/Editar Mesas</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdPuesto" name="hddIdPuesto" value="<?php echo $idPuesto; ?>"/>
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_mesa"]:""; ?>"/>	
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Número de mesa : *</label>
					<input type="text" id="mesa" name="mesa" class="form-control" value="<?php echo $information?$information[0]["numero_mesa"]:""; ?>" placeholder="Número de mesa" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					p<label for="type" class="control-label">Número personas habilitadas : *</label>
					<input type="text" id="habilitadas" name="habilitadas" class="form-control" value="<?php echo $information?$information[0]["personas_habilitadas"]:""; ?>" placeholder="Número personas habilitadas" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="perfil">Tipo de voto</label>
					<select name="tipo_voto" id="tipo_voto" class="form-control" required>
						<option value="">Select...</option>
						<option value=1 <?php if($information[0]["tipo_voto"] == 1) { echo "selected"; }  ?>>Solo Presidente</option>
						<option value=2 <?php if($information[0]["tipo_voto"] == 2) { echo "selected"; }  ?>>Presidente y Diputado Uninominales</option>
						<option value=3 <?php if($information[0]["tipo_voto"] == 3) { echo "selected"; }  ?>>Presidente, Diputado Uninominales y Especiales</option>
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