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
						DASHBOARD OPERADO
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

<?php 
	//cargo modelos
	$ci = &get_instance();
	$ci->load->model("specific_model");
?>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-arrow-right fa-fw"></i><strong>Total puestos de votación: </strong><?php echo $conteoPuestos; ?>
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">

<?php

	if($alertasVencidas)
	{
		foreach ($alertasVencidas as $lista):
		
			//consultar informacion de la alerta
			$arrParam = array(
				"idAlerta" => $lista["id_alerta"]
			);
			$infoAlerta = $this->specific_model->get_info_alerta($arrParam);

if($infoAlerta["fk_id_tipo_alerta"] == 2)//NOTIFICACION
{
//se buscan las alertas NOTIFICACION vencidas
			$arrParam = array(
							"tipoAlerta" => 2,
							"idAlerta" => $lista["id_alerta"]
			);
			$infoAlertaVencidaNotificacion = $this->specific_model->get_alertas_vencidas_by($arrParam);
			
			//recorro las alertas y reviso se se les dio respuesta, si no se le dio respuesta las voy contando
			$contadorNotificacion = 0;
			
			$contadorNotificacionContestaron = 0;
			$contadorNotificacionSi = 0;
			$contadorNotificacionNoContestaron = 0;
			$total = $conteoPuestos;
		
			
			if($infoAlertaVencidaNotificacion){
				foreach ($infoAlertaVencidaNotificacion as $lista):
					$arrParam = array(
							"idAlerta" => $lista['id_alerta']
					);
					$respuesta = $this->specific_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if(!$respuesta){
						$contadorNotificacion++;
					}
										
					$arrParam = array(
							"idAlerta" => $lista['id_alerta'],
							"respuestaAcepta" => 1
					);//filtro por los que contestaron que SI
					$respuestaSI = $this->specific_model->get_respuestas_alertas_vencidas_by($arrParam);
					
					if($respuestaSI){
						$contadorNotificacionSi++;
					}
					
					if($respuesta){
						$contadorNotificacionContestaron++;
					}

				endforeach;
			}

			//calculo el total
			$contadorNotificacionNo = $contadorNotificacionContestaron - $contadorNotificacionSi;
			$contadorNotificacionNoContestaron = $total - $contadorNotificacionContestaron;
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
						
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/directivo/contestaron");?>" >
							<div class="progress">
								<div class="progress-bar progress-bar-info" role="progressbar" style="width:50%">
								Contestaron <?php echo number_format($contadorNotificacionContestaron) . " (" . $porcentajeSiContestaron . "%)"; ?>
								</div>
</a>
								
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/directivo/no_contestaron");?>" >
								<div class="progress-bar progress-bar-warning" role="progressbar" style="width:50%">
								No contestaron <?php echo number_format($contadorNotificacionNoContestaron) . " (" . $porcentajeNoContestaron . "%)"; ?>
								</div>
</a>
								
							</div> 


						
							<div class="progress">
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/directivo/si");?>" >
								<div class="progress-bar progress-bar-success" role="progressbar" style="width:50%">
								Si <?php echo number_format($contadorNotificacionSi) . " (" . $porcentajeSi . "%)"; ?>
								</div>
</a>
								
<a href="<?php echo base_url("dashboard/alerta_especifica/" . $lista['id_alerta'] . "/directivo/no");?>" >
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


<?php }  ?>

<?php
		endforeach;
	}
?>




















				
				
				</div>
			</div>
		</div>
	</div>
		

	<!-- LISTADO DE PUESTOS DE VOTACION -->
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-home fa-fw"></i> LISTA PUESTOS DE VOTACIÓN
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">

<?php
	if(!$infoPuestos){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No hay Puestos de Votación</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>No. puesto de votación</th>
								<th>Nombre puesto de votación</th>
								<th>Departamento</th>
								<th>Municipio</th>
								<th>Localidad</th>
								<th>No. total de mesas</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$i=0;
							foreach ($infoPuestos as $lista):
								$i++;
								echo "<tr>";								
								echo "<td class='text-center'>" . $lista['numero_puesto_votacion'] . "</td>";
								echo "<td >" . strtoupper($lista['nombre_puesto_votacion']) . "</td>";
								echo "<td >" . strtoupper($lista['nombre_departamento']) . "</td>";
								echo "<td >" . strtoupper($lista['nombre_municipio']) . "</td>";
								echo "<td>";
								echo "<strong>ID: </strong>" . $lista['id_localidad'];
								echo "<br>" . $lista['nombre_localidad'];
								echo "</td>";
								
								echo "<td class='text-center'>";
echo "<a href='" . base_url('report/mostrarSesiones/' . $lista['id_puesto_votacion'] . '/admin' ) . "'>" . $lista['total_mesas'] . "</a>";
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
	<!-- LISTADO DE PUESTO DE VOTACION -->

</div>
<!-- /#page-wrapper -->