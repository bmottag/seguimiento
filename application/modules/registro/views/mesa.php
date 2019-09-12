<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<i class="fa fa-bullseye"></i> LISTA MESAS
				</div>
				<div class="panel-body">
									
					
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

					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-success">
										<strong>Puesto de votación: </strong>
										<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
										<br><strong>Geolocalización: </strong>
										<?php echo $infoPuesto[0]['geolocalizacion']; ?>
										<br><strong>Número de mesas: </strong>
										<?php echo $infoPuesto[0]['numero_mesas']; ?>
										 - <strong>ID: </strong>
										<?php echo $infoPuesto[0]['id_puesto_votacion']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>



				<?php
					if($info){
				?>				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Editar</th>
								<th class="text-center">Número de mesa</th>
								<th class="text-center">Número de inscritos</th>
								<th class="text-center">Estado</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>";
						?>
						
									
<?php 
///VERIFICAR SI YA SE REALIZARON LOS VOTOS 


if($lista['estado_mesa'] == 2){
	$boton = "disabled";
}else{
	$boton = "";
}


?>
<a href="<?php echo base_url("registro/presidente/" . $lista['id_mesa']); ?>" class="btn btn-info btn-xs" <?php echo $boton; ?>>
Votos PRESIDENTE  
</a>	

<br><br>

<a href="<?php echo base_url("registro/diputado/" . $lista['id_mesa']); ?>" class="btn btn-danger btn-xs" <?php echo $boton; ?>>
Votos DIPUTADOS  
</a>	


						<?php
									echo "</td>";
									echo "<td class='text-center'>" . $lista['numero_mesa'] . "</td>";
									echo "<td class='text-center'>" . $lista['numero_incritos'] . "</td>";
									
									echo "<td class='text-center'>";
									switch ($lista['estado_mesa']) {
											case 1:
													$valor = 'Abierta';
													$clase = "text-danger";
													break;
											case 2:
													$valor = 'Cerrada';
													$clase = "text-success";
													break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									
									echo "<tr>";

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
		"ordering": false,
		"pageLength": 100
	});
});
</script>