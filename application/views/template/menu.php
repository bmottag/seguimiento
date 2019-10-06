        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				
<?php
		$userRol = $this->session->userdata("rol");
		
		if($userRol==3){ //USUARIOS OPERADOR
			$enlace = base_url("dashboard/operador");
			$titulo = 'Operador';
		}elseif($userRol==2){ //USUARIOS AUDITOR
			$enlace = base_url("dashboard/auditor");
			$titulo = 'Auditor';
		}else{
			$enlace = base_url("dashboard/admin");
			$titulo = 'Admin';
		}
?>

		<a class="navbar-brand" href="#">ELECCIONES 2019</a>
				
            </div>
            <!-- /.navbar-header -->

		


            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->	

<?php 
if($userRol!=7){//USUARIOS QUE NO SON PISA
?>
				<li>
					<a href="<?php echo $enlace; ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard <?php echo $titulo; ?></a>
				</li>

				
				

<?php 
}
?>
				
				
<?php 
if($userRol==1){ //SI es usuario ADMIN o DIRECTIVO
?>				
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-list-alt"></i> Reportes <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-messages">
			
				<li>
					<a href="<?php echo base_url("report/searchBy"); ?>"><i class="fa fa-list-alt fa-fw"></i> Información Alertas - Representantes</a>
				</li>
				
				<li class="divider"></li>

				<li>
					<a href="<?php echo base_url("public/reportico/run.php?execute_mode=MENU&project=ICFES"); ?>"><i class="fa fa-search fa-fw"></i> Ver Listados</a>
				</li>
				
				<li>
					<a href="<?php echo base_url("anulaciones/anulaciones_admin"); ?>"><i class="fa fa-list-alt fa-fw"></i> Lista de anulaciones</a>
				</li>
				
			</ul>
		</li>
<?php 
}
?>
				
				
				
				
				
				
				
				
				
				
				
				
<?php 
if($userRol==1){ //ADMIN
?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear"></i> Configuraciones <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
				
						<li>
							<a href="<?php echo base_url("admin/users"); ?>"><i class="fa fa-users fa-fw"></i> Usuarios</a>
						</li>
						
						<li class="divider"></li>
						
						<li>
							<a href="<?php echo base_url("admin/parametros"); ?>"><i class="fa fa-gear fa-fw"></i> Parametros</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("admin/puestos"); ?>"><i class="fa fa-building fa-fw"></i> Puestos de votación</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("admin/partidos"); ?>"><i class="fa fa-flag fa-fw"></i> Partidos</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("admin/candidato/1"); ?>"><i class="fa fa-users fa-fw"></i> Candidatos para presidente</a>
						</li>

						<li>
							<a href="<?php echo base_url("admin/candidato/3"); ?>"><i class="fa fa-users fa-fw"></i> Candidatos para diputado</a>
						</li>
						
						<li class="divider"></li>
						
						<li>
							<a href="<?php echo base_url("admin/asignar_operador"); ?>"><i class="fa fa-building-o fa-fw"></i> Operadores por municipio</a>
						</li>
												
						<li class="divider"></li>
						
						<li>
							<a href="<?php echo base_url("admin/alertas"); ?>"><i class="fa fa-bell fa-fw"></i> Alertas</a>
						</li>
						
						
						<li class="divider"></li>
						
						<li>
							<a href="<?php echo base_url("admin/atencion_eliminar"); ?>"><i class="fa fa-ban fa-fw"></i> Eiminar registros BD</a>
						</li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
<?php
}
?>


<?php 
if($userRol==6){//OPERADOR
?>

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-list-alt"></i> Reportes <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-messages">
					
						<li>
							<a href="<?php echo base_url("report/searchByCoordinador"); ?>"><i class="fa fa-list-alt fa-fw"></i> Información Alertas - Representantes</a>
						</li>
						
					</ul>
				</li>
<?php
}
?>


				<li>
					<a href="<?php echo base_url("menu/salir"); ?>"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
				</li>
				
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>