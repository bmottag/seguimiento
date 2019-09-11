<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/manzana.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'encuesta/cargarModalManzana',
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
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<i class="fa fa-bullseye"></i> LISTA MANZANAS
				</div>
				<div class="panel-body">
				
<?php 
$userRol = $this->session->rol;
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
					<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal" id="x">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Manzana
					</button><br>
<?php
}
?>
					
					
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
								<th class="text-center">ID</th>
								<th class="text-center">Comuna</th>
								<th class="text-center">Sector</th>
								<th class="text-center">Sección</th>
								<th class="text-center">Manzana</th>
								<th class="text-center">Barrio</th>
								<th class="text-center">Encuestador</th>
								<th class="text-center">Supervisor</th>
								<th class="text-center">Fecha</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-center'>";
						?>
						
<?php 
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_manzana']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>									
									<br><br>
<?php
}
?>
									
									
<?php 
//busco si la manzana tiene asicionada establecimientos
$ci = &get_instance();
$ci->load->model("general_model");

$arrParam = array("idManzana" => $lista["id_manzana"]);
$conteoEstablecimiento = $this->general_model->countEstablecimientos($arrParam);
?>
<a href="<?php echo base_url("encuesta/establecimiento/" . $lista['id_manzana']); ?>" class="btn btn-success btn-xs">
Establecimientos  <span class="badge"><?php echo $conteoEstablecimiento; ?></span>
</a>	

<?php 
if($userRol!=3 && $userRol!=5){ //los encuestadores, ni usuario CONSULTA pueden borrar manazanas
?>
<br><br>
<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_manzana']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>								
<?php } ?>
						<?php
									echo "</td>";
									echo "<td class='text-center'>" . $lista['id_manzana'] . "</td>";
									echo "<td class='text-center'>" . $lista['fk_id_comuna'] . "</td>";
									echo "<td>" . $lista['fk_id_sector'] . "</td>";
									echo "<td>" . $lista['fk_id_seccion'] . "</td>";

									echo "<td class='text-center'>" . $lista['fk_id_manzana'] . "</td>";
									
									echo "<td class='text-center'>" . $lista['barrio'] . "</td>";
									
									echo "<td>";
									echo $lista['nombres_usuario'] . " " . $lista['apellidos_usuario'];
									echo "</td>";
									
									echo "<td>";
									echo $lista['jefe'];
									echo "</td>";
									
									echo "<td class='text-center'>" . $lista['fecha_creacion'] . "</td>";
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
		"ordering": false,
		"pageLength": 100
	});
});
</script>