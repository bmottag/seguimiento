<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/tipo_alerta.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Tipo de Alerta 
	<br><small>Adicionar/Editar Tipo de Alertas</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_tipo_alerta"]:""; ?>"/>
		<div class="form-group text-left">
				<label for="type" class="control-label">Nombre Tipo de Alerta : *</label>
				<input type="text" id="nombreTipoAlerta" name="nombreTipoAlerta" class="form-control" value="<?php echo $information?$information[0]["nombre_tipo_alerta"]:""; ?>" placeholder="Nombre Tipo de Alerta" required >
		</div>
		
		<div class="form-group text-left">
			<label class="control-label" for="descripcion">Descripción : *</label>
			<textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?php echo $information?$information[0]["descripcion_tipo_alerta"]:""; ?></textarea>
		</div>
		
		<div class="form-group text-left">
			<label class="control-label" for="observacion">Observación : *</label>
			<textarea id="observacion" name="observacion" class="form-control" rows="3"><?php echo $information?$information[0]["observacion_alerta"]:""; ?></textarea>
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