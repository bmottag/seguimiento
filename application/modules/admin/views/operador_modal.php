<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/operador.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/ajaxMcpio.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Operador
	<br><small>Adicionar/Editar Operador</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
					
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Departamento : *</label>
					<select name="depto" id="depto" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
							<option value="<?php echo $departamentos[$i]["dpto_divipola"]; ?>" <?php if($information[0]["dpto_divipola"] == $departamentos[$i]["dpto_divipola"]) { echo "selected"; }  ?>><?php echo $departamentos[$i]["dpto_divipola_nombre"]; ?></option>	
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
							<option value="<?php echo $information[0]["mpio_divipola"]; ?>" selected><?php echo $information[0]["mpio_divipola_nombre"]; ?></option>
						<?php } ?>
					</select>
				
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="type" class="control-label">Operador : </label>
					<select name="usuario" id="usuario" class="form-control" required>
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($usuarios); $i++) { ?>
							<option value="<?php echo $usuarios[$i]["id_usuario"]; ?>" <?php if($information[0]["fk_id_coordinador_mcpio"] == $usuarios[$i]["id_usuario"]) { echo "selected"; }  ?>><?php echo  "C.C. " . $usuarios[$i]["numero_documento"] . " - " . $usuarios[$i]["nombres_usuario"] . " " . $usuarios[$i]["apellidos_usuario"]; ?></option>
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