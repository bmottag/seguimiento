<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url().'busqueda'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-users"></i> LISTA DE ESTABLECIMIENTO Y PROPIETARIO
				</div>
				<div class="panel-body">
				
				<?php
					if($info){
				?>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">No. formulario</th>
								<th class="text-center">ID Manzana</th>
								<th class="text-center">Encuesta</th>
								<th class="text-center">Nombre comercial, razón social o  nombre del propietario</th>
								<th class="text-center">Dirección del establecimiento</th>
								<th class="text-center">Teléfono y/o celular del establecimiento</th>
								<th class="text-center">Tipo Documento</th>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Encuestador</th>
								<th class="text-center">Supervisor</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Ver en mapa</th>
							</tr>
						</thead>
						<tbody>							
						<?php
						
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-right'>" . $lista['id_establecimiento'] . "</td>";
									echo "<td class='text-center'>";
						?>
<a href="<?php echo base_url("encuesta/establecimiento/" . $lista['fk_id_manzana']); ?>" class="btn btn-danger btn-xs">
<?php echo $lista['fk_id_manzana']; ?>
</a>
						<?php
									echo "</td>";
									echo "<td class='text-center'>";
						?>
						
						
<?php 
$userRol = $this->session->rol;
	
	$boton = "";
	$enlace = base_url("encuesta/form_home/" . $lista['id_establecimiento']);
	if($userRol==3 && $lista['aprobacion_supervisor'] == 3){//para los ENCUESTADORES si la encuesta esta aprobada no se puede editar nada
		$boton = "disabled";
		$enlace = "#";
	}elseif($userRol==2 && $lista['aprobacion_coordinador'] == 4){//para los SUPERVISORES si la encuesta esta aprobada por el coordinador no puede editar nada
		$boton = "disabled";
		$enlace = "#";
	}
?>
						
<a href="<?php echo $enlace; ?>" class="btn btn-warning btn-xs" <?php echo $boton; ?>>
Encuesta  
</a>


						<?php
						
						
									if($lista['aprobacion_supervisor']==3) {

											
echo '<br><br><button type="button" class="btn btn-success btn-circle">AS</button>';
											
									}
									if($lista['aprobacion_coordinador']==4){
echo '  <button type="button" class="btn btn-primary btn-circle">AC</button>';
									}
						
						
						
									echo "</td>";
									echo "<td class='text-center'>" . $lista['nombre_propietario'] . "</td>";
									echo "<td class='text-center'>" . $lista['direccion'] . "</td>";
									echo "<td class='text-center'>" . $lista['telefono'] . "</td>";
									echo "<td>";

									switch ($lista['tipo_documento']) {
										case 1:
											echo "NIT/RUT";
											break;
										case 2:
											echo "Cédula de ciudadanía C.C.";
											break;
										case 3:
											echo "Cédula de extranjería C.E.";
											break;
										case 4:
											echo "No tiene";
											break;
										case 5:
											echo "NS/NR";
											break;
									}
									
									echo "</td>";
									echo "<td>" . $lista['cedula'] . "</td>";
									
									echo "<td>";
									echo $lista['nombres_usuario'] . " " . $lista['apellidos_usuario'];
									echo "</td>";
									
									echo "<td>";
									echo $lista['jefe'];
									echo "</td>";
									
									echo "<td class='text-center'>" . $lista['fecha_registro'] . "</td>";
?>
<td class='text-center'>
<a href="<?php echo base_url("busqueda/mapa/" . $lista['id_establecimiento']); ?>" target="_blank" class="btn btn-primary btn-circle" <?php echo $boton; ?>>
  <span class="glyphicon glyphicon-screenshot" aria-hidden="true">
</a>
</td>
<?php
									
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
		"pageLength": 50
	});
});
</script>