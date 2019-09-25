<div id="page-wrapper">
	<br>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-building"></i> Información puesto de votación
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
						<div class="col-lg-4">				
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-info">
										<strong>No. puesto de votación: </strong>
										<?php echo $infoPuesto[0]['numero_puesto_votacion']; ?>
										<br><strong>Puesto de votación: </strong><br>
										<?php echo $infoPuesto[0]['nombre_puesto_votacion']; ?>
										<br><strong>Circunscripción: </strong>
										<?php echo $infoPuesto[0]['circunscripcion']; ?>
									</div>
								</div>
							</div>	
						</div>
						
						<div class="col-lg-4">				
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-info">
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
									<div class="alert alert-info">
										<?php 
										foreach ($infoEncargado as $listaEncargado):
											echo "<strong>Auditor: </strong>" . $listaEncargado['nombres_usuario'] . ' ' . $listaEncargado['apellidos_usuario'] . ' - <strong>Celular: </strong>' . $listaEncargado['celular'];
											echo "<br>";
										endforeach;
										?>
										<br><strong>No. mesa: </strong>
										<?php echo $infoMesa[0]['numero_mesa']; ?>
										<br><strong>No. personas habilitadas para votar: </strong>
										<?php echo $infoMesa[0]['personas_habilitadas']; ?>
									</div>
								</div>
							</div>	
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-home"></i> Número de votos de los candidatos para diputado
				</div>
				<div class="panel-body">

				<?php
					if($info){
				?>			
				
					<div class="row">
						<div class="col-lg-6">				
							<div class="row">	
								<div class="col-lg-12">	
								
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Sigla partido</th>
								<th class="text-center">Número de votos</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							//cargo modelos
							$ci = &get_instance();
							$ci->load->model("general_model");
						
							foreach ($info as $lista):
							
									//Buscar votos para esta MESA y el CANDIDATO
									$arrParam = array(
										"idMesa" => $infoMesa[0]['id_mesa'],
										"idCandidato" => $lista['id_candidato']
									);
									$votosCandidato = $this->general_model->get_votos_by_candidato($arrParam);
																
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['sigla'] . "</td>";
						?>
									
						<td>
										
						<input type="text" id="numeroVotos" name="numeroVotos[]" class="form-control" placeholder="Número de votos" value="<?php echo $votosCandidato?$votosCandidato[0]["numero_votos"]:""; ?>" disabled >
		
						</td>
												
						<?php		
									echo "<tr>";

							endforeach;
						?>
						</tbody>
					</table>


								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="row">	
								<div class="col-lg-12">	
									<div class="alert alert-danger">
										<div class="row" align="center">
											<div style="width:90%;" align="center">
												<?php
												if($infoMesa[0]["foto_acta_diputado"]){ 
													$estiloFoto = "btn btn-primary";
													$textoFoto = "Foto acta escrutinio";
												?>
												
		<a href='<?php echo base_url($infoMesa[0]["foto_acta_diputado"]); ?>' target="_blank">
			<img src="<?php echo base_url($infoMesa[0]["foto_acta_diputado"]); ?>" class="img-rounded" width="540" height="450" />
		</a>
												<?php }else{ 
														echo "Falta foto acta escrutinio";
													} 
												?>													
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


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