<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("registro_model");
		$this->load->helper('form');
//		$this->load->library("validarsesion");
    }
		
	/**
	 * Lista de PRESIDENTES
     * @since 12/9/2019
	 */
	public function presidente($idMesa)
	{
			$this->load->model("general_model");
			$userID = $this->session->userdata("id");
			
			//Informacion del Puesto de trabajo
			$arrParam = array('idUsuario' => $userID);
			$data['infoEncargado'] = $this->general_model->get_info_encargado_puesto($arrParam);
			
			$arrParam = array('idPuesto' => $data['infoEncargado'][0]['fk_id_puesto_votacion']);
			$data['infoPuesto'] = $this->general_model->get_puesto($arrParam);
			
			//Informacion de las mesas para el Puesto de votacion
			$arrParam = array('idMesa' => $idMesa);
			$data['infoMesa'] = $this->general_model->get_mesas($arrParam);
			
			//Listado de CANDIDATOS PRESIDENTE
			$arrParam = array('idCorporacion' => 1);//buscar solo candidatos para presidente
			$data['info'] = $this->general_model->get_candidatos($arrParam);
			
			$data["view"] = 'presidente';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar los votos de los candidatos
	 * param $corporacion: presidente o diputado, se usa para indicar a donde redireccionar despues de guardar	 
     * @since 18/9/2019
     * @author BMOTTAG
	 */
	public function guardar_votos($corporacion)
	{	
			$idMesa = $this->input->post("hddIdMesa");
			$hddNumeroPersonasHabilitadas = $this->input->post("hddNumeroPersonasHabilitadas");

			if ($conteoVotos = $this->registro_model->saveVotos()) 
			{
				$data["result"] = true;
				$this->load->model("general_model");
				
				$arrParam = array(
					"table" => "mesas",
					"primaryKey" => "id_mesa",
					"id" => $idMesa,
					"column" => "estado_" . $corporacion,
					"value" => 1
				);
				
				//si la sumatoria de votos es mayor al numero de personas habilitadas, dejo el estado de la mesa en 1
				//y le muestro mensaje de error
				if($conteoVotos > $hddNumeroPersonasHabilitadas){							
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> La sumatoria de votos NO debe ser mayor al número de personas habilitadas para esta mesa.');
						$arrParam['value'] = 1;
				}else{
						//si la sumatoria es menor del 80% del numero de personas habilitadas entonces muestro mensaje
						$porcentajeHabilitadas = $hddNumeroPersonasHabilitadas * 80 /100;
						if($conteoVotos < $porcentajeHabilitadas){
								$this->session->set_flashdata('retornoError', '<strong>ATENCIÓN!!!</strong> La sumatoria de votos es menos del 80% del número de personas habilitadas para esta mesa, por favor verificar la información.');
						}
					
						$this->session->set_flashdata('retornoExito', "Se guardó la información con éxito. Adicionar la foto del acta de escrutinio.");
						//actualizo el estado de la MESA a INICIADA(2) para mostrar el boton para subir la foto del acta de escrutinio
						$arrParam['value'] = 2;
				}
				$this->general_model->updateRecord($arrParam);
								
				//actualizo el conteo de votos de la MESA para la corporacion
				$arrParam = array(
					"table" => "mesas",
					"primaryKey" => "id_mesa",
					"id" => $idMesa,
					"column" => "sumatoria_votos_" . $corporacion,
					"value" => $conteoVotos
				);
				$this->general_model->updateRecord($arrParam);
								
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			//dependiendo del ROL hago el redirecionamiento
			$userRol = $this->session->userdata("rol");
			if($userRol==1){//vista para ADMINISTRADOR
				
			}elseif($userRol==2){//vista para AUDITOR
				redirect(base_url('registro/' . $corporacion . '/' . $idMesa), 'refresh');
			}elseif($userRol==3){//vista para OPERADOR
				redirect(base_url('dashboard/ver_' . $corporacion . '/' . $idMesa), 'refresh');
			}else{
				redirect("/dashboard/admin","location",301);
			}
			
	}
	
	/**
	 * Lista de DIPUTADOS
     * @since 12/9/2019
	 */
	public function diputado($idMesa)
	{
			$this->load->model("general_model");
			$userID = $this->session->userdata("id");
			
			//Informacion del Puesto de trabajo
			$arrParam = array('idUsuario' => $userID);
			$data['infoEncargado'] = $this->general_model->get_info_encargado_puesto($arrParam);
			
			$arrParam = array('idPuesto' => $data['infoEncargado'][0]['fk_id_puesto_votacion']);
			$data['infoPuesto'] = $this->general_model->get_puesto($arrParam);
			
			//Informacion de las mesas para el Puesto de votacion
			$arrParam = array('idMesa' => $idMesa);
			$data['infoMesa'] = $this->general_model->get_mesas($arrParam);
			
			//Listado de CANDIDATOS DIPUTADO
			$arrParam = array('idCorporacion' => 3);//buscar solo candidatos para DIPUTADO
			$data['info'] = $this->general_model->get_candidatos($arrParam);
									
			$data["view"] = 'diputado';
			$this->load->view("layout", $data);
	}

	/**
	 * Acta de escrutinio
	 * param $corporacion: presidente o diputado, se usa para saber si es para presidente o diputado
     * @since 21/9/2019
     * @author BMOTTAG
	 */
	public function foto_acta($idMesa, $corporacion, $error = '')
	{
			$this->load->model("general_model");
			$userID = $this->session->userdata("id");
			
			//dependiendo del ROL hago el redirecionamiento
			$userRol = $this->session->userdata("rol");
			if($userRol==1){//vista para ADMINISTRADOR
				
			}elseif($userRol==2){//vista para AUDITOR
				$data['linkBack'] = "registro/" . $corporacion . "/" . $idMesa;
			}elseif($userRol==3){//vista para OPERADOR
				$data['linkBack'] = "dashboard/ver_presidente/" . $idMesa;
			}else{

			}
			
			$data['corporacion'] = $corporacion;
			
			//Informacion de las mesas para el Puesto de votacion
			$arrParam = array('idMesa' => $idMesa);
			$data['infoMesa'] = $this->general_model->get_mesas($arrParam);

			//Informacion del Puesto
			$arrParam = array('idPuesto' => $data['infoMesa'][0]['fk_puesto_votacion_mesas']);
			$data['infoPuesto'] = $this->general_model->get_puesto($arrParam);

			$data['infoEncargado'] = $this->general_model->get_info_encargado_puesto($arrParam);

			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = 'form_imagen';
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload_foto() 
	{
			$config['upload_path'] = './images/actas/';
			$config['overwrite'] = true;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5000';
			$config['max_width'] = '3024';
			$config['max_height'] = '3008';
			$idMesa = $this->input->post("hddIdMesa");
			$corporacion = $this->input->post("hddCorporacion");//se usa para saber si la imagen es de presidente o de diputado
			$config['file_name'] = $idMesa . "_" . $corporacion;

			$this->load->library('upload', $config);
			//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
			if (!$this->upload->do_upload()) {
				$error = $this->upload->display_errors();
				$this->foto_acta($idMesa,$corporacion,$error);
			} else {
				$file_info = $this->upload->data();//subimos la imagen
				
				$data = array('upload_data' => $this->upload->data());
				$imagen = $file_info['file_name'];
				$path = "images/actas/" . $imagen;
				
				//guardo la ruta de la foto en la tabla de MESAS					
				$this->load->model("general_model");	
				$arrParam = array(
					"table" => "mesas",
					"primaryKey" => "id_mesa",
					"id" => $idMesa,
					"column" => "foto_acta_" . $corporacion,
					"value" => $path
				);
				if ($this->general_model->updateRecord($arrParam))
				{					
					$this->session->set_flashdata('retornoExito', 'Se guardó la foto del acta escrutinio con éxito.');
				}else{
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
				}
											
				//dependiendo del ROL hago el redirecionamiento
				$userRol = $this->session->userdata("rol");
				if($userRol==1){//vista para ADMINISTRADOR
					
				}elseif($userRol==2){//vista para AUDITOR
					redirect(base_url('registro/' . $corporacion . '/' . $idMesa), 'refresh');
				}elseif($userRol==3){//vista para OPERADOR
					redirect(base_url('dashboard/ver_' . $corporacion . '/' . $idMesa), 'refresh');
				}else{
					redirect("/dashboard/admin","location",301);
				}
				
			}
    }
	
	/**
	 * Signatureo
	 * param $idMesa: llave principal mesa
	 * param $corporacion: presidente o diputado
     * @since 22/9/2019
     * @author BMOTTAG
	 */
	public function cerrar_mesa_corporacion($idMesa, $corporacion)
	{
			if (empty($idMesa) || empty($corporacion) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
					
					
			//dependiendo del ROL hago el redirecionamiento
			$userRol = $this->session->userdata("rol");
			if($userRol==1){//vista para ADMINISTRADOR
				
			}elseif($userRol==2){//vista para AUDITOR
				$data['linkBack'] = "dashboard/auditor";
			}elseif($userRol==3){//vista para OPERADOR
				$data['linkBack'] = "dashboard/operador";
			}else{
				redirect("/dashboard/admin","location",301);
			}
			
			$this->load->model("general_model");			
			
			$arrParam = array(
				"table" => "mesas",
				"primaryKey" => "id_mesa",
				"id" => $idMesa,
				"column" => "estado_" . $corporacion,
				"value" => 3
			);
			
			$data['titulo'] = "<i class='fa fa-times-circle'></i> Cerrar escrutinio para " . $corporacion;
			if ($this->general_model->updateRecord($arrParam)) 
			{
				//Informacion de la mesa
				$arrParam = array('idMesa' => $idMesa);
				$infoMesa = $this->general_model->get_mesas($arrParam);
				
				$arrParam = array('idPuesto' => $infoMesa[0]['fk_puesto_votacion_mesas']);
				$infoPuesto = $this->general_model->get_puesto($arrParam);
				
				//si el estado de presidente y estado de diputados esta cerrado entonces cierro la mesa
				if($infoMesa[0]['estado_presidente'] == 3 && $infoMesa[0]['estado_diputado'] == 3)
				{
						$arrParam = array(
							"table" => "mesas",
							"primaryKey" => "id_mesa",
							"id" => $idMesa,
							"column" => "estado_mesa",
							"value" => 2
						);
						$this->general_model->updateRecord($arrParam);
				}
			
				$data['clase'] = "alert-success";
				$data['msj'] = "Se cerró el escrutinio para " . $corporacion . ".";	
				$data['msj'] .= "<br><br><strong>No. puesto de votación: </strong>" . $infoPuesto[0]['numero_puesto_votacion'];
				$data['msj'] .= "<br><strong>Puesto de votación: </strong>" . $infoPuesto[0]['nombre_puesto_votacion'];
				$data['msj'] .= "<br><strong>Circunscripción: </strong>" . $infoPuesto[0]['circunscripcion'];
				$data['msj'] .= "<br><strong>Departamento: </strong>" . $infoPuesto[0]['nombre_departamento'];
				$data['msj'] .= "<br><strong>Municipio: </strong>" . $infoPuesto[0]['nombre_municipio'];
				$data['msj'] .= "<br><strong>Id localidad: </strong>" . $infoPuesto[0]['id_localidad'];
				$data['msj'] .= "<br><strong>Localidad: </strong>" . $infoPuesto[0]['nombre_localidad'];
				$data['msj'] .= "<br><strong>No. mesa: </strong>" . $infoMesa[0]['numero_mesa'];
			} else {				
				$data['clase'] = "alert-danger";
				$data['msj'] = "Ask for help.";
			}
			
			$data["view"] = 'template/answer';
			$this->load->view("layout", $data);

	}

	
	
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
}