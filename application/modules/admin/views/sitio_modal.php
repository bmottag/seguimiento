<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sitio.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/ajaxMcpio.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Sitio
	<br><small>Adicionar/Editar Sitios</small>
	</h4>
</div>

<div class="modal-body">

	<p class="text-danger text-left">Los campos con * son obligatorios.</p>

	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_sitio"]:""; ?>"/>	
		<!-- Se usa para saber desde donde se esta editando -->
		<input type="hidden" id="enlace_regreso" name="enlace_regreso" value="<?php echo $enlace_regreso; ?>"/>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Nombre Sitio : *</label>
					<input type="text" id="nombreSitio" name="nombreSitio" class="form-control" value="<?php echo $information?$information[0]["nombre_sitio"]:""; ?>" placeholder="Nombre Sitio" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Barrio Sitio : *</label>
					<input type="text" id="barrioSitio" name="barrioSitio" class="form-control" value="<?php echo $information?$information[0]["barrio_sitio"]:""; ?>" placeholder="Barrio Sitio" required >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Dirección Sitio : *</label>
					<input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $information?$information[0]["direccion_sitio"]:""; ?>" placeholder="Dirección Sitio" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Código Postal : </label>
					<input type="text" id="codigoPostal" name="codigoPostal" class="form-control" value="<?php echo $information?$information[0]["codigo_postal_sitio"]:""; ?>" placeholder="Código Postal" >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Teléfono Sitio : *</label>
					<input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $information?$information[0]["telefono_sitio"]:""; ?>" placeholder="Teléfono Sitio" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Fax : </label>
					<input type="text" id="fax" name="fax" class="form-control" value="<?php echo $information?$information[0]["fax_sitio"]:""; ?>" placeholder="Fax Sitio" >
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Celular : *</label>
					<input type="text" id="celular" name="celular" class="form-control" value="<?php echo $information?$information[0]["celular_sitio"]:""; ?>" placeholder="Celular Sitio" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Email : *</label>
					<input type="text" id="email" name="email" class="form-control" value="<?php echo $information?$information[0]["email_sitio"]:""; ?>" placeholder="Email" required >
				</div>
			</div>
		</div>
			
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Organización : </label>
					<select name="organizacion" id="organizacion" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($organizaciones); $i++) { ?>
							<option value="<?php echo $organizaciones[$i]["id_organizacion"]; ?>" <?php if($information[0]["fk_id_organizacion"] == $organizaciones[$i]["id_organizacion"]) { echo "selected"; }  ?>><?php echo $organizaciones[$i]["nombre_organizacion"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Nodo o Región : *</label>
					<select name="region" id="region" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($regiones); $i++) { ?>
							<option value="<?php echo $regiones[$i]["id_region"]; ?>" <?php if($information[0]["fk_id_region"] == $regiones[$i]["id_region"]) { echo "selected"; }  ?>><?php echo $regiones[$i]["nombre_region"]; ?></option>	
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
			
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Departamento : *</label>
					<select name="depto" id="depto" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($departamentos); $i++) { ?>
							<option value="<?php echo $departamentos[$i]["dpto_divipola"]; ?>" <?php if($information[0]["fk_dpto_divipola"] == $departamentos[$i]["dpto_divipola"]) { echo "selected"; }  ?>><?php echo $departamentos[$i]["dpto_divipola_nombre"]; ?></option>	
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
							<option value="<?php echo $information[0]["fk_mpio_divipola"]; ?>" selected><?php echo $information[0]["mpio_divipola_nombre"]; ?></option>
						<?php } ?>
					</select>
				
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Zona : </label>
					<select name="zona" id="zona" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($zonas); $i++) { ?>
							<option value="<?php echo $zonas[$i]["id_zona"]; ?>" <?php if($information[0]["fk_id_zona"] == $zonas[$i]["id_zona"]) { echo "selected"; }  ?>><?php echo $zonas[$i]["nombre_zona"]; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6">	
				<div class="form-group text-left">
					<label class="control-label" for="estado">Estado : *</label>
					<select name="estado" id="estado" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["estado_sitio"] == 1) { echo "selected"; }  ?>>Activo</option>
						<option value=2 <?php if($information[0]["estado_sitio"] == 2) { echo "selected"; }  ?>>Inactivo</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label for="type" class="control-label">Código DANE : *</label>
					<input type="text" id="codigoDane" name="codigoDane" class="form-control" value="<?php echo $information?$information[0]["codigo_dane"]:""; ?>" placeholder="Código DANE" required >
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