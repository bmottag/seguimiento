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
if($userRol==2 || $userRol==1){ //SI es usuario ADMIN o DIRECTIVO
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
							<a href="<?php echo base_url("admin/alertas"); ?>"><i class="fa fa-bell fa-fw"></i> Alertas</a>
						</li>
						
						
						<li class="divider"></li>
						
						<li>
							<a href="<?php echo base_url("admin/param_email"); ?>"><i class="fa fa-ban fa-fw"></i> Email</a>
						</li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
<?php
}
?>


<?php 
if($userRol==4){ //ROL DELEGADO
?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-warning"></i> Novedades <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
				
						<li>
							<a href="<?php echo base_url("anulaciones"); ?>"><i class="fa fa-legal fa-fw"></i> Anulaciones</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/cambio_cuadernillo"); ?>"><i class="fa fa-bug fa-fw"></i> Cambio de cuadernillo</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/holgura"); ?>"><i class="fa fa-download fa-fw"></i> Holguras</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/otras"); ?>"><i class="fa fa-fire fa-fw"></i> Otras novedades</a>
						</li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
<?php
}
?>


<?php 
if($userRol==3){//COORDINADOR 
?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-warning"></i> Novedades <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
				
						<li>
							<a href="<?php echo base_url("anulaciones/anulaciones_coordinador"); ?>"><i class="fa fa-legal fa-fw"></i> Lista Anulaciones</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/cambio_cuadernillo_coordinador"); ?>"><i class="fa fa-bug fa-fw"></i> Lista Cambio de Cuadernillo</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/holgura_coordinador"); ?>"><i class="fa fa-download fa-fw"></i> Lista Holguras</a>
						</li>
						
						<li>
							<a href="<?php echo base_url("novedades/otra_coordinador"); ?>"><i class="fa fa-fire fa-fw"></i> Lista otras novedades</a>
						</li>

                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
				
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