<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/form_actividad_economica.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/ajaxActividad.js"); ?>"></script>

<script>
$(document).ready(function () {
	
	//validacion para terminar formulario
    $('#actividad').change(function () {
        $('#actividad option:selected').each(function () {
            var actividad = $('#actividad').val();
            if (actividad != 16 && actividad != 17 && actividad != 18) {
				$("#div_terminar").css("display", "inline");
				$('#division').val("");
				$('#descripcion').val("");
				$('#numero_personas').val("");
				$('#seguridad_social').val("");
				$('#lugar').val("");
            } else {
				$("#div_terminar").css("display", "none");
				$('#division').val("");
				$('#descripcion').val("");
				$('#numero_personas').val("");
				$('#seguridad_social').val("");
				$('#lugar').val("");
            }
        });
    });
	
	//validacion para terminar formulario
    $('#numero_personas').blur(function () {
            var numero_personas = $('#numero_personas').val();
            if (numero_personas <= 9) {
				$("#div_terminar2").css("display", "inline");
            } else {
				$("#div_terminar2").css("display", "none");
				$('#seguridad_social').val("");
				$('#lugar').val("");
            }
    });
	
    
});
</script>

<div id="page-wrapper">
	<br>
<!-- validaciones capitulo 6 -->
<?php
$bandera = false;
if($information_form1 && $information_form1['estado_actual'] == 1){
	$bandera = true;
	if($information_form1['establecimiento'] == 3 || $information_form1['establecimiento'] == 4){
		$bandera = false;
	}
}
?>

<?php if(!$bandera){ ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			Usted termino la encuesta gracias por su tiempo.
<br><br>
<a class="btn btn-success" href=" <?php echo base_url().'encuesta/establecimiento/' . $information_establecimiento[0]['fk_id_manzana']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar a lista de establecimientos </a> 
<a class="btn btn-success" href=" <?php echo base_url().'encuesta/manzana/'; ?> "> Regresar a lista de manzanas <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
		</div>
	</div>
<?php }else{ ?>

<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $idFormulario; ?>"/>
	<input type="hidden" id="hddIdFormActividadEconomica" name="hddIdFormActividadEconomica" value="<?php echo $idFormActividadEconomica; ?>"/>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info" href=" <?php echo base_url().'encuesta/form_home/' . $idFormulario; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar menú encuesta </a> 
					<i class="fa fa-usd"></i> 2. Capítulo Características Generales de la Actividad Económica						
				</div>
				<div class="panel-body">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 
<p class="text-danger text-left">Los campos con * son obligatorios.</p>								
								
						<div class="form-group">
							<label class="col-sm-4 control-label" for="actividad">¿Cuál es su actividad económica principal o que se dedica su establecimiento? (Esperar respuesta)*</label>
							<div class="col-sm-8">
							
								<select name="actividad" id="actividad" class="form-control" required>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($lista_actividad_economica); $i++) { ?>
<option value="<?php echo $lista_actividad_economica[$i]["id_seccion"]; ?>" <?php if($information["fk_id_seccion"] == $lista_actividad_economica[$i]["id_seccion"]) { echo "selected"; }  ?>><?php echo $lista_actividad_economica[$i]["descripcion_seccion_app"]; ?></option>	
									<?php } ?>
								</select>								
							</div>
						</div>

<?php 
//los siguientes campos quedan ocultos si en la pregunta anterior se selecciona la respuesta 16 y 17
	$mostrarTerminar = "none";
	$mostrarTerminar2 = "none";
	if($information && $information["fk_id_seccion"]!=16 && $information["fk_id_seccion"]!=17 && $information["fk_id_seccion"]!=18){
		$mostrarTerminar = "inline";
		
		if($information["numero_personas"]<=9){
			$mostrarTerminar2 = "inline";
		}
		
	}
?>
			<div id="div_terminar" style="display: <?php echo $mostrarTerminar; ?>">

						<div class="form-group">
							<label class="col-sm-4 control-label" for="actividad">¿Detalle cuál es su actividad económica principal o que se dedica su establecimiento?*</label>
							<div class="col-sm-8">
							<select name="division" id="division" class="form-control" >					
								<?php if($information){ ?>
								<option value=''>Select...</option>
									<option value="<?php echo $information["division"]; ?>" selected><?php echo $information["descripcion_division_app"]; ?></option>
								<?php } ?>					
							</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="descripcion">Describa la actividad económica principal o la que se dedica el establecimiento *</label>					
							<div class="col-sm-8">
								<textarea id="descripcion" name="descripcion" class="form-control" rows="3" ><?php echo $information["descripcion"]; ?></textarea>
							</div>
						</div>

						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="numero_personas">¿Cuántas personas; incluido(a) usted, trabajan actualmente en el establecimiento? *</label>					
							<div class="col-sm-8">
								<input type="text" id="numero_personas" name="numero_personas" class="form-control" value="<?php echo $information?$information["numero_personas"]:""; ?>" placeholder="Número de personas" >
							</div>
						</div>
					
					
				<div id="div_terminar2" style="display: <?php echo $mostrarTerminar2; ?>">
						<div class="form-group">
							<label class="col-sm-4 control-label" for="seguridad_social">¿Cuantos de los trabajadores de este establecimiento; incluido(a) usted,  se encuentran afiliados a seguridad social? *</label>
							<div class="col-sm-8">
								<select name="seguridad_social" id="seguridad_social" class="form-control">
									<option value=''>Select...</option>
									<option value=1 <?php if($information["seguridad_social"] == 1) { echo "selected"; }  ?>>Todos</option>
									<option value=2 <?php if($information["seguridad_social"] == 2) { echo "selected"; }  ?>>Algunos</option>
									<option value=3 <?php if($information["seguridad_social"] == 3) { echo "selected"; }  ?>>Ninguno</option>
								</select>
							</div>
						</div>																	

						<div class="form-group">
							<label class="col-sm-4 control-label" for="lugar">El lugar donde funciona este establecimiento es:  *</label>
							<div class="col-sm-8">
								<select name="lugar" id="lugar" class="form-control">
									<option value=''>Select...</option>
									<option value=1 <?php if($information["lugar"] == 1) { echo "selected"; }  ?>>Propio</option>
									<option value=2 <?php if($information["lugar"] == 2) { echo "selected"; }  ?>>Arrendado</option>
									<option value=3 <?php if($information["lugar"] == 3) { echo "selected"; }  ?>>Usufructo</option>
								</select>
							</div>
						</div>

					</div>
			</div>


				</div>
			</div>
		</div>
	</div>								
								
				
								
<?php 
$userRol = $this->session->rol;
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:100%;" align="center">
									<input type="button" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
								</div>
							</div>
						</div>
<?php
}
?>
								

								
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:80%;" align="center">
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
							</div>
						</div>								

	
</form>
<?php } ?>
</div>
<!-- /#page-wrapper -->