<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sitio_sesion.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalSesionesSitio',
                data: {'idSitio': oID, 'idSesionSitio': 'x'},
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
				url: base_url + 'admin/cargarModalSesionesSitio',
                data: {'idSitio': '', 'idSesionSitio': oID},
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - Asociar Sitio con Prueba / Grupo de Instrumento / Sesión
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
					<strong>Nombre Sitio: </strong><?php echo $infoSitio[0]['nombre_sitio']; ?>
					<br><strong>Dirección: </strong><?php echo $infoSitio[0]['direccion_sitio']; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Nodo o Región: </strong><?php echo $infoSitio[0]['nombre_region']; ?>
					<br><strong>Departamento: </strong><?php echo $infoSitio[0]['dpto_divipola_nombre']; ?>
					<br><strong>Municipio: </strong><?php echo $infoSitio[0]['mpio_divipola_nombre']; ?>
					<br><strong>Zona: </strong><?php echo $infoSitio[0]['nombre_zona']; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong>Representante: </strong><br>
					<?php 
					if($infoSitio[0]['fk_id_user_delegado']){
						echo "C.C. " . $infoSitio[0]['cedula_delegado'] . " " . $infoSitio[0]['nom_delegado'] . " "  . $infoSitio[0]['ape_delegado'];
					} else { echo "Falta asignar Representante.";}
					?>

					<br><strong>Coordinador: </strong><br>
					<?php 
					if($infoSitio[0]['fk_id_user_coordinador']){
						echo "C.C. " . $infoSitio[0]['cedula_coordinador'] . " " . $infoSitio[0]['nom_coordinador'] . " "  . $infoSitio[0]['ape_coordiandor'];
					} else { echo "Falta asignar Coordinador.";}
					?>
				</div>
			</div>
		</div>
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url(). 'admin/sitios'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-gears "></i> LISTA
				</div>
				<div class="panel-body">
				
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoSitio[0]['id_sitio']; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Asociar con Prueba / Grupo de Instrumento / Sesión
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
								<th class="text-center">Prueba / Grupo de Instrumentos / Sesión</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Hora Incio</th>
								<th class="text-center">Hora Fin</th>
								<th class="text-center">Citados</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>";
									echo "<strong>Prueba:</strong><br>". $lista['nombre_prueba'];
									echo "<br><strong>Grupo Instrumentos:</strong><br>". $lista['nombre_grupo_instrumentos'];
									echo "<br><strong>Sesión:</strong><br>". $lista['sesion_prueba'];
									echo "</td>";
									echo "<td class='text-center'>" . $lista['fecha'] . "</td>";
									echo "<td class='text-center'>" . $lista['hora_inicio_prueba'] . "</td>";
									echo "<td class='text-center'>" . $lista['hora_fin_prueba'] . "</td>";
									echo "<td class='text-center'>" . $lista['numero_citados'] . "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_sitio_sesion']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									<br><br>

<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_sitio_sesion']; ?>" >
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