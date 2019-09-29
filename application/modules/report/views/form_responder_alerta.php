
<div id="page-wrapper">

	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						<i class="fa fa-gear fa-fw"></i> RESPUESTA NOTIFICACIONES
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	


	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-gears"></i> Respuesta alerta por el <?php echo ucwords($rol); ?> 
				</div>
				<div class="panel-body">
				
	<div class="alert alert-info">
		Por favor dar repuesta a la alerta que no contesto el Auditor
	</div>


		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Puesto de votación: </strong><br><?php echo $infoPuestos[0]['numero_puesto_votacion']; ?>
					<br><strong>Puesto de votación: </strong><?php echo $infoPuestos[0]['nombre_puesto_votacion']; ?>
					<br><strong>Departamento: </strong><?php echo $infoPuestos[0]['nombre_departamento']; ?>
					<br><strong>Municipio: </strong><?php echo $infoPuestos[0]['nombre_municipio']; ?>
					<br><strong>Id localidad: </strong><?php echo $infoPuestos[0]['id_localidad']; ?>
					<br><strong>Localidad: </strong><?php echo $infoPuestos[0]['nombre_localidad']; ?>
					<br><strong>Circunscripción: </strong><?php echo $infoPuestos[0]['circunscripcion']; ?>
				</div>
			</div>
		</div>
	
				
				
<?php 
if($infoAlerta['fk_id_tipo_alerta'] == 1){//informativa
	$class = "danger";
	$class2 = "danger";
}elseif($infoAlerta['fk_id_tipo_alerta'] == 2){//notificacion
	$class = "yellow";
	$class2 = "warning";
}if($infoAlerta['fk_id_tipo_alerta'] == 3){//consolidacion
	$class = "green";
	$class2 = "success";
}

?>
				
		<div class="col-lg-6">				
			<div class="panel panel-<?php echo $class; ?>">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlerta['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">
				
				
				
<?php
$retornoError = $this->session->flashdata('retornoErrorConsolidacion');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
				
				
					<div class="col-lg-12">	
						
						<div class="alert alert-<?php echo $class2; ?>">
							<strong>Mensaje Alerta: </strong><?php echo $infoAlerta['mensaje_alerta']; ?><br>
							<strong>Fecha: </strong><?php echo $infoAlerta['fecha_alerta']; ?>
					<br>
<?php 
if($infoAlerta['fk_id_tipo_alerta'] == 1){//informativa					
?>
					
<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("report/registro_informativo_by_coordinador"); ?>" >
	<input type="hidden" id="hddIdRol" name="hddIdRol" value="<?php echo $rol; ?>"/>
	<input type="hidden" id="hddIdAlerta" name="hddIdAlerta" value="<?php echo $info[0]["id_alerta"]; ?>"/>
	<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $info[0]["id_sitio_sesion"]; ?>"/>
	<input type="hidden" id="hddIdUserDelegado" name="hddIdUserDelegado" value="<?php echo $info[0]["fk_id_user_delegado"]; ?>"/>

	<div class="form-group">
		<div class="row" align="center">
			<div style="width:50%;" align="center">
				<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-<?php echo $class2; ?>"/>
			</div>
		</div>
	</div>
</form>	

<?php
}elseif($infoAlerta['fk_id_tipo_alerta'] == 2){//notificacion
?>

<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("report/registro_notificacion_by_operador"); ?>" >
	<input type="hidden" id="hddIdRol" name="hddIdRol" value="<?php echo $rol; ?>"/>
	<input type="hidden" id="hddIdAlerta" name="hddIdAlerta" value="<?php echo $infoAlerta["id_alerta"]; ?>"/>
	<input type="hidden" id="hddIdPuesto" name="hddIdPuesto" value="<?php echo $infoPuestos[0]["id_puesto_votacion"]; ?>"/>
	<input type="hidden" id="hddIdUserAuditor" name="hddIdUserAuditor" value="<?php echo $idAuditor; ?>"/>

	<div class="form-group">							
		<div class="col-sm-12">
			<label class="radio-inline">
				<input type="radio" name="acepta" id="acepta1" value=1>Si
			</label>
			<label class="radio-inline">
				<input type="radio" name="acepta" id="acepta2" value=2>No
			</label>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-12 control-label" for="observacion">Observación</label>
		<div class="col-sm-12">
			<textarea id="observacion" name="observacion" placeholder="Observación"  class="form-control" rows="2"></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row" align="center">
			<div style="width:50%;" align="center">
				<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-<?php echo $class2; ?>"/>
			</div>
		</div>
	</div>
</form>	

<?php
}if($infoAlerta['fk_id_tipo_alerta'] == 3){//consolidacion
?>

<script>
$( document ).ready( function () {
	$("#ausentes").bloquearTexto().maxlength(5);
	$("#ausentesConfirmar").bloquearTexto().maxlength(5);
});
</script>


<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("report/registro_consolidacion_by_coordinador"); ?>" >
	<input type="hidden" id="hddIdRol" name="hddIdRol" value="<?php echo $rol; ?>"/>
	<input type="hidden" id="hddIdAlerta" name="hddIdAlerta" value="<?php echo $info[0]["id_alerta"]; ?>"/>
	<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $info[0]["id_sitio_sesion"]; ?>"/>
	<input type="hidden" id="hddIdUserDelegado" name="hddIdUserDelegado" value="<?php echo $info[0]["fk_id_user_delegado"]; ?>"/>
	<input type="hidden" id="citados" name="citados" value="<?php echo $info[0]["numero_citados"]; ?>"/>

	<div class="form-group">
		<label class="col-sm-12 control-label" for="ausentes">Cantidad de ausentes</label>
		<div class="col-sm-12">
			<input type="text" id="ausentes" name="ausentes" class="form-control" required/>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-12 control-label" for="ausentesConfirmar">Confirmar cantidad de ausentes</label>
		<div class="col-sm-12">
			<input type="text" id="ausentesConfirmar" name="ausentesConfirmar" class="form-control" required/>
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="row" align="center">
			<div style="width:50%;" align="center">
				<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-<?php echo $class2; ?>"/>
			</div>
		</div>
	</div>
</form>	

<?php } ?>

							
						</div>
					</div>
				</div>
			</div>
		</div>



				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->