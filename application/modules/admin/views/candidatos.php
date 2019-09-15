<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + '/admin/cargarModalCandidato',
                data: {'idCandidato': oID},
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - CANDIDATOS
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
					<i class="fa fa-users"></i> LISTA DE CANDIDATOS <?php echo $infoCorporacion[0]['corporacion']; ?>
				</div>
				<div class="panel-body">
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Candidato
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
								<th class="text-center">Nombre completo</th>
								<th class="text-center">Partido</th>
								<th class="text-center">Sigla</th>
								<th class="text-center">Número orden candidato</th>
								<th class="text-center">Número orden partido</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td>" . $lista['nombre_completo_candidato'] . "</td>";
									echo "<td>" . $lista['nombre_partido'] . "</td>";
									echo "<td class='text-center'>" . $lista['sigla'] . "</td>";
									echo "<td class='text-center'>" . $lista['numero_orden_candidato'] . "</td>";
									echo "<td class='text-center'>" . $lista['numero_orden_partido'] . "</td>";
									
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_candidato']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";
									
									echo "</tr>";
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
		"order": [[ 0, "asc" ]],
		"pageLength": 25
	});
});
</script>