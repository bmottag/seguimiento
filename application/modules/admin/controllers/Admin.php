<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("admin_model");
		$this->load->library("validarsesion");
    }
	
	/**
	 * Evio de correo al usuario con la contraseña
     * @since 24/5/2017
	 */
	public function email($idUsuario)
	{
			$arrParam = array("idUsuario" => $idUsuario);
			$infoUsuario = $this->admin_model->get_users($arrParam);

			$subjet = "Ingreso aplicativo - Censo Establecimientos Informales Villavicencio CEIV de la Camara de Comercio de Villavicencio CCV";				
			$user = $infoUsuario[0]["nombres_usuario"] . " " . $infoUsuario[0]["apellidos_usuario"];
			$to = $infoUsuario[0]["email"];
		
			//mensaje del correo
			$msj = "<p>Los datos para ingresar al APP del CEIV-CCV:</p>";
			$msj .= "<br><strong>Usuario: </strong>" . $infoUsuario[0]["numero_documento"];
			$msj .= "<br><strong>Contraseña: </strong>" . $infoUsuario[0]["clave"];
			$msj .= "<br><br><strong><a href='" . base_url() . "'>Enlace Aplicación </a></strong><br>";
				
			$mensaje = "<html>
						<head>
						  <title> $subjet </title>
						</head>
						<body>
							<p>Señor(a) $user:</p>
							<p>$msj</p>
							<p>Cordialmente,</p>
							<p><strong>Administrador aplicativo.</strong></p>
						</body>
						</html>";

						
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
			$cabeceras .= 'From: CEIV-CCV APP <ceiv.ccv@gmail.com>' . "\r\n";

			//enviar correo
			mail($to, $subjet, $mensaje, $cabeceras);
	}
	
	/**
	 * users List
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function users()
	{
			$userRol = $this->session->rol;
			if ($userRol != 1 ) { 
				show_error('ERROR!!! - You are in the wrong place.');	
			}

			$arrParam = array();
			$data['info'] = $this->admin_model->get_users($arrParam);

			$data["view"] = 'users';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario Usuarios
     * @since 15/12/2016
     */
    public function cargarModalUser() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idUser"] = $this->input->post("idUser");

			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_roles",
				"order" => "nombre_rol",
				"id" => "x"
			);
			$data['roles'] = $this->general_model->get_basic_search($arrParam);
			
			$arrParam = array(
				"idRol" => 2
			);
			$data['listaSupervisores'] = $this->admin_model->get_users($arrParam);
			
			if ($data["idUser"] != 'x') 
			{
				$arrParam = array(
					"idUsuario" => $data["idUser"]
				);
				$data['information'] = $this->admin_model->get_users($arrParam);
			}
			
			$this->load->view("user_modal", $data);
    }
	
	/**
	 * Update user
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function save_user()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddId');

			$msj = "Se adicionó un nuevo usuario.";
			if ($idUser != '') {
				$msj = "Se actualizó el usuario con exito.";
			}			

			$documento = $this->input->post('documento');

			$result_user = false;
			$clave = "";
			if ($idUser == '') {
				//Verify if the user already exist by the user name
				$arrParam = array(
					"column" => "numero_documento",
					"value" => $documento
				);
				$result_user = $this->admin_model->verifyUser($arrParam);
				//$clave = $this->generar_clave();
				$clave = $this->input->post('documento');
			}

			if ($result_user) {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Este número de documento ya existe en la base de datos.');
			} else {
					if ($idUsuario = $this->admin_model->saveUser($clave)) {
						$data["result"] = true;					
						$this->session->set_flashdata('retornoExito', $msj);
						
						//a los usuarios nuevos les envio correo con contraseña
						if($idUser == '') {
							$this->email($idUsuario);
						}
					} else {
						$data["result"] = "error";					
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
					}
			}

			echo json_encode($data);
    }
	
	public function generar_clave()
	{
			$key = "";
			$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			
			$length = 10;
			$max = strlen($caracteres) - 1;
			for ($i=0;$i<$length;$i++) {
				$key .= substr($caracteres, rand(0, $max), 1);
			}
			return $key;
	}
	
	/**
	 * Reset employee password
	 * Reset the password to '123456'
	 * And change the status to '0' to changue de password 
     * @since 11/1/2017
     * @author BMOTTAG
	 */
	public function resetPassword($idUser)
	{
			if ($this->admin_model->resetEmployeePassword($idUser)) {
				$this->session->set_flashdata('retornoExito', 'You have reset the Employee pasword to: 123456');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			redirect("/admin/employee/",'refresh');
	}
	
	/**
	 * Change password
     * @since 10/5/2017
	 */
	public function change_password($idUser)
	{
			if (empty($idUser)) {
				show_error('ERROR!!! - You are in the wrong place. The ID USER is missing.');
			}
						
			$arrParam = array(
				"idUsuario" => $idUser
			);
			$data['information'] = $this->admin_model->get_users($arrParam);
		
			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update user´s password
	 * @since 10/5/2017
	 */
	public function update_password()
	{
			$data = array();			
			$data["titulo"] = "ACTUALIZAR CONTRASEÑA";
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
			
			$data['linkBack'] = "admin/users/";
			$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CAMBIAR CONTRASEÑA";
			
			if($newPassword == $confirm)
			{					
					if ($this->admin_model->updatePassword()) {
						$data["msj"] = "Se actualizó la contraseña.";
						$data["msj"] .= "<br><strong>Número de documento: </strong>" . $this->input->post("hddUser");
						$data["msj"] .= "<br><strong>Contraseña: </strong>" . $passwd;
						$data["clase"] = "alert-success";
					}else{
						$data["msj"] = "<strong>Error!!!</strong> Contactarse con el administrador.";
						$data["clase"] = "alert-danger";
					}
			}else{
				//definir mensaje de error
				echo "pailas no son iguales";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
		

	
	

	
	
}