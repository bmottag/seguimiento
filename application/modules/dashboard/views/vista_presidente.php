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
											echo "<strong>Auditor: </strong>" . $listaEncargado['nombres_usuario'] . ' ' . $listaEncargado['apellidos_usuario'] . " - <strong>Celular: </strong><a href='tel:" . $listaEncargado['celular'] . "'>" . $listaEncargado['celular'] . "</a>";
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
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-home"></i> Número de votos de los candidatos para presidente
				</div>
				<div class="panel-body">

				<?php
					if($info){
				?>			
				
					<div class="row">
						<div class="col-lg-6">				
							<div class="row">	
								<div class="col-lg-12">	
								
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
								
<form  name="votos_presidente" id="votos_presidente" method="post" action="<?php echo base_url("registro/guardar_votos/presidente"); ?>">
		<input type="hidden" id="hddIdPuesto" name="hddIdPuesto" value="<?php echo $infoPuesto[0]['id_puesto_votacion']; ?>"/>
		<input type="hidden" id="hddIdMesa" name="hddIdMesa" value="<?php echo $infoMesa[0]['id_mesa']; ?>"/>
		<input type="hidden" id="hddNumeroPersonasHabilitadas" name="hddNumeroPersonasHabilitadas" value="<?php echo $infoMesa[0]['personas_habilitadas']; ?>"/>
							
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Sigla partido</th>
								<th class="text-center">Nombre candidato</th>
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
									echo "<td>" . $lista['nombre_completo_candidato'] . "</td>";

						?>
									
						<td>

						<input type="hidden" id="hddIdCandidato" name="hddIdCandidato[]" value="<?php echo $lista['id_candidato']; ?>"/>
						<input type="hidden" id="hddIdRegistroVoto" name="hddIdRegistroVoto[]" value="<?php echo $votosCandidato?$votosCandidato[0]["id_registro_votos"]:""; ?>"/>										
						
						<input type="number" id="numeroVotos" name="numeroVotos[]" class="form-control" placeholder="Número de votos" value="<?php echo $votosCandidato?$votosCandidato[0]["numero_votos"]:""; ?>" required >
		
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
									<div class="alert alert-info">
										<div class="row" align="center">
											<div style="width:90%;" align="center">
											
												<button type="submit" class="btn btn-primary" id="btnSubmit2" name="btnSubmit2" >
													Guardar número de votos <span class="glyphicon glyphicon-edit" aria-hidden="true">
												</button>

</form>
												<br>
												
												<?php
												if($infoMesa[0]["foto_acta_presidente"]){ 
													$estiloFoto = "btn btn-primary";
													$textoFoto = "Foto acta escrutinio";
												?>
												
		<a href='<?php echo base_url($infoMesa[0]["foto_acta_presidente"]); ?>' target="_blank">
			<img src="<?php echo base_url($infoMesa[0]["foto_acta_presidente"]); ?>" class="img-rounded" width="540" height="450" />
		</a>
												<?php }else{ 
														echo "Falta foto acta escrutinio";
													} 
												?>													
												
												<?php 
													if($infoMesa[0]['estado_presidente'] == 2){
												?>
										
														<br><br>			
				<a href="<?php echo base_url().'registro/foto_acta/' . $infoMesa[0]['id_mesa'] . '/presidente'; ?>" class="<?php echo $estiloFoto; ?>" > <?php echo $textoFoto; ?> <span class="glyphicon glyphicon-picture" aria-hidden="true"></span></a> 
														
												<?php
														//si ya estan los votos y esta la foto muestro boton para cerrar votos para presidente
														if($infoMesa[0]["foto_acta_presidente"]){ 
												?>
														<br><br>
				<a href="<?php echo base_url().'registro/cerrar_mesa_corporacion/' . $infoMesa[0]['id_mesa'] . '/presidente'; ?>" class="btn btn-danger" > Cerrar escrutinio para presidente <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></a> 
															
												<?php
														
														}
														
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