<a name="anclaUp"></a>

<script type="text/javascript">
	function reloadPage() {
		location.reload(true)
	}

	setInterval('reloadPage()','300000');//300 segundos
	
	
	$(document).ready(function(){
		var sonido = document.getElementById("sonido");
	});
</script>

<?php
	$userRol = $this->session->rol;
?>

<div id="page-wrapper">
	<div class="row"><br>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						DASHBOARD
<!--
<input type="button" onclick="sonido.play()" value="play">
 Audio que se reproduce cuando se activa una alerta -->						
<audio id="sonido">
	<source src="<?php echo base_url(); ?>images/notificacion.mp3"></source>
</audio>
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-success ">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<strong><?php echo $this->session->userdata("firstname"); ?></strong> <?php echo $retornoExito ?>		
			</div>
		</div>
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?> 


<!--Reporducir sonido si existe una alerta activa para el delegado -->
<?php 
if($infoAlertaInformativa || $infoAlertaNotificacion || $infoAlertaConsolidacion)
{ 
?>
<script languaje="javascript">
	sonido.play();
</script>
<?php
}
?>

		

	<div class="row">
<!--INICIO ALERTA INFORMATIVA -->
<?php 
if($infoAlertaInformativa)
{ 

		foreach ($infoAlertaInformativa as $lista):
		
		//consultar si ya el usuario dio respuesta a esta alerta
		$ci = &get_instance();
		$ci->load->model("dashboard_model");
		
		$arrParam = array("idAlerta" => $lista["id_alerta"]);
		$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
		
		if(!$existeRegistro){
?>
	
		<div class="col-lg-6">				
			<div class="panel panel-danger">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaInformativa[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">
					

						
					<div class="col-lg-12">	
						<div class="alert alert-danger ">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
					<form  name="form" id="<?php echo "form_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_informativo"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
					
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-danger"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>
		
<?php
		}
		endforeach;
				
} ?>
<!--FIN ALERTA -->


<!--INICIO ALERTA NOTIFICACION -->
<?php 
if($infoAlertaNotificacion)
{
	
		foreach ($infoAlertaNotificacion as $lista):
		
		//consultar si ya el usuario dio respuesta a esta alerta
		$ci = &get_instance();
		$ci->load->model("dashboard_model");
		
		$arrParam = array("idAlerta" => $lista["id_alerta"]);
		$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
		
		if(!$existeRegistro){
		?>
		<div class="col-lg-6">				
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaNotificacion[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">
				
<?php
$retornoError = $this->session->flashdata('retornoErrorNotificacion');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
						
					<div class="col-lg-12">	
						<div class="alert alert-warning ">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
					<form  name="form" id="<?php echo "form_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_notificacion"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						
						<div class="form-group">							
							<div class="col-sm-12">
								<label class="radio-inline">
									<input type="radio" name="acepta" id="acepta1" value=1>Si
								</label>
								<label class="radio-inline">
									<input type="radio" name="acepta" id="acepta2" value=2>No
								</label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="observacion">Observación</label>
							<div class="col-sm-12">
								<textarea id="observacion" name="observacion" placeholder="Observación"  class="form-control" rows="2"></textarea>
							</div>
						</div>
					
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnSubmit" name="btnSubmit" value="Aceptar" class="btn btn-warning"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>
				
				</div>
			</div>
		</div>
	<?php
		}
		endforeach;
} ?>
<!--FIN ALERTA -->


<!--INICIO ALERTA CONSOLIDACION -->
<?php 
if($infoAlertaConsolidacion)
{ 
		foreach ($infoAlertaConsolidacion as $lista):
		
		//consultar si ya el usuario dio respuesta a esta alerta
		$ci = &get_instance();
		$ci->load->model("dashboard_model");
		
		$arrParam = array("idAlerta" => $lista["id_alerta"]);
		$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);
		
		if(!$existeRegistro){
			
?>
	
		<div class="col-lg-6">				
			<div class="panel panel-green">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaConsolidacion[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">

<?php
$retornoError = $this->session->flashdata('retornoErrorConsolidacion');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
						
					<div class="col-lg-12">	
						<div class="alert alert-success">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
<script>
$( document ).ready( function () {
	$("#ausentes").bloquearTexto().maxlength(5);
	$("#ausentesConfirmar").bloquearTexto().maxlength(5);
});
</script>
					<form  name="formConsolidacion" id="<?php echo "formConsolidacion_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_consolidacion"); ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						
						<input type="hidden" id="citados" name="citados" value="<?php echo $lista["numero_citados"]; ?>"/>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentes">Cantidad</label>
							<div class="col-sm-12">
								<input type="text" id="ausentes" name="ausentes" class="form-control" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentesConfirmar">Confirmar cantidad</label>
							<div class="col-sm-12">
								<input type="text" id="ausentesConfirmar" name="ausentesConfirmar" class="form-control" required/>
							</div>
						</div>
											
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnConsolidacion" name="btnConsolidacion" value="Enviar" class="btn btn-success"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>

<?php
		}
		endforeach;
} ?>
<!--FIN ALERTA -->



<!--INICIO ALERTA CONSOLIDACION -->
<?php 
if($infoAlertaConsolidacionTipo4)
{ 
		foreach ($infoAlertaConsolidacionTipo4 as $lista):
		
		//consultar si ya el usuario dio respuesta a esta alerta
		$ci = &get_instance();
		$ci->load->model("dashboard_model");
		
		$arrParam = array("idAlerta" => $lista["id_alerta"]);
		$existeRegistro = $this->dashboard_model->get_registro_by($arrParam);

		if(!$existeRegistro){
			
?>
	
		<div class="col-lg-6">				
			<div class="panel panel-green">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaConsolidacionTipo4[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">

<?php
$retornoError = $this->session->flashdata('retornoErrorConsolidacion');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
						
					<div class="col-lg-12">	
						<div class="alert alert-success">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
<script>
$( document ).ready( function () {
	$("#ausentes").bloquearTexto().maxlength(5);
	$("#ausentesConfirmar").bloquearTexto().maxlength(5);
});
</script>
					<form  name="formConsolidacion" id="<?php echo "formConsolidacionTipo4_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/registro_consolidacion"); ?>">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						
						<input type="hidden" id="citados" name="citados" value="<?php echo $lista["numero_citados"]; ?>"/>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentes">Cantidad</label>
							<div class="col-sm-12">
								<input type="text" id="ausentes" name="ausentes" class="form-control" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentesConfirmar">Confirmar cantidad</label>
							<div class="col-sm-12">
								<input type="text" id="ausentesConfirmar" name="ausentesConfirmar" class="form-control" required/>
							</div>
						</div>
											
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnConsolidacion" name="btnConsolidacion" value="Enviar" class="btn btn-success"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>

<?php
		}else{
			
//si existe el registro entonces que actualice la informacion y guarde otro registro en el log
?>
	
		<div class="col-lg-6">				
			<div class="panel panel-green">
				<div class="panel-heading">
					<i class="fa fa-calendar fa-fw"></i> ALERTA - <?php echo $infoAlertaConsolidacionTipo4[0]['nombre_tipo_alerta']; ?>
				</div>
				<div class="panel-body">
				
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				Ya hay registros para esta alerta, si sigue guardando son nuevos registros.
			</div>
		</div>
	</div>

<?php
$retornoError = $this->session->flashdata('retornoErrorConsolidacion');
if ($retornoError) {
    ?>
	<div class="row">
		<div class="col-lg-12">	
			<div class="alert alert-danger ">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php echo $retornoError ?>
			</div>
		</div>
	</div>
    <?php
}
?>
						
					<div class="col-lg-12">	
						<div class="alert alert-success">
							<strong>Mensaje Alerta: </strong><?php echo $lista['mensaje_alerta']; ?><br>
							<strong>Nombre de Prueba: </strong><?php echo $lista['nombre_prueba']; ?><br>
							<strong>Grupo Instrumentos: </strong><?php echo $lista['nombre_grupo_instrumentos']; ?><br>
							<strong>Fecha: </strong><?php echo $lista['fecha']; ?><br>
							<strong>Sesión Prueba: </strong><?php echo $lista['sesion_prueba']; ?><br>
							<strong>Número de Citados: </strong><?php echo $lista['numero_citados']; ?><br>
							
					<br>
<script>
$( document ).ready( function () {
	$("#ausentes").bloquearTexto().maxlength(5);
	$("#ausentesConfirmar").bloquearTexto().maxlength(5);
});
</script>
					<form  name="formConsolidacion" id="<?php echo "formConsolidacionTipo4_" . $lista["id_alerta"]; ?>" class="form-horizontal" method="post" action="<?php echo base_url("dashboard/update_registro_consolidacion_by_delegado"); ?>">
						<input type="hidden" id="hddIdAlerta" name="hddIdAlerta" value="<?php echo $lista["id_alerta"]; ?>"/>
						<input type="hidden" id="hddIdSitioSesion" name="hddIdSitioSesion" value="<?php echo $lista["id_sitio_sesion"]; ?>"/>
						<input type="hidden" id="citados" name="citados" value="<?php echo $lista["numero_citados"]; ?>"/>
						<input type="hidden" id="idRegistro" name="idRegistro" value="<?php echo $existeRegistro[0]['id_registro']; ?>"/>					
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentes">Cantidad de ausentes</label>
							<div class="col-sm-12">
								<input type="text" id="ausentes" name="ausentes" class="form-control" required/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-12 control-label" for="ausentesConfirmar">Confirmar cantidad de ausentes</label>
							<div class="col-sm-12">
								<input type="text" id="ausentesConfirmar" name="ausentesConfirmar" class="form-control" required/>
							</div>
						</div>
											
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<input type="submit" id="btnConsolidacion" name="btnConsolidacion" value="Enviar" class="btn btn-success"/>
								</div>
							</div>
						</div>
					</form>	
							
						</div>
					</div>

				</div>
			</div>
		</div>

<?php			
		}
		endforeach;
} ?>
<!--FIN ALERTA -->



	</div>




	
<!-- INFORMACION DEL SITIO PARA EL DELEGADO SI EXISTE INFORMAION -->
<?php 
//si no esta asignado para un sitio le muestro mensaje
if(!$infoSitoDelegado){ 
	$infoSesiones = false;
?>
	<div class="alert alert-info">
		Por favor contactarse con el Encargado, usted no tiene nada asignado.
	</div>
<?php
}else{
	
	//busco si el sitio tiene asociadas sesiones
	$ci = &get_instance();
	$ci->load->model("general_model");

	$arrParam = array("idSitio" => $infoSitoDelegado[0]['id_sitio']);
	$conteoSesiones = $this->general_model->countSesionesbySitio($arrParam);
	$infoSesiones = false;
	if($conteoSesiones != 0){
		$infoSesiones = $this->general_model->get_sesiones_sitio($arrParam);
	}
?>

	<div class="alert alert-info">
		Usted esta asignado como <strong>REPRESENTANTE</strong> para el sitio:								
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Nombre Sitio: </strong><br><?php echo $infoSitoDelegado[0]['nombre_sitio']; ?>
					<br><strong>Dirección: </strong><?php echo $infoSitoDelegado[0]['direccion_sitio']; ?>
					<br><strong>Código DANE: </strong><?php echo $infoSitoDelegado[0]['codigo_dane']; ?>
					<?php if($infoSitoDelegado[0]['contacto_nombres']){ ?>
					<br><strong>Contacto: </strong><br><?php echo $infoSitoDelegado[0]['contacto_nombres'] . " " . $infoSitoDelegado[0]['contacto_apellidos']; ?>
					<br>Celular:
					<?php 
					echo "<a href='tel:".$infoSitoDelegado[0]['contacto_celular']."'>".$infoSitoDelegado[0]['contacto_celular']."</a>"; 
					} ?>
					<br><strong>Número de Sesiones: </strong><?php echo $conteoSesiones; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Nodo o Región: </strong><?php echo $infoSitoDelegado[0]['nombre_region']; ?>
					<br><strong>Departamento: </strong><?php echo $infoSitoDelegado[0]['dpto_divipola_nombre']; ?>
					<br><strong>Municipio: </strong><?php echo $infoSitoDelegado[0]['mpio_divipola_nombre']; ?>
					<br><strong>Zona: </strong><?php echo $infoSitoDelegado[0]['nombre_zona']; ?>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Representante: </strong><br>
					<?php
					if($infoSitoDelegado[0]['fk_id_user_delegado']){
						echo "C.C. " . $infoSitoDelegado[0]['cedula_delegado'] . " " . $infoSitoDelegado[0]['nom_delegado'] . " "  . $infoSitoDelegado[0]['ape_delegado'];
						echo "<br>Celular: ";						
						echo "<a href='tel:".$infoSitoDelegado[0]['celular_delegado']."'>".$infoSitoDelegado[0]['celular_delegado']."</a>"; 
					} else { echo "Falta asignar Representante.";}
					?>
					<br><strong>Operador ASD: </strong><br>
					<?php 
					if($infoSitoDelegado[0]['fk_id_user_operador']){
						echo "C.C. " . $infoSitoDelegado[0]['cedula_operador'] . " " . $infoSitoDelegado[0]['nom_operador'] . " "  . $infoSitoDelegado[0]['ape_operador'];
						echo "<br>Celular: ";
						echo "<a href='tel:".$infoSitoDelegado[0]['celular_operador']."'>".$infoSitoDelegado[0]['celular_coordinador']."</a>"; 
					} else { echo "Falta asignar Operador.";}
					?>

					<br><strong>Coordinador: </strong><br>
					<?php 
					if($infoSitoDelegado[0]['fk_id_user_coordinador']){
						echo "C.C. " . $infoSitoDelegado[0]['cedula_coordinador'] . " " . $infoSitoDelegado[0]['nom_coordinador'] . " "  . $infoSitoDelegado[0]['ape_coordiandor'];
						echo "<br>Celular: ";
						echo "<a href='tel:".$infoSitoDelegado[0]['celular_coordinador']."'>".$infoSitoDelegado[0]['celular_coordinador']."</a>"; 
					} else { echo "Falta asignar Coordinador.";}
					?>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
<!-- INFORMACION DEL SITIO PARA EL DELEGADO SI EXISTE INFORMACION -->	
	



	
	
<!--INICIO INFORMACION DE LAS SESIONES PARA EL SITIO DEL DELEGADO CONSOLIDACION -->
<?php
	if($infoSesiones){ 
?>	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info">
				
				<div class="panel-heading">
					<i class="fa fa-life-saver fa-fw"></i> Lista de Sesiones asociadas con el Sitio asignado
				</div>
				
				<div class="panel-body">
				
<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataSafety">
						<thead>
							<tr>
								<th>Sesión</th>
								<th>Fecha</th>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
								<th>Número de Citados</th>
								<th>Número de Ausentes</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoSesiones as $lista):
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
								echo "<td class='text-center'>" . $lista['numero_ausentes'] . "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
			
				</div>
			</div>
		</div>
	</div>
<?php	} ?>
<!-- FIN INFORMACION DE LAS SESIONES PARA EL SITIO DEL DELEGADO CONSOLIDACION -->


<!--INICIO RESPUESTA DEL USUARIO PARA EL SITIO EN EL QUE ESTA ASIGNADO -->
<?php
	if($infoRespuestas){ 
?>	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				
				<div class="panel-heading">
					<i class="fa fa-life-saver fa-fw"></i> Respuestas Alertas
				</div>
				
				<div class="panel-body">
				
<a class="btn btn-default btn-circle" href="#anclaUp"><i class="fa fa-arrow-up"></i> </a>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataSafety">
						<thead>
							<tr>
								<th>Alerta</th>
								<th>Respuesta</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoRespuestas as $lista):
								echo "<tr>";
									echo "<td>";
									echo "<strong>Descripción: </strong>" . $lista['descripcion_alerta'];
									echo "<br><strong>Mensaje: </strong>" . $lista['mensaje_alerta'];
									echo "<p class='" . $lista['clase'] . "'><strong>Tipo Alerta: </strong>" . $lista['nombre_tipo_alerta'] . "</p>";
									echo "<strong>Inicio Alerta: </strong>" . $lista['fecha_inicio'];
									echo "<br><strong>Fin Alerta: </strong>" . $lista['fecha_fin'];
									echo "</td>";
									
									echo "<td>";
									echo "<strong>Respuesta: </strong>";
									echo $acepta = $lista['acepta']==1?"Si":"No";
									echo "<br><strong>Ausentes: </strong>" . $lista['ausentes'];
									echo "<br><strong>Observación: </strong>" . $lista['observacion'];
									echo "<br><strong>Fecha registro: </strong>" . $lista['fecha_registro'];
									
									//si el tipo de mensaje es 4, entonces mostrar historial
									if($lista['ausentes'] = 4){
echo "<br><a href=" . base_url("dashboard/historico/delegados/" . $lista['fk_id_alerta'])  . "/" . $lista['fk_id_sitio_sesion'] . " ><strong>Historial</strong> </a>";
									}
									
									echo "</td>";
								echo "</tr>";
							endforeach;
						?>
						</tbody>
					</table>
			
				</div>
			</div>
		</div>
	</div>
<?php	} ?>
<!-- FIN RESPUESTA DEL USUARIO PARA EL SITIO EN EL QUE ESTA ASIGNADO -->
		
	
      



</div>
<!-- /#page-wrapper -->