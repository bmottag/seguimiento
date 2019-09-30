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
						DASHBOARD OPERADOR
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
			//recorro las alertas y reviso se se les dio respuesta, si no se le dio respuesta las voy contando
			$contadorNotificacion = 0;
			
			$contadorNotificacionContestaron = 0;
			$contadorNotificacionSi = 0;
			$contadorNotificacionNoContestaron = 0;

			foreach ($infoAuditores as $listaAuditor):
				$arrParam = array(
						"idUsuario" => $listaAuditor['fk_id_usuario_auditor'],
						"idAlerta" => $lista['id_alerta']
				);
				$respuesta = $this->specific_model->get_respuestas_alertas_vencidas_by($arrParam);
							
				if(!$respuesta){
					$contadorNotificacion++;
				}
									
				$arrParam = array(
						"idUsuario" => $listaAuditor['fk_id_usuario_auditor'],
						"idAlerta" => $lista['id_alerta'],
						"respuestaAcepta" => 1
				);//filtro por los que contestaron que SI
				$respuestaSI = $this->specific_model->get_respuestas_alertas_vencidas_by($arrParam);
				
				if($respuestaSI){
					$contadorNotificacionSi++;
				}
				
				if($respuesta){
					$contadorNotificacionContestaron++;
				}else{
					$contadorNotificacionNoContestaron++;
				}

			endforeach;


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
					<i class="fa fa-users"></i> Lista de auditores
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">

<?php
	if(!$infoAuditores){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No hay Puestos de Votación</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class='text-center'>Auditor</th>
								<th class='text-center'>Puesto de votación</th>
								<th class='text-center'>No. total de mesas</th>
								<th class='text-center'>Presidente - Porcentaje de avance</th>
								<th class='text-center'>Diputados - Porcentaje de avance</th>
								<th class='text-center'>Resumen</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoAuditores as $lista):
							
								//conteo mesas del auditor
								$arrParam = array(
												"idAuditor" => $lista["fk_id_usuario_auditor"],
												);
								$contarMesasAuditor = $this->specific_model->countMesasCerradas($arrParam);
							
								//conteo de mesas cerradas para un AUDITOR
								$arrParam = array(
												"idAuditor" => $lista["fk_id_usuario_auditor"],
												"columna" => "estado_mesa",
												"valor" => 2
												);
								$contarMesasCerradas = $this->specific_model->countMesasCerradas($arrParam);
								
								//conteo de mesas cerradas para PRESIDENTE para un AUDITOR
								$arrParam = array(
												"idAuditor" => $lista["fk_id_usuario_auditor"],
												"columna" => "estado_presidente",
												"valor" => 3
												);
								$contarMesasPresidenteCerradas = $this->specific_model->countMesasCerradas($arrParam);
								
								//conteo de mesas cerradas para DIPUTADO para un AUDITOR
								$arrParam = array(
												"idAuditor" => $lista["fk_id_usuario_auditor"],
												"columna" => "estado_diputado",
												"valor" => 3
												);
								$contarMesasDiputadoCerradas = $this->specific_model->countMesasCerradas($arrParam);

								echo "<tr>";								

								echo "<td >";
								echo strtoupper($lista['nombre']);
								echo "<br>";
								echo "<strong>Celular: </strong><a href='tel:" . $lista['celular'] . "'>" . $lista['celular'] . "</a>";								
								echo "</td>";
								
								echo "<td >";
								echo "<strong>No.: </strong>" . strtoupper($lista['numero_puesto_votacion']);
								echo "<br>" . strtoupper($lista['nombre_puesto_votacion']);
								echo "<br><strong>Departamento: </strong>" . strtoupper($lista['nombre_departamento']);
								echo "<br><strong>Municipio: </strong>" . strtoupper($lista['nombre_municipio']);
								echo "<br><strong>Id Localidad: </strong>" . strtoupper($lista['id_localidad']);
								echo "<br><strong>Localidad: </strong>" . strtoupper($lista['nombre_localidad']);
								echo "<br><strong>Circusncripción: </strong>" . strtoupper($lista['circunscripcion']);
								echo "</td>";
																
								echo "<td class='text-center'>";
								echo $contarMesasAuditor;
								?>
<br><br>
<a href="<?php echo base_url("dashboard/ver_puesto/" . $lista['fk_id_usuario_auditor']); ?>" class="btn btn-info btn-xs">
Ver mesas de votación
</a>	
								<?php

								echo "</td>";
								
								$porcentajeAvancePresidente = $contarMesasPresidenteCerradas * 100/$contarMesasAuditor;								
								$porcentajeAvanceDiputado = $contarMesasDiputadoCerradas * 100/$contarMesasAuditor;								
								echo "<td class='text-center'>" ;
								echo '<p class="text-info"><strong>' . $porcentajeAvancePresidente . '%</strong></p>';
								echo "</td>";
								
								echo "<td class='text-center'>";
								echo '<p class="text-danger"><strong>' . $porcentajeAvanceDiputado . '%</strong></p>';
								echo "</td>";
								
								echo "<td>";
								echo "<strong>No. mesas cerradas: </strong>" . $contarMesasCerradas;
								echo "<br><strong>No. mesas escrutadas presidente: </strong>" . $contarMesasPresidenteCerradas;
								echo "<br><strong>No. mesas escrutadas diputado: </strong>" . $contarMesasDiputadoCerradas;
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

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"ordering": true,
		"order": [[ 3, 'desc' ]],
		 paging: false,
		"searching": false
		
	});
});
</script>