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
		
		if($userRol==4){ //USUARIOS DELEGADOS
			$enlace = base_url("dashboard/delegados");
			$titulo = 'Representante';
		}elseif($userRol==6){ //USUARIOS OPERADOR
			$enlace = base_url("dashboard/operador");
			$titulo = 'Operador';
		}elseif($userRol==3){ //USUARIOS DELEGADOS
			$enlace = base_url("dashboard/coordinador");
			$titulo = 'Coordinador';
		}elseif($userRol==2){ //USUARIOS DIRECTIVO
			$enlace = base_url("dashboard/directivo");
			$titulo = 'Directivo';
		}else{
			$enlace = base_url("dashboard/admin");
			$titulo = 'Admin';
		}
?>

		<a class="navbar-brand" href="#">CEIV-CCV</a>
				
            </div>
            <!-- /.navbar-header -->

		


            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->	
				
				

				<li>
					<a href="<?php echo base_url("encuesta/manzana"); ?>"><i class="fa fa-user fa-fw"></i> <?php echo $this->session->firstname; ?></a>
				</li>
				
				<li>
					<a href="<?php echo base_url("encuesta/manzana"); ?>"><i class="fa fa-pencil-square-o fa-fw"></i> Inicio</a>
				</li>


				<li>
					<a href="<?php echo base_url("busqueda"); ?>"><i class="fa fa-bar-chart-o fa-fw"></i> Buscar</a>
				</li>
<?php 
if($userRol!=5){ //SI es usuario diferente a consulta
?>				
				<li>
					<a href="<?php echo base_url("reemplazo"); ?>"><i class="fa fa-retweet fa-fw"></i> Reemplazos</a>
				</li>
<?php 
}
?>
				

				
				
<?php 
if($userRol!=3){ //SI es usuario diferente a encuestador
?>

				<li>
				<!-- 	<a href="https://www.ceiv-ccv.com/public/reportico/run.php?execute_mode=EXECUTE&project=CEIV-CCV&report=Encuestas.xml&target_format=CSV"><i class="fa fa-list-alt"></i> Reporte</a> -->
					<a href="https://www.ceiv-ccv.com/public/reportico/run.php?execute_mode=MENU&project=CEIV-CCV" target="_blanck"><i class="fa fa-list-alt"></i> Reporte</a>
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
						

                    </ul>
                    <!-- /.dropdown-messages -->
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