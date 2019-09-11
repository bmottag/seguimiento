<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/control.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Resultado Encuesta
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_control"]:""; ?>"/>		
		<input type="hidden" id="hddIdFormulario" name="hddIdFormulario" value="<?php echo $idFormulario; ?>"/>

		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="resultado">Resultado encuesta : *</label>
					<select name="resultado" id="resultado" class="form-control" required>
						<option value=''>Select...</option>
						<option value="EC" <?php if($information[0]["resultado_encuesta"] == "EC") { echo "selected"; }  ?>>Encuesta completa</option>
						<option value="EI" <?php if($information[0]["resultado_encuesta"] == "EI") { echo "selected"; }  ?>>Encuesta incompleta</option>
						<option value="R" <?php if($information[0]["resultado_encuesta"] == "R") { echo "selected"; }  ?>>Rechazo</option>
						<option value="FU" <?php if($information[0]["resultado_encuesta"] == "FU") { echo "selected"; }  ?>>Fuera de universo</option>
					</select>
				</div>
			</div>
		</div>

		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observaciones">Observaciones : *</label>
					<textarea id="observaciones" name="observaciones" class="form-control" rows="3"><?php echo $information[0]["observaciones"]; ?></textarea>
				</div>
			</div>
		</div>
		
		
<script>
	$( function() {
		$( "#date" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
</script>

		<div class="row">	
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="date">Fecha : *</label>
						<input type="text" class="form-control" id="date" name="date" value="<?php echo $information[0]["fecha"]; ?>" placeholder="Fecha" required />	
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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj"></span></div>
			</div>	
		</div>
			
	</form>
</div>