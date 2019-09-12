<script type="text/javascript" src="<?php echo base_url("assets/js/validate/ausentes.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> LISTA EXAMINANDOS
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
					<i class="fa fa-star"></i> SELECCIONAR LOS AUSENTES
				</div>
				<div class="panel-body">

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
					if($infoExaminandos){
				?>
			<form  name="form" id="form" class="form-horizontal" method="post" >
				<input type="hidden" id="hddCodigoDane" name="hddCodigoDane" value="<?php echo $codigoDane; ?>"/>
				<input type="hidden" id="hddIdSesion" name="hddIdSesion" value="<?php echo $idSesion; ?>"/>
				
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
						<thead>
							<tr>
								<th class="text-center">SNP</th>
								<th class="text-center">No. Documento</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Ausente</th>
							</tr>
						</thead>
						<tbody>							
						<?php
							foreach ($infoExaminandos as $lista):
									echo "<tr>";
									echo "<td class='text-center'>" . $lista['snp'] . "</td>";
									echo "<td class='text-center'>" . $lista['documento'] . "</td>";
									echo "<td >" . $lista['nombre'] . "</td>";
									echo "<td class='text-center'>";
                                $data = array(
                                    'name' => 'ausentes[]',
                                    'id' => 'ausentes',
                                    'value' => $lista['id_examinando'],
                                    'checked' => $lista['ausente'],
                                    'style' => 'margin:10px'
                                );
                                echo form_checkbox($data);
									echo "</td>";

							endforeach;
						?>
						</tbody>
					</table>
					
					<div class="form-group">							
						<div class="row" align="center">
							<div style="width:50%;" align="center">
								 <input type="button" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row" align="center">
							<div style="width:80%;" align="center">
								<div id="div_load" style="display:none">		
									<div class="progress progress-striped active">
										<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
											<span class="sr-only">45% completado</span>
										</div>
									</div>
								</div>
								<div id="div_error" style="display:none">			
									<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
								</div>
							</div>
						</div>
					</div>						
					
				</form>
					
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
		
				
<!-- Tables -->
<script>
$(document).ready(function() {
	$('#dataTables').DataTable({
		responsive: true,
		"pageLength": 100,
		"order": [[ 2, "asc" ]]
	});
});
</script>