<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/control.js"); ?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'encuesta/cargarModalControl',
                data: {'idFormulario': oID, 'idControl': 'x'},
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
				url: base_url + 'encuesta/cargarModalControl',
                data: {'idFormulario': '', 'idControl': oID},
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
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<a class="btn btn-success" href=" <?php echo base_url().'encuesta/form_home/' . $idFormulario; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-users"></i> RESULTADO ENCUESTA
				</div>
				<div class="panel-body">

	<div class="col-lg-12">
		<div class="alert alert-danger ">
			<span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span>
			Relacione a continuación el resultado de la encuesta.
		</div>
	</div>
				
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $idFormulario; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Resultado Encuesta
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
								<th class="text-center">Editar</th>
								<th class="text-center">No. formulario</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Fecha registro</th>
								<th class="text-center">Resultado encuesta</th>
								<th class="text-center">Observaciones</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_control']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
									
<?php 
$userRol = $this->session->rol;
if($userRol!=3){ //los encuestadores no pueden borrar manazanas
?>
<br><br>
<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_control']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>								
<?php } ?>
						<?php
									echo "</td>";
									echo "<td class='text-right'>" . $lista['fk_id_formulario'] . "</td>";
									echo "<td>" . $lista['fecha'] . "</td>";
									echo "<td>" . $lista['fecha_registro'] . "</td>";
									echo "<td>";

									switch ($lista['resultado_encuesta']) {
										case "EC":
											echo "Encuesta completa";
											break;
										case "EI":
											echo "Encuesta incompleta";
											break;
										case "R":
											echo "Rechazo";
											break;
										case "FU":
											echo "Fuera de universo";
											break;
									}
									
									echo "</td>";
									echo "<td>" . $lista['observaciones'] . "</td>";
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