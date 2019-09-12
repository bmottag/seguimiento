<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/alerta.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalAlerta',
                data: {'identificador': oID},
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - ALERTAS
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
					<i class="fa fa-bell"></i> LISTA DE ALERTAS
				</div>
				<div class="panel-body">
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Alerta
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
								<th class="text-center">Alerta</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Incio / Fin</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Rol</th>
								<th class="text-center">Prueba / Grupo Instrumentos / Sesión</th>
								
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>";
									echo "<strong>Descripción: </strong><br>". $lista['descripcion_alerta'];
									echo "<br><strong>Mensaje: </strong><br>". $lista['mensaje_alerta'];
									echo "<p class='" . $lista['clase'] . "'><strong>Tipo Alerta: </strong>". $lista['nombre_tipo_alerta'] . "</p>";
									echo "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_alerta']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									<br><br>

<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_alerta']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>


						<?php
									echo "</td>";
									
									echo "<td>";
									echo "<strong>Inicio:</strong><br>". $lista['fecha_inicio'];
									echo "<br><strong>Fin:</strong><br>". $lista['fecha_fin'];
									echo "</td>";
									
									echo "<td class='text-center'>";
									if($lista['estado_alerta'] == 1){
										echo "<p class='text-success'><strong>Activa</strong></p>";
									}else{
										echo "<p class='text-danger'><strong>Desactiva</strong></p>";
									}
									echo "</td>";

									echo "<td class='text-center'>" . $lista['nombre_rol'] . "</td>";

									echo "<td>";
									echo "<strong>Prueba:</strong><br>". $lista['nombre_prueba'];
									echo "<br><strong>Grupo Instrumentos:</strong><br>". $lista['nombre_grupo_instrumentos'];
									echo "<br><strong>Sesión:</strong><br>". $lista['sesion_prueba'];
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
		"order": false,
		"pageLength": 25
	});
});
</script>