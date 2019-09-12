<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/sesiones.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalSesiones',
                data: {'idGrupo': oID, 'idSesion': 'x'},
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
				url: base_url + 'admin/cargarModalSesiones',
                data: {'idGrupo': '', 'idSesion': oID},
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - SESIONES
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
					<a class="btn btn-success" href=" <?php echo base_url(). 'admin/grupo_instrumentos'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-gears "></i> LISTA DE SESIONES
				</div>
				<div class="panel-body">
				
					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-success">
										<strong>GRUPO DE INSTRUMENTOS: </strong>
										<?php echo $infoGrupo[0]['nombre_grupo_instrumentos']; ?>
										<br><strong>PRUEBA: </strong>
										<?php echo $infoGrupo[0]['nombre_prueba']; ?>
										<br><strong>FECHA: </strong>
										<?php echo $infoGrupo[0]['fecha']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>
				
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoGrupo[0]['id_grupo_instrumentos']; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Sesiones
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
								<th class="text-center">ID Sesión</th>
								<th class="text-center">Sesión</th>
								<th class="text-center">Hora Inicio</th>
								<th class="text-center">Hora Fin</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center' width='20'>" . $lista['id_sesion'] . "</td>";
									echo "<td>" . $lista['sesion_prueba'] . "</td>";
									echo "<td class='text-center'>" . $lista['hora_inicio_prueba'] . "</td>";
									echo "<td class='text-center'>" . $lista['hora_fin_prueba'] . "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_sesion']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									
									<br><br>

<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_sesion']; ?>" >
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