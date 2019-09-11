<div id="page-wrapper">

	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<i class="fa fa-gears"></i> CAPÍTULOS DEL FORMULARIO<br><br>
					<a class="btn btn-warning" href=" <?php echo base_url().'encuesta/establecimiento/' . $information[0]['fk_id_manzana']; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Lista de Establecimientos </a> 
					<a class="btn btn-warning" href=" <?php echo base_url().'encuesta/manzana/'; ?> "> Lista de Manzanas <span class="glyphicon glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a> 
					
				</div>
				<div class="panel-body">
				
					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-warning">
										<strong>No. Formulario: </strong>
										<?php echo $information[0]['id_establecimiento']; ?>
										<br><strong>Nombre comercial: </strong>
										<?php echo $information[0]['nombre_propietario']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>
				
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

<?php 
	$boton_form1 = "btn-warning";
	$boton_form2 = "btn-warning";
	$boton_form3 = "btn-warning";
	$boton_form4 = "btn-warning";
	$boton_form5 = "btn-warning";
	$boton_form6 = "btn-warning";
	$boton_form7 = "btn-info";
	if($information_form1){
			$boton_form1 = "btn-success";
	}
	if($information_form2){
			$boton_form2 = "btn-success";
	}
	if($information_form3){
			$boton_form3 = "btn-success";
	}
	if($information_form4){
			$boton_form4 = "btn-success";
	}
	if($information_form5){
			$boton_form5 = "btn-success";
	}
	if($information_form6){
			$boton_form6 = "btn-success";
	}
	if($information_form7 && $information_form7[0]["resultado_encuesta"] == "EC"){ //si el ultimo registro de control es completa entonces colocar el boton en verde
			$boton_form7 = "btn-success";
	}	
	
?>
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_administrativos/' . $idFormulario; ?>" class="btn <?php echo $boton_form1; ?> btn-block">
<span class="glyphicon glyphicon-home" aria-hidden="true"></span> 1. Capítulo Aspectos Administrativos   
</a>
						</div>
					</div>
<br>

<!-- validaciones capitulo 6 -->
<?php
$banderaTerminar = false;
$banderaTerminar2 = false;
if($information_form1 && $information_form1['estado_actual'] == 1){
	$banderaTerminar = true;
	if($information_form1['establecimiento'] == 3 || $information_form1['establecimiento'] == 4){
		$banderaTerminar = false;
	}else{
	
		if($information_form2 && $information_form2['fk_id_seccion'] != 16 && $information_form2['fk_id_seccion'] != 17 && $information_form2['fk_id_seccion'] != 18){ //validacion formulario 2
			$banderaTerminar2 = true;
			
			if($information_form2['numero_personas']>9){
				$banderaTerminar2 = false;
			}
		}
		
	}
}

?>

<?php if($banderaTerminar){ ?>


					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_actividad_economica/' . $idFormulario; ?>" class="btn <?php echo $boton_form2; ?> btn-block">
<span class="glyphicon glyphicon-usd" aria-hidden="true"></span> 2. Capítulo Características Generales de la Actividad Económica  
</a>
						</div>
					</div>
<br>					
<?php if($banderaTerminar2){ //bandera para terminar encuesta de acuerdo a la respuesta del capitulo 2 ?>
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_criticos/' . $idFormulario; ?>" class="btn <?php echo $boton_form3; ?> btn-block">
<span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> 3. Capítulo Aspectos Críticos del Establecimiento  
</a>
						</div>
					</div>
<br>						
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_financiera/' . $idFormulario; ?>" class="btn <?php echo $boton_form4; ?> btn-block">
<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 4. Capítulo Información Financiera del Establecimiento   
</a>
						</div>
					</div>
<br>
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_servicios/' . $idFormulario; ?>" class="btn <?php echo $boton_form5; ?> btn-block">
<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> 5. Capítulo Servicios de Apoyo Empresarial  
</a>
						</div>
					</div>
					
						
						
<!-- validaciones capitulo 6 -->
<?php
$bandera = false;
if($information_form1 && $information_form1['matricula'] != 1){
	$bandera = true;
}

if($information_form1 && $information_form1['rut'] != 1){
	$bandera = true;
}

if($information_form2 && $information_form2['seguridad_social'] != 1){
	$bandera = true;
}

/*
if($information_form1 && $information_form1['tiempo'] != 1){
	$bandera = true;
}
*/
if($information_form4 && $information_form4['impuestos'] != 1){
	$bandera = true;
}
if($information_form4 && $information_form4['contabilidad'] != 1){
	$bandera = true;
}

?>

<?php if($bandera){ ?>
<br>
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_formalizacion/' . $idFormulario; ?>" class="btn <?php echo $boton_form6; ?> btn-block">
<span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 6. Capítulo Formalización Empresarial   
</a>
						</div>
					</div>

<?php } ?>
<?php } ?>
<?php } ?>
<br>

<?php 
$userRol = $this->session->rol;
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
					<div class="row">
						<div class="col-lg-12">	
<a href="<?php echo base_url(). 'encuesta/form_control/' . $idFormulario; ?>" class="btn <?php echo $boton_form7; ?> btn-block">
<span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> 7. Capítulo Resultado Encuesta
</a>
						</div>
					</div>
<?php
}
?>
					

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->

	
</div>
<!-- /.row -->
