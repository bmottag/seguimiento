<?php
	$userRol = $this->session->rol;
	$userID = $this->session->id;
?>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> RESPUESTAS PARA UNA ALERTA ESPECÍFICA
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<div class="row">
		
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Alerta: </strong><?php echo $infoAlerta['mensaje_alerta']; ?>
					<br><strong>Tipo Alerta: </strong><?php echo $infoAlerta['nombre_tipo_alerta']; ?>
					<br><strong>Inicio Alerta: </strong><?php echo $infoAlerta['fecha_inicio']; ?>
					<br><strong>Fin Alerta: </strong><?php echo $infoAlerta['fecha_fin']; ?>
				</div>
			</div>
		</div>
		
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url(). "dashboard/" . $rol; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
                    <i class="fa fa-life-saver fa-fw"></i> Alerta específica para puestos de votación
				</div>
				<div class="panel-body">

					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Auditor</th>
								<th class="text-center">Respuesta</th>
								<th class="text-center">Puesto de votación</th>
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Localidad</th>
								<th class="text-center">Circunscripción</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="text-center">Auditor</th>
								<th class="text-center">Respuesta</th>
								<th class="text-center">Puesto de votación</th>
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Localidad</th>
								<th class="text-center">Circunscripción</th>
							</tr>
						</tfoot>
						<tbody>	
						
						<?php

						if($infoAuditores){
							foreach ($infoAuditores as $lista):
								$arrParam = array(
										"idUsuario" => $lista['fk_id_usuario_auditor'],
										"idAlerta" => $infoAlerta['id_alerta']
								);
								$respuesta = $this->specific_model->get_respuestas_alertas_vencidas_by($arrParam);
				
								$bandera = FALSE;
								if($answer == "si" && $respuesta[0]['acepta']==1){
									$bandera = TRUE;
								}
								if($answer == "no" && $respuesta[0]['acepta']==2){
									$bandera = TRUE;
								}
								if($answer == "contestaron"){
									$bandera = TRUE;
								}

				if($respuesta && $bandera){

	
								echo "<tr>";
								
								echo "<td >";
								echo strtoupper($lista['nombre']);
								echo "<br>";
								echo "<strong>Celular: </strong><a href='tel:" . $lista['celular'] . "'>" . $lista['celular'] . "</a>";								
								echo "</td>";
								
								echo "<td>";
								echo "<strong>Respuesta: </strong>";
								echo $acepta = $respuesta[0]['acepta']==1?"Si":"No";
								echo "<br><strong>Observación: </strong>" . $respuesta[0]['observacion'];
								echo "<br><strong>Fecha registro: </strong>" . $respuesta[0]['fecha_registro'];
									
									
									
//si no se acepta la alerta enotnces se crea enlace para poder aceptarla por parte del OPERADOR, director
if($respuesta[0]['acepta']==2){
	if(($userRol == 3 && $lista['fk_id_usuario_operador'] == $userID) || $userRol == 1){						
echo "<br><a href=" . base_url("report/update_alerta_notificacion/" . $respuesta[0]['id_registro'] . "/" . $rol) . " ><strong>Cambiar Respuesta</strong> </a>";
	}
}
								echo "</td>";
					
								echo "<td>";
								echo "<strong>No.: </strong>" . $lista['numero_puesto_votacion'];
								echo "<br><strong>Nombre: </strong>" . $lista['nombre_puesto_votacion'];
								echo "</td>";
								echo "<td>";
								echo $lista['nombre_departamento'];
								echo "</td>";
								echo "<td>";
								echo $lista['nombre_municipio'];
								echo "</td>";
								echo "<td>";
								echo "<strong>ID: </strong>" . $lista['id_localidad'];
								echo "<br><strong>Nombre: </strong>" . $lista['nombre_localidad'];
								echo "</td>";
								echo "<td>";
								echo $lista['circunscripcion'];
								echo "</td>";

								echo "</tr>";

				
				
					
				}
			endforeach;
		}
						
						
						
						

						?>
						</tbody>
					</table>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		order: false,
		"pageLength": 25
	});
});








</script>