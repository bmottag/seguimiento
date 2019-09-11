<script type="text/javascript" src="<?php echo base_url("assets/js/validate/encuesta/establecimiento.js"); ?>"></script>

<script>
$(function(){ 
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'encuesta/cargarModalEstablecimiento',
                data: {'idManzana': oID, 'idEstablecimiento': 'x'},
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
				url: base_url + 'encuesta/cargarModalEstablecimiento',
                data: {'idManzana': '', 'idEstablecimiento': oID},
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
					<a class="btn btn-success" href=" <?php echo base_url().'encuesta/manzana/'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-users"></i> LISTA DE ESTABLECIMIENTO Y PROPIETARIO
				</div>
				<div class="panel-body">
				
					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-success">
										<strong>Comuna: </strong>
										<?php echo $infoManzana[0]['fk_id_comuna']; ?>
										 - <strong>Sector: </strong>
										<?php echo $infoManzana[0]['fk_id_sector']; ?>
										<br><strong>Sección: </strong>
										<?php echo $infoManzana[0]['fk_id_seccion']; ?>
										- <strong>Manzana: </strong>
										<?php echo $infoManzana[0]['fk_id_manzana']; ?>
										<br><strong>ID: </strong>
										<?php echo $infoManzana[0]['id_manzana']; ?>
										 - <strong>Barrio: </strong>
										<?php echo $infoManzana[0]['barrio']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>
<?php 
$userRol = $this->session->rol;
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
				
					<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoManzana[0]['id_manzana']; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Identificación del Establecimiento y/o Propietario
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
								<th class="text-center">No. formulario</th>
								<th class="text-center">Editar</th>
								<th class="text-center">Nombre comercial, razón social o  nombre del propietario</th>
								<th class="text-center">Dirección del establecimiento</th>
								<th class="text-center">Teléfono y/o celular del establecimiento</th>
								<th class="text-center">Tipo Documento</th>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Foto</th>
								<th class="text-center">RE</th>
								<th class="text-center">Encuestador</th>
								<th class="text-center">Supervisor</th>
								<th class="text-center">Fecha</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							//cargo modelo para consultar el ultimo registro de control de la encuesta
							$ci = &get_instance();
							$ci->load->model("encuesta_model");
						
							foreach ($info as $lista):
									echo "<tr>";
									echo "<td class='text-right'>" . $lista['id_establecimiento'] . "</td>";
									echo "<td class='text-center'>";
						?>
						
						
<?php 
$userRol = $this->session->rol;
	
	$boton = "";
	$enlace = base_url("encuesta/form_home/" . $lista['id_establecimiento']);
	if($userRol==3 && $lista['aprobacion_supervisor'] == 3){//para los ENCUESTADORES si la encuesta esta aprobada no se puede editar nada
		$boton = "disabled";
		$enlace = "#";
	}elseif($userRol==2 && $lista['aprobacion_coordinador'] == 4){//para los SUPERVISORES si la encuesta esta aprobada por el coordinador no puede editar nada
		$boton = "disabled";
		$enlace = "#";
	}
?>

<?php 
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
						
									<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $lista['id_establecimiento']; ?>" <?php echo $boton; ?> >
										Editar <span class="glyphicon glyphicon-edit" aria-hidden="true">
									</button>
<br><br>
<?php
}
?>

<a href="<?php echo $enlace; ?>" class="btn btn-warning btn-xs" <?php echo $boton; ?>>
Encuesta  
</a>

<?php 
if($userRol!=3 && $userRol!=5){ //los encuestadores, ni usuario CONSULTA pueden borrar
?>
<br><br>
<button type="button" class="btn btn-danger btn-xs" id="<?php echo $lista['id_establecimiento']; ?>" >
	Eliminar <span class="fa fa-times fa-fw" aria-hidden="true">
</button>								
<?php } ?>

						<?php
						
						
									if($lista['aprobacion_supervisor']==3) {

											
echo '<br><br><button type="button" class="btn btn-success btn-circle">AS</button>';
											
									}
									if($lista['aprobacion_coordinador']==4){
echo '  <button type="button" class="btn btn-primary btn-circle">AC</button>';
									}
						
						
						
									echo "</td>";
									echo "<td class='text-center'>" . $lista['nombre_propietario'] . "</td>";
									echo "<td class='text-center'>" . $lista['direccion'];
?>


<?php 
if($userRol!=5){ //SI es usuario diferente a consulta.
?>
	<br>
	<a href="<?php echo base_url("encuesta/geolocalizacion/" . $lista['id_establecimiento']); ?>" class="btn btn-primary btn-xs">Geolocalización</a>
<?php
}
?>
	
<?php
									echo "</td>";
									echo "<td class='text-center'>" . $lista['telefono'] . "</td>";
									echo "<td>";

									switch ($lista['tipo_documento']) {
										case 1:
											echo "NIT/RUT";
											break;
										case 2:
											echo "Cédula de ciudadanía C.C.";
											break;
										case 3:
											echo "Cédula de extranjería C.E.";
											break;
										case 4:
											echo "No tiene";
											break;
										case 5:
											echo "NS/NR";
											break;
									}
									
									echo "</td>";
									echo "<td>" . $lista['cedula'] . "</td>";
									echo "<td class='text-center'>";
																		
						//si hay una foto la muestro
						if($lista["foto_dispositivo"]){
						?>
<a href="<?php echo $lista["foto_dispositivo"]; ?>" class="btn btn-primary btn-xs">Ver</a>
						<?php }elseif($lista["foto"]){ ?>
<img src="<?php echo base_url($lista["foto"]); ?>" class="img-rounded" width="42" height="42" />
						<?php } ?>
						
<?php 
if($userRol!=5){ //SI es usuario diferente a consulta.
?>						
									<a href="<?php echo base_url("encuesta/foto/" . $lista['id_establecimiento']); ?>" class="btn btn-primary btn-xs">Foto</a>
<?php
}
?>
									
						<?php
									echo "</td>";
									
									echo "<td>";
	
	//Buscar la alertas para esta sesion y el coordinador de sesion
	$arrParam = array(
		"idFormulario" => $lista['id_establecimiento']
	);
	$lastRecordControl = $this->encuesta_model->get_last_record_control($arrParam);
									
	if($lastRecordControl){
		echo  $lastRecordControl[0]["resultado_encuesta"] . "<br>" . $lastRecordControl[0]["fecha_registro"];
	}
									echo "</td>";
									
									echo "<td>";
									echo $lista['nombres_usuario'] . " " . $lista['apellidos_usuario'];
									echo "</td>";
									
									echo "<td>";
									echo $lista['jefe'];
									echo "</td>";
									
									echo "<td class='text-center'>" . $lista['fecha_registro'] . "</td>";
									
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
		"pageLength": 50
	});
});
</script>