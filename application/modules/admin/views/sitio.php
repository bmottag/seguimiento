<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
			var enlace_regreso = $('#enlace_regreso').val();
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalSitio',
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
					<i class="fa fa-gear fa-fw"></i> CONFIGURACIONES - SITIOS
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
					<i class="fa fa-building-o"></i> LISTA DE SITIOS
				</div>
				<div class="panel-body">
			
					<div class="row">
						<div class="col-sm-12">
							<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="x">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Sitios
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
								<th class="text-center">Sitio</th>
								
								<th class="text-center">Editar</th>
								<th class="text-center">Contacto (Coordinador Sitio)</th>
								<th class="text-center">Asociar con Prueba / Grupo de Instrumento / Sesión </th>
								<th class="text-center">Representante</th>
								<th class="text-center">Operador</th>
								<th class="text-center">Coordinador</th>
																
								<th class="text-center">Código DANE</th>
								<th class="text-center">Dirección</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Celular</th>
								<th class="text-center">Email</th>
								<th class="text-center">Codigo Postal</th>
								<th class="text-center">Nombre Organización</th>
								
								<th class="text-center">Nombre Contacto</th>
								<th class="text-center">Cargo Contacto</th>
								<th class="text-center">Teléfono Contacto</th>
								<th class="text-center">Celular Contacto</th>
								<th class="text-center">Email Contacto</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($info as $lista):
									echo "<tr>";
									
									echo "<td>";
									echo "<strong>Sitio: </strong><br>" . $lista['nombre_sitio'];
									echo "<br><strong>Nodo o Región: </strong>" . $lista['nombre_region'];
									echo "<br><strong>Departamento: </strong>" . $lista['dpto_divipola_nombre'];
									echo "<br><strong>Municipio: </strong>" . $lista['mpio_divipola_nombre'];
									echo "</td>";
									
									echo "<td class='text-center'>";
						?>
									<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_sitio']; ?>" >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
						<?php
									echo "</td>";
									
						?>
									<td class='text-center'>
									<a href="<?php echo base_url("admin/contacto_sitio/" . $lista['id_sitio']); ?>" class="btn btn-warning btn-xs">Contacto <span class="fa fa-gears fa-fw" aria-hidden="true"></a>
						<?php

if(!$lista['contacto_nombres']){
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}
						?>		
									</td>
									
									<td class='text-center'>
									
<?php 
//busco si el sitio tiene asociadas sesiones
$ci = &get_instance();
$ci->load->model("general_model");

$arrParam = array("idSitio" => $lista["id_sitio"]);
$conteoSesiones = $this->general_model->countSesionesbySitio($arrParam);
?>
									
<a href="<?php echo base_url("admin/asociar_sesion/" . $lista['id_sitio']); ?>" class="btn btn-primary btn-xs">
Asociar  <span class="badge"><?php echo $conteoSesiones; ?></span>
</a>
<?php if($conteoSesiones==0){ echo "<p class='text-danger text-center'><strong>Falta</strong></p>"; } ?>

									</td>
									
									<td class='text-center'>
									<a href="<?php echo base_url("admin/asignar_delegado/" . $lista['id_sitio'] . "/delegado"); ?>" class="btn btn-info btn-xs">Representante <span class="fa fa-gears fa-fw" aria-hidden="true"></a>
						<?php 
if($lista['fk_id_user_delegado']){
	echo "<p class='text-primary text-center'>" . $lista['nom_delegado'] . " " . $lista['ape_delegado'] . "</br>";
	echo "C.C. " . $lista['cedula_delegado'] . "</br>";
	echo "<a href='" . base_url("admin/updateDelegado/" . $lista['id_sitio']) . "' class='text-primary text-center'>Eliminar</p>";
}else{
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}
						?>
									</td>
									
									<td class='text-center'>
						<?php 
if($lista['fk_id_user_operador']){
	echo "<p class='text-primary text-center'>" . $lista['nom_operador'] . " " . $lista['ape_operador'] . "</br>";
	echo "C.C. " . $lista['cedula_operador'] . "</br>";
}else{
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}
						?>
									</td>
									
									<td class='text-center'>
						<?php 
if($lista['fk_id_user_coordinador']){
	echo "<p class='text-primary text-center'>" . $lista['nom_coordinador'] . " " . $lista['ape_coordiandor'] . "</br>";
	echo "C.C. " . $lista['cedula_coordinador'] . "</br>";
}else{
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}
						?>
									</td>
						<?php
						
									echo "<td>" . $lista['codigo_dane'] . "</td>";
									echo "<td>" . $lista['direccion_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['telefono_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['celular_sitio'] . "</td>";
									echo "<td>" . $lista['email_sitio'] . "</td>";
									echo "<td class='text-center'>" . $lista['codigo_postal_sitio'] . "</td>";
									echo "<td>" . $lista['nombre_organizacion'] . "</td>";

									echo "<td>" . $lista['contacto_nombres'] . " " . $lista['contacto_apellidos'] . "</td>";
									echo "<td>" . $lista['contacto_cargo'] . "</td>";
									echo "<td>" . $lista['contacto_telefono'] . "</td>";
									echo "<td>" . $lista['contacto_celular'] . "</td>";
									echo "<td>" . $lista['contacto_email'] . "</td>";
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