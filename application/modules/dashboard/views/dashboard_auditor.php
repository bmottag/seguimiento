<a name="anclaUp"></a>

<script type="text/javascript">
	function reloadPage() {
		location.reload(true)
	}

	setInterval('reloadPage()','60000');//40 segundos
</script>

<?php
	$userRol = $this->session->rol;
?>

<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD AUDITOR
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
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

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-building"></i> Información puesto de votación
				</div>
				<div class="panel-body">
				
					<div class="col-lg-4">				
						<div class="row">	
							<div class="col-lg-12">	
								<div class="alert alert-info">
									<strong>No. puesto de votación: </strong>
									<?php echo $infoPuesto[0]['numero_puesto_votacion']; ?>
									<br><strong>Puesto de votación: </strong><br>
									<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
									<br><strong>Circunscripción: </strong>
									<?php echo $infoPuesto[0]['circunscripcion']; ?>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="col-lg-4">				
						<div class="row">	
							<div class="col-lg-12">	
								<div class="alert alert-info">
									<strong>Departamento: </strong>
									<?php echo $infoPuesto[0]['nombre_departamento']; ?>
									<br><strong>Municipio: </strong>
									<?php echo $infoPuesto[0]['nombre_municipio']; ?>
									<br><strong>ID Localidad: </strong>
									<?php echo $infoPuesto[0]['id_localidad']; ?>
									<br><strong>Localidad: </strong>
									<?php echo $infoPuesto[0]['nombre_localidad']; ?>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="col-lg-4">				
						<div class="row">	
							<div class="col-lg-12">	
								<div class="alert alert-info">
									<strong>Auditor: </strong><br>
									<?php 
										echo $this->session->userdata("firstname"); 
										echo " "; 
										echo $this->session->userdata("lastname"); 
									?>
									
									<br><br>			
<a href="<?php echo base_url(); ?>" class="btn btn-danger btn-lg btn-block" > FINALIZAR PROCESO <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a> 
									
									
								</div>
							</div>
						</div>	
					</div>
				
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->

	<div class="row">
<!--INICIO ALERTA INFORMATIVA -->
<?php 
if($infoAlertaInformativa)
{
	foreach ($infoAlertaInformativa as $lista):
	
	//consultar si ya el usuario dio respuesta a esta alerta
	$ci = &get_instance();
	$ci->load->model("dashboard_model");
	
	$arrParam = array("idAlerta" => $lista["id_alerta"]);
	$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
	
	if(!$existeRegistro){
?>	
		<div class="col-lg-6">				
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaInformativa[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">
						
					<div class="col-lg-12">	
						<div class="alert alert-danger ">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
					<form  name="form" id="<?php echo "form_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_informativo"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
					
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-danger"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>
<?php
	}
	endforeach;			
} ?>
<!--FIN ALERTA -->


<!--INICIO ALERTA NOTIFICACION -->
<?php 
if($infoAlertaNotificacion)
{
	foreach ($infoAlertaNotificacion as $lista):
	
	//consultar si ya el usuario dio respuesta a esta alerta
	$ci = &get_instance();
	$ci->load->model("dashboard_model");
	
	$arrParam = array("idAlerta" => $lista["id_alerta"]);
	$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
	
	if(!$existeRegistro){
?>	
		<div class="col-lg-6">				
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaNotificacion[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">

<?php
$retornoError = $this->session->flashdata('retornoErrorNotificacion');
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
						<div class="alert alert-warning ">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha_alerta']; ?><br>
							
					<br>
					<form  name="form" id="<?php echo "form_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_notificacion"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdPrueba" name="hddIdPrueba" value="<?php echo $infoPuesto[0]['id_puesto_votacion']; ?>"/>
						
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
									<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-warning"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>
				
				</div>
			</div>
		</div>
<?php
	}
	endforeach;
} ?>
<!--FIN ALERTA -->


<!--INICIO ALERTA CONSOLIDACION -->
<?php 
if($infoAlertaConsolidacion)
{
	foreach ($infoAlertaConsolidacion as $lista):
	
	//consultar si ya el usuario dio respuesta a esta alerta
	$ci = &get_instance();
	$ci->load->model("dashboard_model");
	
	$arrParam = array("idAlerta" => $lista["id_alerta"]);
	$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
	
	if(!$existeRegistro){
?>						
		<div class="col-lg-6">				
			<div class="panel panel-green">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaConsolidacion[0]['nombre_tipo_alerta']; ?>
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
						<div class="alert alert-success">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
<script>
$( document ).ready( function () {
	$("#ausentes").bloquearTexto().maxlength(5);
});
</script>
					<form  name="formConsolidacion" id="<?php echo "formConsolidacion_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_consolidacion"); ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						
						<input type="hidden" id="citados" name="citados" value="<?php echo $lista["numero_citados"]; ?>"/>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentes">Cantidad de ausentes</label>
							<div class="col-sm-12">
								<input type="text" id="ausentes" name="ausentes" class="form-control" required/>
							</div>
						</div>
											
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnConsolidacion" name="btnConsolidacion" value="Enviar" class="btn btn-success"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>
<?php
	}
	endforeach;
} ?>
<!--FIN ALERTA -->
	</div>
	
	
	<!-- LISTADO MESAS PARA EL AUDITOR -->
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-home fa-fw"></i> Listado de mesas de votación
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">

<?php
	if(!$infoMesas){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No tiene mesas de votación asignadas.</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Número mesa</th>
								<th class="text-center">Escrutinio presidente</th>
								<th class="text-center">Escrutinio diputado</th>
								<th class="text-center">Estado mesa</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoMesas as $lista):

								echo "<tr>";								
								echo "<td class='text-center'>" . $lista['numero_mesa'] . "</td>";
								
///VERIFICAR SI YA SE REALIZARON LOS VOTOS 
if($lista['estado_mesa'] == 2){
	$botonPresidente = "disabled";
	$botonDiputado = "disabled";
	$enlacePresidente = "#" ;
	$mensajePresidente = '<p class="text-danger">Escrutinio <strong>cerrado </strong>para presidente</p>';
	
	$enlaceDiputado = "#" ;
	$mensajeDiputado = '<p class="text-danger">Escrutinio <strong>cerrado</strong> para diputado</p>';
}else{
	$botonPresidente = "";
	$botonDiputado = "";
	$enlacePresidente = base_url("registro/presidente/" . $lista['id_mesa']); 
	$mensajePresidente = '';
	
	$enlaceDiputado = base_url("registro/diputado/" . $lista['id_mesa']); 
	$mensajeDiputado = '';
	
	if($lista['estado_presidente'] == 3){
		$botonPresidente = "disabled";
		$enlacePresidente = "#" ;
		$mensajePresidente = '<p class="text-danger">Escrutinio <strong>cerrado </strong>para presidente</p>';
	}
		
	if($lista['estado_diputado'] == 3){
		$botonDiputado = "disabled";
		$enlaceDiputado = "#" ;
		$mensajeDiputado = '<p class="text-danger"><strong>Escrutinio <strong>cerrado</strong> para diputado</strong></p>';
	}
}
								echo "<td class='text-center'>";


?>
<a href="<?php echo $enlacePresidente; ?>" class="btn btn-info btn-xs" <?php echo $botonPresidente; ?>>
Votos PRESIDENTE  
</a>	

<?php echo $mensajePresidente; ?>

						<?php
								echo "</td>";
								echo "<td class='text-center'>";

								//si el TIPO DE VOTO ES SOLO PARA PRESIDENTE ENTONCES NO MOSTRAR BOTON
								if($lista['tipo_voto'] != 1)
								{
						?>
<a href="<?php echo $enlaceDiputado; ?>" class="btn btn-danger btn-xs" <?php echo $botonDiputado; ?>>
Votos DIPUTADOS  
</a>	
								<?php 
									echo $mensajeDiputado; 
									
									//si el TIPO DE VOTO es tipo 3, mostrar mensaje
									if($lista['tipo_voto'] == 3){
										echo '<p class="text-warning"><strong>Advertencia: </strong>Registre la información de DIPUTADOS CIR. UNINOMINAL</p>';
									}

								}else{
									echo '<p class="text-primary">Escrutinio solo para Presidente</p>';
								} 
								
								echo "</td>";
								
									echo "<td class='text-center'>";
									switch ($lista['estado_mesa']) {
											case 1:
													$valor = 'Abierta';
													$clase = "text-success";
													break;
											case 2:
													$valor = 'Cerrada';
													$clase = "text-danger";
													break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				
<?php	} ?>					
				</div>
				<!-- /.panel-body -->
			</div>
		</div>

	</div>
	<!-- LISTADO MESAS PARA EL AUDITOR -->


		



</div>
<!-- /#page-wrapper -->