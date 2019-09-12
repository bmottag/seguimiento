<a name="anclaUp"></a>

<?php
	$userRol = $this->session->rol;
?>

<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD
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







	<!-- LISTADO DE PUESTOS DE VOTACION -->
	<div class="row">
			
		<div class="col-lg-12">
			<div class="panel panel-primary">
			
				<div class="panel-heading">
					<i class="fa fa-home fa-fw"></i> Lista puestos de votación
				</div>
				
				<!-- /.panel-heading -->
				<div class="panel-body">
					<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>

<?php
	if(!$infoPuestos){ 
		echo "<a href='#' class='btn btn-danger btn-block'>No hay Puestos de Votación</a>";
	}else{
?>						
					
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Geolocalización</th>
								<th>Número de mesas</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							$i=0;
							foreach ($infoPuestos as $lista):
								$i++;
								echo "<tr>";								
								echo "<td >" . $i . "</td>";
								echo "<td >" . strtoupper($lista['nombre_puesto_votacion']) . "</td>";
								echo "<td >" . strtoupper($lista['geolocalizacion']) . "</td>";
								echo "<td >";
echo "<a href='" . base_url('report/mostrarSesiones/' . $lista['id_puesto_votacion'] . '/admin' ) . "'>" . $lista['numero_mesas'] . "</a>";
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
	<!-- LISTADO DE PUESTO DE VOTACION -->




</div>
<!-- /#page-wrapper -->