<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/grupo_instrumentos.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalGrupoInstrumentos',
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - GRUPO DE INSTRUMENTOS
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
					<i class="fa fa-bullseye"></i> LISTA GRUPO DE INSTRUMENTOS
				</div>
				<div class="panel-body">
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Grupo de Instrumentos
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
								<th class="text-center">Prueba</th>
								<th class="text-center">Grupo de Instrumentos</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Asociar Sesión</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['nombre_prueba'] . "</td>";
									echo "<td>" . $lista['nombre_grupo_instrumentos'] . "</td>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_grupo_instrumentos']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									
									<br><br>

<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_grupo_instrumentos']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>									
						<?php
									echo "</td>";
									echo "<td class='text-center'>" . $lista['fecha'] . "</td>";

						?>
						
						
						
						
						
						
									<td class='text-center'>
									
<?php 
//busco si el sitio tiene asociadas sesiones
$ci = &get_instance();
$ci->load->model("general_model");

$arrParam = array("idGrupoInstrumentos" => $lista["id_grupo_instrumentos"]);
$conteoSesiones = $this->general_model->countSesionesbyGrupo($arrParam);
?>
									
<a href="<?php echo base_url("admin/sesiones/" . $lista['id_grupo_instrumentos']); ?>" class="btn btn-primary btn-xs">
Asociar  <span class="badge"><?php echo $conteoSesiones; ?></span>
</a>
<?php if($conteoSesiones==0){ echo "<p class='text-danger text-center'><strong>Falta</strong></p>"; } ?>

									</td>
						
						

						<?php
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