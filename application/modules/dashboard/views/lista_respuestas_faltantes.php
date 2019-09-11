<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-bar-chart-o fa-fw"></i> RESPUESTAS FALTANTES
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
					<a class="btn btn-success" href=" <?php echo base_url(). "dashboard/" . $rol; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
                    <i class="fa fa-life-saver fa-fw"></i> Lista de Alertas que falta dar respuesta por el Representante
				</div>
				<div class="panel-body">

					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Sitio</th>
								<th class="text-center">Alerta</th>
								<th class="text-center">Sesión</th>
								<th class="text-center">Respuesta</th>
							</tr>
						</thead>
						<tbody>	
						
		<?php

		if($infoAlertaVencida){
			foreach ($infoAlertaVencida as $lista):
				$arrParam = array(
						"idSitioSesion" => $lista['id_sitio_sesion'],
						"idAlerta" => $lista['id_alerta']
				);
				$respuesta = $this->general_model->get_respuestas_alertas_vencidas_by($arrParam);
				
				//si no tiene respuesta entonces buscar la información
				if(!$respuesta){
					$info = $this->general_model->get_informacion_respuestas_alertas_vencidas_by($arrParam);
					

					
					
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>";
									echo "<strong>Sitio: </strong><br>" . $lista['nombre_sitio'];
									echo "<br><strong>Nodo o Región: </strong>" . $lista['nombre_region'];
									echo "<br><strong>Departamento: </strong>" . $lista['dpto_divipola_nombre'];
									echo "<br><strong>Municipio: </strong>" . $lista['mpio_divipola_nombre'];
									echo "<br><strong>Códifo DANE: </strong>" . $lista['codigo_dane'];
									echo "<br><strong>Representante: </strong>" . $lista['nombre_delegado'];
									echo "<br>Celular: ";

echo "<a href='tel:".$lista['celular_delegado']."'>".$lista['celular_delegado']."</a>";
									
									echo "<br><strong>Email: </strong>" . $lista['email'];
									echo "</td>";
									
									
									echo "<td>";
									echo "<strong>Descripción: </strong>" . $lista['descripcion_alerta'];
									echo "<br><strong>Mensaje: </strong>" . $lista['mensaje_alerta'];
									echo "<br><strong>Tipo Alerta: </strong>" . $lista['nombre_tipo_alerta'];
									echo "<br><strong>Inicio Alerta: </strong>" . $lista['fecha_inicio'];
									echo "<br><strong>Fin Alerta: </strong>" . $lista['fecha_fin'];
									echo "</td>";
									
									
									echo "<td>";
									echo "<strong>Prueba: </strong>" . $lista['nombre_prueba'];
									echo "<br><strong>Grupo de Instrumentos: </strong>" . $lista['nombre_grupo_instrumentos'];
									echo "<br><strong>Sesión: </strong>" . $lista['sesion_prueba'];
									echo "<br><strong>Fecha: </strong>" . $lista['fecha'];
									echo "<br><strong>Hora Inicial: </strong>" . $lista['hora_inicio_prueba'];
									echo "<br><strong>Hora Final: </strong>" . $lista['hora_fin_prueba'];
									echo "</td>";
									
									
									echo "<td>";
									//si no existe el representante entonces no se muestra el enlace
									if($lista['fk_id_user_delegado']){
echo "<a href=" . base_url("report/responder_alerta/" . $lista['id_alerta'] . "/" . $lista['fk_id_user_delegado'] . "/" . $lista['id_sitio_sesion'] . "/" . $rol) . " ><strong>Dar Respuesta</strong> </a>";
									}else{
										echo "<p class='text-danger'>Falta asignar representante para este Sitio</p>";
									}
									echo "</td>";
							endforeach;
					
					
					
					
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