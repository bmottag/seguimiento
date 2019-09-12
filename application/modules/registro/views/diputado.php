<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-bullseye"></i> REGISTRO CONTEO DE VOTOS CANDIDATOS PARA DIPUTADO
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
									<div class="alert alert-danger">
										<strong>Puesto de votación: </strong>
										<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
										<br><strong>Geolocalización: </strong>
										<?php echo $infoPuesto[0]['geolocalizacion']; ?>
										<br><strong>Número de mesa: </strong>
										<?php echo $infoMesa[0]['numero_mesa']; ?>
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
								<th class="text-center">Imagen</th>
								<th class="text-center">Nombre Candidato</th>
								<th class="text-center">Número de votos</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>"
									
?>
	<button type="button" class="btn btn-danger btn-xs"  disabled >
		 <span class="glyphicon glyphicon-user" aria-hidden="true">
	</button>
<?php
									
									echo "</td>";
									echo "<td class='text-center'>" . $lista['nombre_completo_candidato'] . "</td>";
						?>
									
						<td>
				
						<input type="hidden" id="hddIdPuesto" name="hddIdPuesto" value="<?php echo $infoPuesto[0]['id_puesto_votacion']; ?>"/>
						<input type="hidden" id="hddIdMesa" name="hddIdMesa" value="<?php echo $infoMesa[0]['id_mesa']; ?>"/>

						
						<input type="text" id="rate" name="rate" class="form-control" placeholder="Número de votos" required >
		
						</td>
						
						<?php		
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