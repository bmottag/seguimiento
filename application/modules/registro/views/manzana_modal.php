<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/manzana.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/ajaxManzana.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Manzana
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_manzana"]:""; ?>"/>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Comuna : *</label>
					<select name="comuna" id="comuna" class="form-control" required>
						<option value=''>Select...</option>
						<option value="02" <?php if($information[0]["fk_id_comuna"] == "02") { echo "selected"; }  ?>>Comuna 2</option>
						<option value="03" <?php if($information[0]["fk_id_comuna"] == "03") { echo "selected"; }  ?>>Comuna 3</option>
						<option value="04" <?php if($information[0]["fk_id_comuna"] == "04") { echo "selected"; }  ?>>Comuna 4</option>
						<option value="05" <?php if($information[0]["fk_id_comuna"] == "05") { echo "selected"; }  ?>>Comuna 5</option>
						<option value="08" <?php if($information[0]["fk_id_comuna"] == "08") { echo "selected"; }  ?>>Comuna 8</option>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Sector : *</label>

					<select name="sector" id="sector" class="form-control" required>					
						<?php if($information){ ?>
						<option value=''>Select...</option>
							<option value="<?php echo $information[0]["fk_id_sector"]; ?>" selected><?php echo $information[0]["fk_id_sector"]; ?></option>
						<?php } ?>
					</select>
				
				</div>
			</div>			
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Sección : *</label>
					<select name="seccion" id="seccion" class="form-control" >
						<?php if($information){ ?>
						<option value=''>Select...</option>
							<option value="<?php echo $information[0]["fk_id_seccion"]; ?>" selected><?php echo $information[0]["fk_id_seccion"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Manzana : *</label>
					<select name="manzana" id="manzana" class="form-control" >
						<?php if($information){ ?>
						<option value=''>Select...</option>
							<option value="<?php echo $information[0]["fk_id_manzana"]; ?>" selected><?php echo $information[0]["fk_id_manzana"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
						<label for="type" class="control-label">Barrio : *</label>
						<input type="text" id="barrio" name="barrio" class="form-control" value="<?php echo $information?$information[0]["barrio"]:""; ?>" placeholder="Barrio" required >
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