<script type="text/javascript" src="<?php echo base_url("assets/js/general/say-cheese.js"); ?>"></script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> ESTABLECIMIENTO
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
					<a class="btn btn-success" href=" <?php echo base_url().'encuesta/establecimiento/' . $information[0]["fk_id_manzana"]; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
					<i class="fa fa-automobile"></i> FOTO ESTABLECIMIENTO
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
						
							<div class="row" align="center">
								<div style="width:50%;" align="center">
									<div class="alert alert-warning">
										<strong>No. Formulario: </strong>
										<?php echo $information[0]['id_establecimiento']; ?>
										<br><strong>Nombre comercial, razón social o  nombre del propietario: </strong>
										<?php echo $information[0]['nombre_propietario']; ?>
									</div>
								</div>
							</div>	
						
						</div>
					</div>
					
					
				
		<div class="col-lg-12">				
			<div class="panel panel-success">
				<div class="panel-heading">
					Tomar foto
				</div>
				<div class="panel-body">
				
				<div class="row">
					<div class="col-lg-4">	
						<div id="webcam">
						</div>
					</div>
					
					<div class="col-lg-4">	
						<div id="say-cheese-snapshot">
						</div>					
					</div>
					
					<div class="col-lg-4">	
						<img id="fotoGuardada" src="" style="display:none" />					
					</div>
				</div>

				
				<div class="row">
					<div class="col-lg-4">	
						<button type="button" class="btn btn-success btn-block" id="obturador">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tomar foto
						</button>
					</div>
					
					<div class="col-lg-4">	
						<button type="button" class="btn btn-success btn-block" id="guardarFoto">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Guardar foto
						</button>					
					</div>
				</div>

				</div>
			</div>
		</div>

				
				<br><br>

					
				
					<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("encuesta/do_upload/" . $information[0]["fk_id_manzana"]); ?>">
					<input type="hidden" id="hddId" name="hddId" value="<?php echo $idEstablecimiento; ?>"/>
					

					
						<div class="col-lg-12">				
							<div class="panel panel-info">
								<div class="panel-heading">
									Subir foto
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-4 control-label" for="hddTask">Foto</label>
										<div class="col-sm-5">
											 <input type="file" name="userfile" />
										</div>
									</div>
									
					<?php if($information[0]["foto"]){ ?>
						<div class="form-group">
							<div class="row" align="center">
								<div style="width:70%;" align="center">
									<img src="<?php echo base_url($information[0]["foto"]); ?>" class="img-rounded" alt="Foto" />
								</div>
							</div>
						</div>
					<?php } ?>
						
									<div class="form-group">
										<div class="row" align="center">
											<div style="width:50%;" align="center">
												<input type="submit" id="btnSubmit" name="btnSubmit" value="Guardar" class="btn btn-primary"/>
											</div>
										</div>
									</div>
						

									<?php if($error){ ?>
									<div class="alert alert-danger">
										<?php 
											echo "<strong>Error :</strong>";
											pr($error); 
										?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
									</div>
									<?php } ?>
									
									
									<div class="alert alert-danger">
											<strong>Nota :</strong><br>
											Formato permitido: gif - jpg - png<br>
											Tamalo máximo: 2048 KB<br>
											Ancho máximo: 1024 pixeles<br>
											Altura máxima: 1008 pixeles<br>
									</div>

								</div>
							</div>
						</div>

					</form>
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


<script>
	var img=null;
					
	var sayCheese = new SayCheese('#webcam', { 
					snapshots: true,
					width: 220,
					height: 140
	});
	
	sayCheese.start();
	
	$('#obturador').bind('click', function(e){
		sayCheese.takeSnapshot(220,140);
		return false;
	})
	
	sayCheese.on('snapshot', function(snapshot) {
		// do something with the snapshot
		img = document.createElement('img');
		
		$(img).on('load', function(){
			$('#say-cheese-snapshot').html(img);
		});
		img.src = snapshot.toDataURL('images/png');
	});
	
	$('#guardarFoto').bind('click', function(){
		var src = img.src;
		
		data = {
			src: src,
			idEstablecimiento: "<?php echo $idEstablecimiento; ?>"
		}

		$.ajax({
			url: '<?php echo base_url() ?>encuesta/ajax',
			data: data,
			type: 'post',
			success: function(respuesta){
					$('#fotoGuardada').attr('src', respuesta).show(300);
			}
		});
	});
</script>