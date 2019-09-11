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
						DASHBOARD
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


<!--INFO DE LAS SESIONES -->
<?php 
	if($listadoSesiones)
	{
		//cargo modelos
		$ci = &get_instance();
		$ci->load->model("specific_model");
		$ci->load->model("general_model");
		foreach ($listadoSesiones as $lista_1):	
?>
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-arrow-right fa-fw"></i><strong>SESIÓN: </strong><?php echo $lista_1["nombre_prueba"] . " / " . $lista_1["nombre_grupo_instrumentos"] . " / " . $lista_1["fecha"] . " / " . $lista_1["sesion_prueba"]; ?>
					<br><i class="fa fa-arrow-right fa-fw"></i><strong>Total sitios: </strong><?php echo $conteoSitios; ?>
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">
<?php
	//Buscar la alertas para esta sesion y el operador de sesion
	$arrParam = array(
		"idSesion" => $lista_1["id_sesion"]
	);
	$alertasVencidas = $this->specific_model->get_alertas_vencidas_totales($arrParam);


	if($alertasVencidas)
	{
		foreach ($alertasVencidas as $lista):
		
			//consultar informacion de la alerta
			$arrParam = array(
				"idAlerta" => $lista["id_alerta"]
			);
			$infoAlerta = $this->specific_model->get_info_alerta($arrParam);
				
if($infoAlerta["fk_id_tipo_alerta"] == 1)//INFORMATIVA
{
//se buscan las alertas INFORMATIVAS que se tienen el OPERADOR a cargo
			$arrParam = array(
							"tipoAlerta" => 1,
							"idAlerta" => $lista["id_alerta"]
						);
			$infoAlertaVencidaInformativa = $this->general_model->get_alertas_vencidas_by($arrParam);

			//recorro las alertas y reviso se se les dio respuesta, si no se le dio respuesta las voy contando
			$contadorInformativaSi = 0;
			$contadorInformativaNo = 0;
			if($infoAlertaVencidaInformativa){
				foreach ($infoAlertaVencidaInformativa as $lista):
					$arrParam = array(
							"idSitioSesion" => $lista['id_sitio_sesion'],
							"idAlerta" => $lista['id_alerta']
					);
					$respuesta = $this->general_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if($respuesta){
						$contadorInformativaSi++;
					}else{
						$contadorInformativaNo++;
					}
				endforeach;
			}

			//calculo el total
			$total = $contadorInformativaSi + $contadorInformativaNo;
			if($total != 0){
				$porcentajeSi = round((($contadorInformativaSi * 100)/$total), 1);
				$porcentajeNo = round((($contadorInformativaNo * 100)/$total), 1);
			}else{
				$porcentajeSi = 0;
				$porcentajeNo = 0;
			}
				
?>			
			
		<div class="col-lg-6">				
			<div class="row">	
				<div class="col-lg-12">	
					<div class="alert alert-danger">
						<strong>Mensaje alerta: </strong><br><?php echo $infoAlerta['mensaje_alerta']; ?><br>
						<!-- <strong>Tipo de Alerta: </strong>ALERTA INFORMATIVA<br><br> -->
						 <strong>Hora alerta: </strong><?php echo $infoAlerta['hora_alerta']; ?><br>


							<strong>Conteo de respuestas:</strong>
							<span class="pull-right text-muted"></span>

						
							<div class="progress">
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/contestaron");?>" >
								<div class="progress-bar progress-bar-info" role="progressbar" style="width:50%">
								Contestaron <?php echo number_format($contadorInformativaSi) . " (" . $porcentajeSi . "%)"; ?>
								</div>
</a>

<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/no_contestaron");?>" >
								<div class="progress-bar progress-bar-warning" role="progressbar" style="width:50%">
								No contestaron <?php echo number_format($contadorInformativaNo) . " (" . $porcentajeNo . "%)"; ?>
								</div>
</a>
								
							</div> 
						
					</div>
				</div>
			</div>	
		</div>
<?php } 




if($infoAlerta["fk_id_tipo_alerta"] == 2)//NOTIFICACION
{
//se buscan las alertas NOTIFICACION vencidas que tienen el OPERADOR a cargo			
			$arrParam = array(
							"tipoAlerta" => 2,
							"idAlerta" => $lista["id_alerta"]
			);
			$infoAlertaVencidaNotificacion = $this->general_model->get_alertas_vencidas_by($arrParam);

			//recorro las alertas y reviso se se les dio respuesta, si no se le dio respuesta las voy contando
			$contadorNotificacion = 0;
			
			$contadorNotificacionContestaron = 0;
			$contadorNotificacionSi = 0;
			$contadorNotificacionNoContestaron = 0;
		
			
			if($infoAlertaVencidaNotificacion){
				foreach ($infoAlertaVencidaNotificacion as $lista):
					$arrParam = array(
							"idSitioSesion" => $lista['id_sitio_sesion'],
							"idAlerta" => $lista['id_alerta']
					);
					$respuesta = $this->general_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if(!$respuesta){
						$contadorNotificacion++;
					}
										
					$arrParam = array(
							"idSitioSesion" => $lista['id_sitio_sesion'],
							"idAlerta" => $lista['id_alerta'],
							"respuestaAcepta" => 1
					);//filtro por los que contestaron que SI
					$respuestaSI = $this->general_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if($respuestaSI){
						$contadorNotificacionSi++;
					}
					
					if($respuesta){
						$contadorNotificacionContestaron++;
					}else{
						$contadorNotificacionNoContestaron++;
					}

				endforeach;
			}

			//calculo el total
			$contadorNotificacionNo = $contadorNotificacionContestaron - $contadorNotificacionSi;
			$total = $contadorNotificacionNoContestaron + $contadorNotificacionSi + $contadorNotificacionNo;
			$totalNotificacion = $contadorNotificacionSi + $contadorNotificacionNo;
			
			if($total != 0){
				$porcentajeNoContestaron = round((($contadorNotificacionNoContestaron * 100)/$total),1);
				$porcentajeSiContestaron = round((($contadorNotificacionContestaron * 100)/$total),1);
				$porcentajeSi = round((($contadorNotificacionSi * 100)/$total),1);
				$porcentajeNo = round((($contadorNotificacionNo * 100)/$total),1);
			}else{
				$porcentajeNoContestaron = 0;
				$porcentajeSi = 0;
				$porcentajeNo = 0;
			}
						
				
?>			
			
			
		<div class="col-lg-6">				
			<div class="row">	
				<div class="col-lg-12">	
					<div class="alert alert-warning">
						<strong>Mensaje Alerta: </strong><br><?php echo $infoAlerta['mensaje_alerta']; ?><br>
						<!-- <strong>Tipo de Alerta: </strong>ALERTA DE NOTIFICACIÓN<br><br> -->
						<strong>Hora alerta: </strong><?php echo $infoAlerta['hora_alerta']; ?><br>
						
							<strong>Conteo de respuestas:</strong>
							<span class="pull-right text-muted"></span>
						
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/contestaron");?>" >
							<div class="progress">
								<div class="progress-bar progress-bar-info" role="progressbar" style="width:50%">
								Contestaron <?php echo number_format($contadorNotificacionContestaron) . " (" . $porcentajeSiContestaron . "%)"; ?>
								</div>
</a>
								
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/no_contestaron");?>" >
								<div class="progress-bar progress-bar-warning" role="progressbar" style="width:50%">
								No contestaron <?php echo number_format($contadorNotificacionNoContestaron) . " (" . $porcentajeNoContestaron . "%)"; ?>
								</div>
</a>
								
							</div> 


						
							<div class="progress">
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/si");?>" >
								<div class="progress-bar progress-bar-success" role="progressbar" style="width:50%">
								Si <?php echo number_format($contadorNotificacionSi) . " (" . $porcentajeSi . "%)"; ?>
								</div>
</a>
								
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/no");?>" >
								<div class="progress-bar progress-bar-danger" role="progressbar" style="width:50%">
								No <?php echo number_format($contadorNotificacionNo) . " (" . $porcentajeNo . "%)"; ?>
								</div>
</a>

							</div> 
						</a>	
					</div>
				</div>
			</div>	
		</div>


<?php } 




if($infoAlerta["fk_id_tipo_alerta"] == 3)//CONSOLIDACION
{
//se buscan las alertas INFORMATIVAS que se tienen el OPERADOR a cargo
			$arrParam = array(
							"tipoAlerta" => 3,
							"idAlerta" => $lista["id_alerta"]
						);
			$infoAlertaVencidaConsolidacion = $this->general_model->get_alertas_vencidas_by($arrParam);
			
			//recorro las alertas y reviso se se les dio respuesta, si no se le dio respuesta las voy contando
			$contadorConsolidacionSi = 0;
			$contadorConsolidacionNo = 0;
			if($infoAlertaVencidaConsolidacion){
				foreach ($infoAlertaVencidaConsolidacion as $lista):
					$arrParam = array(
							"idSitioSesion" => $lista['id_sitio_sesion'],
							"idAlerta" => $lista['id_alerta']
					);
					$respuesta = $this->general_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if($respuesta){
						$contadorConsolidacionSi++;
					}else{
						$contadorConsolidacionNo++;
					}
					
				endforeach;
			}

			//calculo el total
			$totalConsolidado = $contadorConsolidacionSi + $contadorConsolidacionNo; 
			if($totalConsolidado != 0){
				$porcentajeSi = round((($contadorConsolidacionSi * 100)/$totalConsolidado),1);
				$porcentajeNo = round((($contadorConsolidacionNo * 100)/$totalConsolidado),1);
			}else{
				$porcentajeSi = 0;
				$porcentajeNo = 0;
			}
			
			//numero de citados, ausentes, presentes
			$idSesion = $lista_1['id_sesion'];
			$conteoCitadosSesion = $this->general_model->get_numero_citados_por_filtro_by_coordinnador($idSesion);

			if($conteoCitadosSesion['citados'] !=0){
				$presentes =  $conteoCitadosSesion['citados'] - $conteoCitadosSesion['ausentes'];
				$porcentajePresentes = round(($presentes * 100)/$conteoCitadosSesion['citados'],1); 
				$porcentajeAusentes = round(($conteoCitadosSesion['ausentes'] * 100)/$conteoCitadosSesion['citados'],1); 
			}else{
				$presentes =  0;
				$porcentajePresentes = 0; 
				$porcentajeAusentes = 0;
			}
?>			
		<div class="col-lg-6">				
			<div class="row">	
				<div class="col-lg-12">	
					<div class="alert alert-success ">
						<strong>Mensaje Alerta: </strong><br><?php echo $infoAlerta['mensaje_alerta']; ?><br>
						<!-- <strong>Tipo de Alerta: </strong>ALERTA DE CONSOLIDACIÓN<br><br> -->
						<strong>Hora alerta: </strong><?php echo $infoAlerta['hora_alerta']; ?><br>

							<strong>Conteo de respuestas:</strong>
							<span class="pull-right text-muted"></span>
						
						
							<div class="progress">
							
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/contestaron");?>" >							
								<div class="progress-bar progress-bar-info" role="progressbar" style="width:50%">
								Contestaron <?php echo number_format($contadorConsolidacionSi) . " (" . $porcentajeSi . "%)"; ?>
								</div>
</a>

<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/operador/no_contestaron");?>" >
								<div class="progress-bar progress-bar-warning" role="progressbar" style="width:50%">
								No contestaron <?php echo number_format($contadorConsolidacionNo) . " (" . $porcentajeNo . "%)"; ?>
								</div>
</a>
							</div> 
						</a>	
						
						<p>
							<strong>Número total
							<span class="pull-right"><?php echo number_format($conteoCitadosSesion['citados']); ?></span></strong>
						</p>							
							<div class="progress">
								<div class="progress-bar progress-bar-danger" role="progressbar" style="width:50%">
								Entregado <?php echo number_format($presentes) . " (" . $porcentajePresentes . "%)"; ?>
								</div>
								<div class="progress-bar progress-bar-success" role="progressbar" style="width:50%">
								Disponible <?php echo number_format($conteoCitadosSesion['ausentes']) . " (" . $porcentajeAusentes . "%)"; ?> 
								</div>
							</div> 
							
					</div>
				</div>
			</div>	
		</div>
<?php } ?>



	
		

			
<?php
		endforeach;
	}
?>	

	
 
				
				
				
					
				</div>
				<!-- /.panel-body -->
			</div>
		</div>

	</div>
<?php
		endforeach;
	}
?>
<!--INFO DE LAS SESIONES -->



























		

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
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
					<form  name="form" id="<?php echo "form_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_notificacion"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						
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

		



	<!-- LISTADO DE SITIOS -->
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-home fa-fw"></i> Lista de Sitios
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">
					<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>

<?php
	if(!$infoSitios){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No hay Sitios</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Departamento</th>
								<th>Municipio</th>
								<th>Sitio</th>
								<th>Código DANE</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$i=0;
							foreach ($infoSitios as $lista):
								$i++;
								echo "<tr>";								
								echo "<td >" . $i . "</td>";
								echo "<td >" . strtoupper($lista['dpto_divipola_nombre']) . "</td>";
								echo "<td >" . strtoupper($lista['mpio_divipola_nombre']) . "</td>";
								echo "<td >";
echo "<a href='" . base_url('report/mostrarSesiones/' . $lista['id_sitio'] . '/operador' ) . "'>" . $lista['nombre_sitio'] . "</a>";
								echo "</td>";
								echo "<td class='text-center'>" . $lista['codigo_dane'] . "</td>";
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
	<!-- LISTADO DE SITIOS -->




</div>
<!-- /#page-wrapper -->