<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/form_servicios.js"); ?>"></script>

<script>
$(document).ready(function () {
	
    $('#motivo').change(function () {
        $('#motivo option:selected').each(function () {
            var motivo = $('#motivo').val();
            if (motivo == 8) {
				$("#div_cual").css("display", "inline");
				$('#cual_motivo').val("");
            } else {
				$("#div_cual").css("display", "none");
				$('#cual_motivo').val("");
            }
        });
    });
	
    $("#otro").on("click", function() {
        var condiciones = $("#otro").is(":checked");
        if (condiciones) {
            $("#div_cual2").css("display", "inline");
			$('#cual_fortalecer').val("");
        } else {
			$("#div_cual2").css("display", "none");
			$('#cual_fortalecer').val("");
        }
    });
    
});


function valid_fortalecer() 
{   
	if(document.getElementById('productos').checked || document.getElementById('procesos').checked || document.getElementById('capacitacion').checked || document.getElementById('mercadeo').checked || document.getElementById('nuevos').checked || document.getElementById('informaticos').checked || document.getElementById('innovacion').checked || document.getElementById('tramites').checked || document.getElementById('participacion').checked || document.getElementById('financiamiento').checked || document.getElementById('proyectos').checked || document.getElementById('otro').checked){
		document.getElementById('hddFortalecer').value = 1;
	}else{
		document.getElementById('hddFortalecer').value = "";
	}
}
</script>

<div id="page-wrapper">
	<br>

<form  name="form" id="form" class="form-horizontal" method="post"  >
	<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $idFormulario; ?>"/>
	<input type="hidden" id="hddIdFormServicios" name="hddIdFormServicios" value="<?php echo $idFormServicios; ?>"/>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<a class="btn btn-info" href=" <?php echo base_url().'encuesta/form_home/' . $idFormulario; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar menú encuesta </a> 
					<i class="fa fa-inbox"></i> 5. Capítulo Servicios de Apoyo Empresarial							
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
							<label class="col-sm-4 control-label" for="motivo">Pensando en su experiencia personal, cual fue el principal motivó a crear esta empresa? *</label>
							<div class="col-sm-8">
								<select name="motivo" id="motivo" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information["motivo"] == 1) { echo "selected"; }  ?>>Necesidad económica</option>
									<option value=2 <?php if($information["motivo"] == 2) { echo "selected"; }  ?>>Continuar con el negocio familiar</option>
									<option value=3 <?php if($information["motivo"] == 3) { echo "selected"; }  ?>>Desempleo (no tenía nada más que hacer)</option>
									<option value=4 <?php if($information["motivo"] == 4) { echo "selected"; }  ?>>Tener nuevos ingresos</option>
									<option value=5 <?php if($information["motivo"] == 5) { echo "selected"; }  ?>>Por inversión</option>
									<option value=6 <?php if($information["motivo"] == 6) { echo "selected"; }  ?>>Deseo de aplicar conocimientos</option>
									<option value=7 <?php if($information["motivo"] == 7) { echo "selected"; }  ?>>Tenía experiencia</option>
									<option value=8 <?php if($information["motivo"] == 8) { echo "selected"; }  ?>>Otra</option>
								</select>
							</div>
						</div>
						
<?php 
	$mostrar = "none";
	if($information && $information["motivo"]==8){
		$mostrar = "inline";
	}
?>
						
						<div class="form-group" id="div_cual" style="display: <?php echo $mostrar; ?>">
							<label class="col-sm-4 control-label" for="cual_motivo">¿Cuál? </label>
							<div class="col-sm-8">
								<input type="text" id="cual_motivo" name="cual_motivo" class="form-control" value="<?php echo $information?$information["cual_motivo"]:""; ?>" placeholder="¿Cuál?" >
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label" for="fortalecer">¿Cuáles de los siguientes servicios de apoyo empresarial considera necesarios para fortalecer su actividad? *</label>
							<div class="col-sm-8">
<input type="checkbox" id="productos" name="productos" value=1 <?php if($information && $information["productos"]){echo "checked";} ?> onclick="valid_fortalecer()"> Capacitación en mejora de productos<br>
<input type="checkbox" id="procesos" name="procesos" value=1 <?php if($information && $information["procesos"]){echo "checked";} ?> onclick="valid_fortalecer()"> Capacitación en mejora de procesos<br>
<input type="checkbox" id="capacitacion" name="capacitacion" value=1 <?php if($information && $information["capacitacion"]){echo "checked";} ?> onclick="valid_fortalecer()"> Capacitación y actualización del recurso humano<br>
<input type="checkbox" id="mercadeo" name="mercadeo" value=1 <?php if($information && $information["mercadeo"]){echo "checked";} ?> onclick="valid_fortalecer()"> Asesoría en mercadeo y comercialización<br>
<input type="checkbox" id="nuevos" name="nuevos" value=1 <?php if($information && $information["nuevos"]){echo "checked";} ?> onclick="valid_fortalecer()"> Asesoría en productos nuevos<br>
<input type="checkbox" id="informaticos" name="informaticos" value=1 <?php if($information && $information["informaticos"]){echo "checked";} ?> onclick="valid_fortalecer()"> Asesoría en el manejo de nuevos productos informáticos<br>
<input type="checkbox" id="innovacion" name="innovacion" value=1 <?php if($information && $information["innovacion"]){echo "checked";} ?> onclick="valid_fortalecer()"> Asesoría en innovación empresarial<br>
<input type="checkbox" id="tramites" name="tramites" value=1 <?php if($information && $information["tramites"]){echo "checked";} ?> onclick="valid_fortalecer()"> Asesoría en trámites (ej.: comercio exterior, patentes, inversión extranjera)<br>
<input type="checkbox" id="participacion" name="participacion" value=1 <?php if($information && $information["participacion"]){echo "checked";} ?> onclick="valid_fortalecer()"> Participación en ferias, ruedas de negocios y eventos nacionales e internacionales<br>
<input type="checkbox" id="financiamiento" name="financiamiento" value=1 <?php if($information && $information["financiamiento"]){echo "checked";} ?> onclick="valid_fortalecer()"> Información sobre acceso a financiamiento<br>
<input type="checkbox" id="proyectos" name="proyectos" value=1 <?php if($information && $information["proyectos"]){echo "checked";} ?> onclick="valid_fortalecer()"> Gerencia y capacitación para la formulación e implementación de proyectos empresariales<br>
<input type="checkbox" id="otro" name="otro" value=1 <?php if($information && $information["otro"]){echo "checked";} ?> onclick="valid_fortalecer()"> Otro



<?php 
$valorFortalecer = "";
if($information)
{
	if($information["productos"] || $information["procesos"] || $information["capacitacion"] || $information["mercadeo"] || $information["nuevos"] || $information["informaticos"] || $information["innovacion"] || $information["tramites"] || 	$information["participacion"] || $information["financiamiento"] || $information["proyectos"] || $information["otro"])
	{
		$valorFortalecer = 1;
	}
}
?>
<input type="hidden" id="hddFortalecer" name="hddFortalecer" value="<?php echo $valorFortalecer; ?>"/>

							</div>
						</div>
						
<?php 
	$mostrar2 = "none";
	if($information && $information["otro"]==1){
		$mostrar2 = "inline";
	}
?>
						
						<div class="form-group" id="div_cual2" style="display: <?php echo $mostrar2; ?>">
							<label class="col-sm-4 control-label" for="cual_fortalecer">¿Cuál? </label>
							<div class="col-sm-8">
								<input type="text" id="cual_fortalecer" name="cual_fortalecer" class="form-control" value="<?php echo $information?$information["cual_fortalecer"]:""; ?>" placeholder="¿Cuál?" >
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