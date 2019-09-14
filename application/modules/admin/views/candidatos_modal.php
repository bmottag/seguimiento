<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/candidato.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Formulario de Candidato
	<br><small>Adicionar/Editar Candidato</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_candidato"]:""; ?>"/>
		<input type="hidden" id="cargo" name="cargo" value=<?php echo $cargo; ?> />
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="firstName">Nombre completo : *</label>
					<input type="text" id="name" name="name" class="form-control" value="<?php echo $information?$information[0]["nombre_completo_candidato"]:""; ?>" placeholder="Nombre completo" required >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="lastName">Sigla : *</label>
					<input type="text" id="sigla" name="sigla" class="form-control" value="<?php echo $information?$information[0]["sigla"]:""; ?>" placeholder="Sigla" required >
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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">Este número de documetno ya existe en la base de datos.</span></div>
			</div>	
		</div>
			
	</form>
</div>