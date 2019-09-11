
<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> HISTORIAL
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
					<i class="fa fa-users"></i> HISTORIAL REGISTROS
				</div>
				<div class="panel-body">

				<?php
					if($info){
				?>				

					<table width="100%" class="table table-striped table-bordered table-hover" id="dataSafety">
						<thead>
							<tr>
								<th>Alerta</th>
								<th>Respuesta</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
								echo "<tr>";
									echo "<td>";
									echo "<strong>Descripción: </strong>" . $lista['descripcion_alerta'];
									echo "<br><strong>Mensaje: </strong>" . $lista['mensaje_alerta'];
									echo "<p class='" . $lista['clase'] . "'><strong>Tipo Alerta: </strong>" . $lista['nombre_tipo_alerta'] . "</p>";
									echo "<strong>Inicio Alerta: </strong>" . $lista['fecha_inicio'];
									echo "<br><strong>Fin Alerta: </strong>" . $lista['fecha_fin'];
									echo "</td>";
									
									echo "<td>";
									echo "<strong>Respuesta: </strong>";
									echo $acepta = $lista['acepta']==1?"Si":"No";
									echo "<br><strong>Ausentes: </strong>" . $lista['ausentes'];
									echo "<br><strong>Observación: </strong>" . $lista['observacion'];
									echo "<br><strong>Fecha registro: </strong>" . $lista['fecha_registro'];
																		
									echo "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				
				
				<?php } ?>
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
		
				
<!--INICIO Modal para adicionar HAZARDS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar HAZARDS -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"order": [[ 0, "asc" ]],
		"pageLength": 25
	});
});
</script>