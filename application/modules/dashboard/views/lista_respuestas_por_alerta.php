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
								<th class="text-center">Respuesta</th>
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
                <th class="text-center">Respuesta</th>
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
					$info = $this->general_model->get_informacion_respuestas_alertas_vencidas_by($arrParam);
	
							foreach ($info as $lista):
									echo "<tr>";
									
									echo "<td>";
										echo "<strong>Respuesta: </strong>";
										echo $acepta = $respuesta[0]['acepta']==1?"Si":"No";
										echo "<br><strong>Observación: </strong>" . $respuesta[0]['observacion'];
										if($respuesta[0]['ausentes']!=""){
											echo "<br><strong>Ausentes: </strong>" . $respuesta[0]['ausentes'];
											echo "<br><a href=" . base_url("report/update_alerta_consolidacion/" . $respuesta[0]['id_registro'] . "/" . $rol) . " ><strong>Editar Respuesta</strong> </a>";
										}
										echo "<br><strong>Fecha registro: </strong>" . $respuesta[0]['fecha_registro'];
										
										
										
//si no se acepta la alerta enotnces se crea enlace para poder aceptarla por parte del coordiandor, director o operador
if($respuesta[0]['acepta']==2){
		if(($userRol == 6 && $lista['fk_id_user_operador'] == $userID) || ($userRol == 3 && $lista['fk_id_user_coordinador'] == $userID) || $userRol == 2 || $userRol == 1){						
echo "<br><a href=" . base_url("report/update_alerta_notificacion/" . $respuesta[0]['id_registro'] . "/" . $rol) . " ><strong>Cambiar Respuesta</strong> </a>";
		}
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

									echo "</tr>";
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