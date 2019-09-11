<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/form_administrativa.js"); ?>"></script>

<script>
$(document).ready(function () {
	
    $('#matricula').change(function () {
        $('#matricula option:selected').each(function () {
            var matricula = $('#matricula').val();
            if (matricula == 1) {
				$("#div_porqueno").css("display", "none");
				$("#div_cual").css("display", "none");
				$('#porqueno').val("");
				$('#cual').val("");
            } else {
				$("#div_porqueno").css("display", "inline");
				$("#div_cual").css("display", "none");
				$('#porqueno').val("");
				$('#cual').val("");
            }
        });
    });
	
    $('#porqueno').change(function () {
        $('#porqueno option:selected').each(function () {
            var porqueno = $('#porqueno').val();
            if (porqueno == 6) {
				$("#div_cual").css("display", "inline");
				$('#cual').val("");
            } else {
				$("#div_cual").css("display", "none");
				$('#cual').val("");
            }
        });
    });
	
	//validacion para terminar formulario
    $('#estado_actual').change(function () {
        $('#estado_actual option:selected').each(function () {
            var estado_actual = $('#estado_actual').val();
            if (estado_actual == 1) {
				$("#div_terminar").css("display", "inline");
				$('#establecimiento').val("");
				$('#tiempo').val("");
				$('#rut').val("");
            } else {
				$("#div_terminar").css("display", "none");
				$('#establecimiento').val("");
				$('#tiempo').val("");
				$('#rut').val("");
            }
        });
    });
	
	//validacion para terminar formulario
    $('#establecimiento').change(function () {
        $('#establecimiento option:selected').each(function () {
            var establecimiento = $('#establecimiento').val();
            if (establecimiento == 1 || establecimiento == 2) {
				$("#div_terminar2").css("display", "inline");
				$('#tiempo').val("");
				$('#rut').val("");
            } else {
				$("#div_terminar2").css("display", "none");
				$('#tiempo').val("");
				$('#rut').val("");
            }
        });
    });
	
    
});
</script>

<div id="page-wrapper">
	<br>

<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $idFormulario; ?>"/>
	<input type="hidden" id="hddIdFormAdministrativa" name="hddIdFormAdministrativa" value="<?php echo $idFormAdministrativa; ?>"/>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info" href=" <?php echo base_url().'encuesta/form_home/' . $idFormulario; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar menú encuesta</a> 
					<i class="fa fa-home"></i> 1. Capítulo Aspectos administrativos
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
							<label class="col-sm-4 control-label" for="visible">¿Este establecimiento es visible al público? <br>
(Por observación): *</label>
							<div class="col-sm-5">
								<select name="visible" id="visible" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information["visible"] == 1) { echo "selected"; }  ?>>Si</option>
									<option value=2 <?php if($information["visible"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="aviso">Este establecimiento tiene aviso? <br>
(Por observación) *</label>
							<div class="col-sm-5">
								<select name="aviso" id="aviso" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information["aviso"] == 1) { echo "selected"; }  ?>>Si</option>
									<option value=2 <?php if($information["aviso"] == 2) { echo "selected"; }  ?>>No</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="matricula">¿Este establecimiento cuenta con Matricula Mercantil? *</label>
							<div class="col-sm-5">
								<select name="matricula" id="matricula" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information["matricula"] == 1) { echo "selected"; }  ?>>Si</option>
									<option value=2 <?php if($information["matricula"] == 2) { echo "selected"; }  ?>>No</option>
									<option value=3 <?php if($information["matricula"] == 3) { echo "selected"; }  ?>>NS/NR</option>
								</select>
							</div>
						</div>	

<?php 
	$mostrar2 = "none";
	if($information && $information["matricula"]!=1){
		$mostrar2 = "inline";
	}
?>						

						<div class="form-group" id="div_porqueno" style="display: <?php echo $mostrar2; ?>">
							<label class="col-sm-4 control-label" for="porqueno">¿Por qué no cuenta con Matricula Mercantil? *</label>
							<div class="col-sm-5">
								<select name="porqueno" id="porqueno" class="form-control">
									<option value=''>Select...</option>
									<option value=1 <?php if($information["porqueno"] == 1) { echo "selected"; }  ?>>No es útil</option>
									<option value=2 <?php if($information["porqueno"] == 2) { echo "selected"; }  ?>>Es muy costoso</option>
									<option value=3 <?php if($information["porqueno"] == 3) { echo "selected"; }  ?>>No tiene tiempo de sacarla</option>
									<option value=4 <?php if($information["porqueno"] == 4) { echo "selected"; }  ?>>No sabía que existía</option>
									<option value=5 <?php if($information["porqueno"] == 5) { echo "selected"; }  ?>>No sabe si debe registrarse</option>
									<option value=6 <?php if($information["porqueno"] == 6) { echo "selected"; }  ?>>Otra</option>
								</select>
							</div>
						</div>
						
<?php 
	$mostrar = "none";
	if($information && $information["porqueno"]==6){
		$mostrar = "inline";
	}
?>

						<div class="form-group" id="div_cual" style="display: <?php echo $mostrar; ?>">
							<label class="col-sm-4 control-label" for="cual">¿Cuál? </label>
							<div class="col-sm-5">
								<input type="text" id="cual" name="cual" class="form-control" value="<?php echo $information?$information["cual"]:""; ?>" placeholder="¿Cuál?" >
							</div>
						</div>						

						<div class="form-group">
							<label class="col-sm-4 control-label" for="estado_actual">¿Cuál es el estado actual del establecimiento? *</label>
							<div class="col-sm-5">
								<select name="estado_actual" id="estado_actual" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information["estado_actual"] == 1) { echo "selected"; }  ?>>Activo</option>
									<option value=2 <?php if($information["estado_actual"] == 2) { echo "selected"; }  ?>>En liquidación</option>
									<option value=3 <?php if($information["estado_actual"] == 3) { echo "selected"; }  ?>>Inactivo</option>
								</select>
							</div>
						</div>

<?php 
	$mostrarTerminar = "none";
	if($information && $information["estado_actual"]==1){
		$mostrarTerminar = "inline";
	}
?>
			<div id="div_terminar" style="display: <?php echo $mostrarTerminar; ?>">
			
						<div class="form-group">
							<label class="col-sm-4 control-label" for="establecimiento">Este establecimiento es: *</label>
							<div class="col-sm-5">
								<select name="establecimiento" id="establecimiento" class="form-control">
									<option value=''>Select...</option>
									<option value=1 <?php if($information["establecimiento"] == 1) { echo "selected"; }  ?>>Único</option>
									<option value=2 <?php if($information["establecimiento"] == 2) { echo "selected"; }  ?>>Principal</option>
									<option value=3 <?php if($information["establecimiento"] == 3) { echo "selected"; }  ?>>Sucursal</option>
									<option value=4 <?php if($information["establecimiento"] == 4) { echo "selected"; }  ?>>Agencia</option>
								</select>
							</div>
						</div>

<?php 
	$mostrarTerminar2 = "none";
	if($information && ($information["establecimiento"]==1 || $information["establecimiento"]==2)){
		$mostrarTerminar2 = "inline";
	}
?>
						
				<div id="div_terminar2" style="display: <?php echo $mostrarTerminar2; ?>">
						<div class="form-group">
							<label class="col-sm-4 control-label" for="tiempo">¿Cuánto tiempo lleva funcionando el establecimiento? (Esperar respuesta) *</label>
							<div class="col-sm-5">
								<select name="tiempo" id="tiempo" class="form-control">
									<option value=''>Select...</option>
									<option value=1 <?php if($information["tiempo"] == 1) { echo "selected"; }  ?>>Menos de 6 meses</option>
									<option value=2 <?php if($information["tiempo"] == 2) { echo "selected"; }  ?>>Entre 6 meses y  12 meses</option>
									<option value=3 <?php if($information["tiempo"] == 3) { echo "selected"; }  ?>>Entre 1 año y 3 años</option>
									<option value=4 <?php if($information["tiempo"] == 4) { echo "selected"; }  ?>>Entre 3 años y  5 años</option>
									<option value=5 <?php if($information["tiempo"] == 5) { echo "selected"; }  ?>>Entre 5 años y  10 años</option>
									<option value=6 <?php if($information["tiempo"] == 6) { echo "selected"; }  ?>>Entre 10 años y más</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="rut">¿Este establecimiento cuenta con Registro Único Tributario RUT? *</label>
							<div class="col-sm-5">
								<select name="rut" id="rut" class="form-control" >
									<option value=''>Select...</option>
									<option value=1 <?php if($information["rut"] == 1) { echo "selected"; }  ?>>Si</option>
									<option value=2 <?php if($information["rut"] == 2) { echo "selected"; }  ?>>No</option>
									<option value=3 <?php if($information["rut"] == 3) { echo "selected"; }  ?>>NS/NR</option>
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

</div>
<!-- /#page-wrapper -->