<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sesiones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalMesas',
                data: {'idPuesto': oID, 'idMesa': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
	
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalMesas',
                data: {'idPuesto': '', 'idMesa': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
});
</script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - MESAS
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
					<a class="btn btn-success btn-xs" href=" <?php echo base_url(). 'admin/puestos'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-gears "></i> LISTA DE MESAS
				</div>
				<div class="panel-body">
				
					<div class="col-lg-4">				
						<div class="row">	
							<div class="col-lg-12">	
								<div class="alert alert-success">
									<strong>No. puesto de votación: </strong>
									<?php echo $infoPuesto[0]['numero_puesto_votacion']; ?>
									<br><strong>Puesto de votación: </strong><br>
									<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
									<br><strong>Número de mesas: </strong>
									<?php echo $infoPuesto[0]['total_mesas']; ?>
								</div>
							</div>
						</div>	
					</div>
					
					<div class="col-lg-4">				
						<div class="row">	
							<div class="col-lg-12">	
								<div class="alert alert-success">
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
								<div class="alert alert-success">
									<strong>Auditores: </strong><br>
									<?php 
										if($infoAuditores){
											foreach ($infoAuditores as $listaEncargado):	
												echo $listaEncargado['nombres_usuario'] . " " . $listaEncargado['apellidos_usuario'];
											endforeach;
										}else{
											echo "No hay Auditores. Asignarlo.";
										}
									?>
								</div>
							</div>
						</div>	
					</div>
				
				
				
				
				
				
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoPuesto[0]['id_puesto_votacion']; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Mesa
					</button><br>
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-success ">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<?php echo $retornoExito ?>		
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="col-lg-12">	
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<?php echo $retornoError ?>
		</div>
	</div>
    <?php
}
?> 
				<?php
					if($info){
				?>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Número mesa</th>
								<th class="text-center">Número personas habilitadas</th>
								<th class="text-center">Tipo voto</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['numero_mesa'] . "</td>";
									echo "<td class='text-center'>" . $lista['personas_habilitadas'] . "</td>";
									
									switch ($lista['tipo_voto']) {
											case 1:
													$valor = 'Solo Presidente';
													$clase = "text-success";
													break;
											case 2:
													$valor = 'Presidente y Diputado';
													$clase = "text-danger";
													break;
											case 3:
													$valor = 'Presidente, Diputado y Especiales';
													$clase = "text-warning";
													break;
									}
									echo "<td class='text-center'>";
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_mesa']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									
									<br><br>

<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_mesa']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>
						<?php
									echo "</td>";
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
		"pageLength": 25
	});
});
</script>