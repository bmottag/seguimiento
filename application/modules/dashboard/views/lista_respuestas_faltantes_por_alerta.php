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
					<strong>Prueba: </strong><?php echo $infoAlerta['nombre_prueba']; ?>
					<br><strong>Grupo de Instrumentos: </strong><?php echo $infoAlerta['nombre_grupo_instrumentos']; ?>
					<br><strong>Sesión: </strong><?php echo $infoAlerta['sesion_prueba']; ?>
					<br><strong>Fecha: </strong><?php echo $infoAlerta['fecha']; ?>
				</div>
			</div>
		</div>
		
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
                    <i class="fa fa-life-saver fa-fw"></i> Alerta específica para varios sitios
				</div>
				<div class="panel-body">

					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Dar respuesta</th>
								<th class="text-center">Sitio</th>
								<th class="text-center">Nodo o Región</th>
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Códifo DANE</th>
								<th class="text-center">Representante</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="text-center">Dar respuesta</th>
								<th class="text-center">Sitio</th>
								<th class="text-center">Nodo o Región</th>
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Códifo DANE</th>
								<th class="text-center">Representante</th>
							</tr>
						</tfoot>
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
									//si no existe el representante entonces no se muestra el enlace
									if($lista['fk_id_user_delegado']){
echo "<a href=" . base_url("report/responder_alerta/" . $lista['id_alerta'] . "/" . $lista['fk_id_user_delegado'] . "/" . $lista['id_sitio_sesion'] . "/" . $rol) . " ><strong><u>Dar Respuesta</u></strong> </a>";
									}else{
										echo "<p class='text-danger'>Falta asignar representante para este Sitio</p>";
									}
									echo "</td>";
									echo "<td>";
									echo $lista['nombre_sitio'];
									echo "</td>";
									echo "<td>";
									echo $lista['nombre_region'];
									echo "</td>";
									echo "<td>";
									echo $lista['dpto_divipola_nombre'];
									echo "</td>";
									echo "<td>";
									echo $lista['mpio_divipola_nombre'];
									echo "</td>";
									echo "<td>";
									echo $lista['codigo_dane'];
									echo "</td>";
									echo "<td>";
									echo $lista['nombre_delegado'];
									echo "<br>";

echo "<a href='tel:".$lista['celular_delegado']."'>".$lista['celular_delegado']."</a>";
									
									echo "<br>" . $lista['email'];


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
		"pageLength": 25,
		 "columnDefs": [
    { "width": "60%", "targets": 0 }
  ]
	});
});








</script>