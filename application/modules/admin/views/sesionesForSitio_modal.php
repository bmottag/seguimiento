<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sitio_sesion.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Asociar Sitio con Prueba / Grupo de Instrumento / Sesión
	<br><small>Adicionar/Editar</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdSitio" name="hddIdSitio" value="<?php echo $idSitio; ?>"/>
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_sitio_sesion"]:""; ?>"/>
		<input type="hidden" id="hddIdSesion" name="hddIdSesion" value="<?php echo $information?$information[0]["fk_id_sesion"]:""; ?>"/>
		
		<div class="form-group text-left">
			<label for="type" class="control-label">Prueba / Grupo de Instrumento / Sesión : *</label>
			<?php if($infoSesiones){ ?>
				<select name="sesion" id="sesion" class="form-control" >
					<option value=''>Select...</option>
					<?php for ($i = 0; $i < count($infoSesiones); $i++) { ?>
						<option value="<?php echo $infoSesiones[$i]["id_sesion"]; ?>" <?php if($information[0]["fk_id_sesion"] == $infoSesiones[$i]["id_sesion"]) { echo "selected"; }  ?>><?php echo $infoSesiones[$i]["nombre_prueba"] . "/" . $infoSesiones[$i]["nombre_grupo_instrumentos"] . "/" . $infoSesiones[$i]["sesion_prueba"]; ?></option>	
					<?php } ?>
				</select>
			<?php }else{ ?>
				
				<select name="sesion" id="sesion" class="form-control" >
					<option value=''>Select...</option>
				</select>
				<p class="text-danger text-left">No hay sesiones para mostrar.</p>
			<?php } ?>
		</div>

		<div class="form-group text-left">
			<label for="type" class="control-label">Citados : *</label>
			<input type="text" id="citados" name="citados" class="form-control" value="<?php echo $information?$information[0]["numero_citados"]:""; ?>" placeholder="Citados" required >
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
				<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span>Ya se encuentra relacionado el SITIO con esa SESIÓN.</div>
			</div>	
		</div>
			
	</form>
</div>