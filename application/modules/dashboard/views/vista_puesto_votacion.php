<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD OPERADOR
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?> 

	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<i class="fa fa-building"></i> Información puesto de votación
				</div>
				<div class="panel-body">
				
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
								</div>
							</div>
						</div>	
					</div>
				
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<i class="fa fa-home"></i> Número de votos de los candidatos para presidente
				</div>
				<div class="panel-body">

				<?php
					if($candidatosPresidente){
				?>			
				
					<div class="row">
						<div class="col-lg-12">				
							<div class="row">	
								<div class="col-lg-12">	
							
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
										
											foreach ($candidatosPresidente as $lista):
																											
													echo "<tr>";
													echo "<td class='text-center'>" . $lista['sigla'] . "</td>";
													echo "<td>" . $lista['nombre_completo_candidato'] . "</td>";
													echo "<td class='text-center'>" . $lista['sumatoria'] . "</td>";
													echo "<tr>";

											endforeach;
										?>
										</tbody>
									</table>

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
		
		<div class="col-lg-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-home"></i> Número de votos de los candidatos para diputado
				</div>
				<div class="panel-body">

				<?php
					if($candidatosDiputado){
				?>			
				
					<div class="row">
						<div class="col-lg-12">				
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
										
											foreach ($candidatosDiputado as $lista):
																											
													echo "<tr>";
													echo "<td class='text-center'>" . $lista['sigla'] . "</td>";
													echo "<td class='text-center'>" . $lista['sumatoria'] . "</td>";
													echo "<tr>";

											endforeach;
										?>
										</tbody>
									</table>

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
	

	<!-- LISTADO MESAS PARA EL AUDITOR -->
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-home fa-fw"></i> Listado de mesas de votación
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">

<?php
	if(!$infoMesas){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No tiene mesas de votación asignadas.</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Número mesa</th>
								<th class="text-center">Escrutinio presidente</th>
								<th class="text-center">Escrutinio diputado</th>
								<th class="text-center">Estado mesa</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoMesas as $lista):
								echo "<tr>";								
								echo "<td class='text-center'>" . $lista['numero_mesa'] . "</td>";
								
///VERIFICAR SI YA SE REALIZARON LOS VOTOS 
if($lista['estado_mesa'] == 2){
	$botonPresidente = "";
	$botonDiputado = "";
	$enlacePresidente = base_url("dashboard/ver_presidente/" . $lista['id_mesa']); 
	$mensajePresidente = '<p class="text-danger"><strong>Escrutinio cerrado para presidente</strong></p>';
	
	$enlaceDiputado = base_url("dashboard/ver_diputado/" . $lista['id_mesa']); 
	$mensajeDiputado = '<p class="text-danger"><strong>Escrutinio cerrado para diputado</strong></p>';
}else{
	
	$botonPresidente = "";
	$botonDiputado = "";
	$enlacePresidente = base_url("dashboard/ver_presidente/" . $lista['id_mesa']); 
	$mensajePresidente = '<p class="text-danger"><strong>Escrutinio cerrado para presidente</strong></p>';
	
	$enlaceDiputado = base_url("dashboard/ver_diputado/" . $lista['id_mesa']); 
	$mensajeDiputado = '<p class="text-danger"><strong>Escrutinio cerrado para diputado</strong></p>';
	
	if($lista['estado_presidente'] == 1){
		$botonPresidente = "disabled";
		$enlacePresidente = "#"; 
		$mensajePresidente = '<p class="text-danger"><strong>No se ha guardado el escrutinio para presidente</strong></p>';
	}elseif($lista['estado_presidente'] == 2){
		$mensajePresidente = '<p class="text-danger"><strong>Escrutinio iniciado</strong></p>';
	}
		
	if($lista['estado_diputado'] == 1){
		$botonDiputado = "disabled";
		$enlaceDiputado = "#"; 
		$mensajeDiputado = '<p class="text-danger"><strong>No se ha guardado el escrutinio para diputado</strong></p>';
	}elseif($lista['estado_presidente'] == 2){
		$mensajePresidente = '<p class="text-danger"><strong>Escrutinio iniciado</strong></p>';
	}
}
								echo "<td class='text-center'>";


?>
<a href="<?php echo $enlacePresidente; ?>" class="btn btn-info btn-xs" <?php echo $botonPresidente; ?>>
Ver votos PRESIDENTE  
</a>	

<?php echo $mensajePresidente; ?>

						<?php
								echo "</td>";
								echo "<td class='text-center'>";
						?>

<a href="<?php echo $enlaceDiputado; ?>" class="btn btn-danger btn-xs" <?php echo $botonDiputado; ?>>
Ver votos DIPUTADOS  
</a>	

<?php echo $mensajeDiputado; ?>

						<?php
								echo "</td>";
								
									echo "<td class='text-center'>";
									switch ($lista['estado_mesa']) {
											case 1:
													$valor = 'Abierta';
													$clase = "text-success";
													break;
											case 2:
													$valor = 'Cerrada';
													$clase = "text-danger";
													break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
				
<?php	} ?>					
				</div>
				<!-- /.panel-body -->
			</div>
		</div>

	</div>
	<!-- LISTADO MESAS PARA EL AUDITOR -->


		



</div>
<!-- /#page-wrapper -->