<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/param_email.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Datos correo
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="asunto">Asunto : </label>
					<input type="text" id="asunto" name="asunto" class="form-control" value="<?php echo $information?$information[0]["valor"]:""; ?>" placeholder="Asunto" required >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="mensaje">Mensaje : *</label>
					<textarea id="mensaje" name="mensaje" class="form-control" rows="3"><?php echo $information?$information[1]["valor"]:""; ?></textarea>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="email_bloqueado">Correo bloqueado <small>(Correo general cuando los usuarios no tienen correo)</small>: </label>
					<input type="text" id="email_bloqueado" name="email_bloqueado" class="form-control" value="<?php echo $information?$information[2]["valor"]:""; ?>" placeholder="Correo bloqueado">
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