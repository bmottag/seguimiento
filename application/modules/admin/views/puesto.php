<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
			var enlace_regreso = $('#enlace_regreso').val();
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalPuesto',
                data: {'identificador': oID, 'enlace_regreso': enlace_regreso},
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - PUESTOS DE VOTACIÓN
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
					<i class="fa fa-building"></i> LISTA PUESTOS DE VOTACIÓN
				</div>
				<div class="panel-body">
			
					<div class="row">
						<div class="col-sm-12">
							<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Puesto de Votación
							</button>
						</div>
					
					</div>
					<br>
					
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
				?>		<input type="hidden" id="enlace_regreso" name="enlace_regreso" value="admin/sitios"/>		
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">Número</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Departamento</th>
								<th class="text-center">Municipio</th>
								<th class="text-center">Localidad</th>
								<th class="text-center">Número total mesas </th>
								<th class="text-center">Circunscripción </th>
								<th class="text-center">Enlaces</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['numero_puesto_votacion'] . "</td>";
									echo "<td>" . $lista['nombre_puesto_votacion'] . "</td>";
									echo "<td>" . $lista['nombre_departamento'] . "</td>";
									echo "<td>" . $lista['nombre_municipio'] . "</td>";
									echo "<td>";
									echo "<strong>ID: </strong>" . $lista['id_localidad'];
									echo "<br>" . $lista['nombre_localidad'];
									echo "</td>";
									
									echo "<td class='text-center'>" . $lista['total_mesas'] . "</td>";
									echo "<td>" . $lista['circunscripcion'] . "</td>";
									
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_puesto_votacion']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									<br><br>
									
<a href="<?php echo base_url("admin/mesas/" . $lista['id_puesto_votacion']); ?>" class="btn btn-primary btn-xs">
Ver  <span class="badge"><?php echo $lista['total_mesas']; ?></span>
</a>
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
		
				
<!--INICIO Modal para adicionar SITIOS -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar SITIOS -->

<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		order: false,
		"pageLength": 50
	});
});
</script>