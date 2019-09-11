<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuesta extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("encuesta_model");
		$this->load->library("validarsesion");
    }
	
	/**
	 * Lista de MANZANAS
     * @since 19/9/2017
	 */
	public function manzana()
	{
			$arrParam = array();
			$data['info'] = $this->encuesta_model->get_manzanas($arrParam);
			
			$data["view"] = 'manzana';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario manzanas
     * @since 19/9/2017
     */
    public function cargarModalManzana() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");	
			
			if ($data["identificador"] != 'x') {				
				$arrParam = array(
					"idManzana" => $data["identificador"]
				);
				$data['information'] = $this->encuesta_model->get_manzanas($arrParam);
			}
			
			$this->load->view("manzana_modal", $data);
    }
	
	/**
	 * Update MANZANA
     * @since 19/9/2017
	 */
	public function save_manzana()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$identificador = $this->input->post('hddId');
			
			$msj = "Se adicionó la manzana con éxito.";
			if ($identificador != '') {
				$msj = "Se actualizó la manzana con éxito.";
			}
			
			//verificar si ya existe la manzana para ese usuario
			$result_manzana = $this->encuesta_model->verificarManzana();

			if ($result_manzana) {
				$data["result"] = "error";
				$data["mensaje"] = "La Manzana ya existe en el listado.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> La Manzana ya existe en el listado.');
			} else {
				if ($identificador = $this->encuesta_model->saveManzana()) {
					$data["result"] = true;
					$data["idRecord"] = $identificador;
					
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["idRecord"] = "";
					
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}
				
			echo json_encode($data);
    }

	/**
	 * establecimiento List
     * @since 18/9/2017
	 */
	public function establecimiento($idManzana)
	{
			$arrParam = array("idManzana" => $idManzana);
			$data['info'] = $this->encuesta_model->get_establecimientos($arrParam);
			
			$arrParam = array("idManzana" => $idManzana);
			$data['infoManzana'] = $this->encuesta_model->get_manzanas($arrParam);

			$data["view"] = 'establecimiento';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario establecimiento
     * @since 18/9/2017
     */
    public function cargarModalEstablecimiento() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idEstablecimiento"] = $this->input->post("idEstablecimiento");
			$data["idManzana"] = $this->input->post("idManzana");

			if ($data["idEstablecimiento"] != 'x') 
			{
				$arrParam = array(
					"idEstablecimiento" => $data["idEstablecimiento"]
				);
				$data['information'] = $this->encuesta_model->get_establecimientos($arrParam);
				
				$data["idManzana"] = $data['information'][0]['fk_id_manzana'];
			}
			
			$this->load->view("establecimiento_modal", $data);
    }
	
	/**
	 * Guardar establecimiento
     * @since 18/9/2017
	 */
	public function save_establecimiento()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idEstablecimiento = $this->input->post('hddId');
			$idManzana  = $this->input->post('hddIdManzana');

			$msj = "Se adicionó un nuevo establecimiento.";
			
			$bandera = true;
			
			if ($idEstablecimiento != '') {
				$msj = "Se actualizó el establecimiento con éxito.";
				
				
			//si la aprueba el supervisor, se debe validar si los formularios ya estan todos diligenciados
			
			$userRol = $this->session->userdata("rol");
			if($userRol == 2){

			if($this->input->post('estado') == 3){
				
				//busco informacion del formulario si existe
				$arrParam = array(
					"idFormulario" => $idEstablecimiento
				);				
				$information_form1 = $this->encuesta_model->get_form_administrativa($arrParam);
				$information_form2 = $this->encuesta_model->get_form_actividad_economica($arrParam);
				$information_form3 = $this->encuesta_model->get_form_criticos($arrParam);
				$information_form4 = $this->encuesta_model->get_form_financiera($arrParam);
				$information_form5 = $this->encuesta_model->get_form_servicios($arrParam);
				$information_form6 = $this->encuesta_model->get_form_formalizacion($arrParam);
				$information_form7 = $this->encuesta_model->get_last_record_control($arrParam);
				
if(!$information_form1){
		$bandera = false;//vailidacion del capitulo 1
}
				
//validaciones para saber si se debe responder capitulo 2,3,4,5,6
$banderaTerminar = false;
$banderaTerminar2 = false;
if($bandera && $information_form1 && $information_form1['estado_actual'] == 1){
	$banderaTerminar = true;
	if($information_form1['establecimiento'] == 3 || $information_form1['establecimiento'] == 4){
		$banderaTerminar = false;
	}else{
	
		if($information_form2 && $information_form2['fk_id_seccion'] != 16 && $information_form2['fk_id_seccion'] != 17 && $information_form2['fk_id_seccion'] != 18){ //validacion formulario 2
			$banderaTerminar2 = true;
			
			if($information_form2['numero_personas']>9){
				$banderaTerminar2 = false;
			}
		}
		
	}
}

//aplico la validacion 
if($banderaTerminar){
		if(!$information_form2){
			//debe responder capitulo 2
			$bandera = false;
		}
		if($bandera && $banderaTerminar2){
			if(!$information_form3 || !$information_form4 || !$information_form5){
				//debe responder capitulo 3,4,5
				$bandera = false;
			}
			
			
			//validaciones para responder el capitulo 6
			$banderaTerminar3 = false;
			if($information_form1 && $information_form1['matricula'] != 1){
				$banderaTerminar3 = true;
			}

			if($information_form1 && $information_form1['rut'] != 1){
				$banderaTerminar3 = true;
			}

			if($information_form2 && $information_form2['seguridad_social'] != 1){
				$banderaTerminar3 = true;
			}
			if($information_form4 && $information_form4['impuestos'] != 1){
				$banderaTerminar3 = true;
			}
			if($information_form4 && $information_form4['contabilidad'] != 1){
				$banderaTerminar3 = true;
			}
		
			//aplico la validacion 
			if($banderaTerminar3 && $bandera ){
				if(!$information_form6){
					//debe responder capitulo 6
					$bandera = false;
				}			
			}	
		}		
}











	
				
				
			}}
			}






			$data["idRecord"] = $idManzana;
			if($bandera){
					if ($idEstablecimiento = $this->encuesta_model->saveEstablecimiento()) {
						$data["result"] = true;					
						$this->session->set_flashdata('retornoExito', $msj);
					} else {
						$data["result"] = "error";
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
					}
			}else{
					$data["result"] = "error";
					$data["mensaje"] = "Faltan capítulos por diligenciar";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Faltan capítulos por diligenciar.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Vista con los enlaces a los capitulos del formulario
     * @since 20/9/2017
	 */
	public function form_home($idFormulario)
	{
			$arrParam = array(
				"idEstablecimiento" => $idFormulario
			);
			$data['information'] = $this->encuesta_model->get_establecimientos($arrParam);//informacion del establecimiento
			
			
			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information_form1'] = $this->encuesta_model->get_form_administrativa($arrParam);
			$data['information_form2'] = $this->encuesta_model->get_form_actividad_economica($arrParam);
			$data['information_form3'] = $this->encuesta_model->get_form_criticos($arrParam);
			$data['information_form4'] = $this->encuesta_model->get_form_financiera($arrParam);
			$data['information_form5'] = $this->encuesta_model->get_form_servicios($arrParam);
			$data['information_form6'] = $this->encuesta_model->get_form_formalizacion($arrParam);
			$data['information_form7'] = $this->encuesta_model->get_last_record_control($arrParam);

			$data['idFormulario'] = $idFormulario;
			$data["view"] = 'home';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Form administrativos
     * @since 20/9/2017
	 */
	public function form_administrativos($idFormulario)
	{
			$data['information'] = FALSE;
			
			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_administrativa($arrParam);

			if ($data['information']) { 
				$data["idFormAdministrativa"] = $data['information']['id_administrativa'];
			}else{
				$data["idFormAdministrativa"] = "";
			}

			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_administrativo';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar formulario administrativa
     * @since 21/9/2017
	 */
	public function save_form_administrativa()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idFormulario = $this->input->post('hddIdentificador');
						
			if($this->encuesta_model->add_form_administrativa()) 
			{
				//redireccionamiento del formulario
				//si se termino la encuesta lo envio al formulario de control de lo contrario lo envio al siguiente formulario
				$estado_actual =  $this->input->post('estado_actual');
				$establecimiento = $this->input->post('establecimiento');
			
				$data["redireccionamiento"] = "form_control/" . $idFormulario;
				if($estado_actual == 1){
					$data["redireccionamiento"] = "form_actividad_economica/" . $idFormulario;
					if($establecimiento == 3 || $establecimiento == 4){
						$data["redireccionamiento"] = "form_control/" . $idFormulario;
					}
				}

				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Características Generales de la Actividad Económica						
     * @since 20/9/2017
	 */
	public function form_actividad_economica($idFormulario)
	{
			$data['information'] = FALSE;
			
			$arrParam = array(
				"idEstablecimiento" => $idFormulario
			);
			$data['information_establecimiento'] = $this->encuesta_model->get_establecimientos($arrParam);//informacion del establecimiento

			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_actividad_economica($arrParam);
			
			$data['information_form1'] = $this->encuesta_model->get_form_administrativa($arrParam);	

			$data['lista_actividad_economica'] = $this->encuesta_model->get_lista_actividad_economica();				

			if ($data['information']) { 
				$data["idFormActividadEconomica"] = $data['information']['id_actividad_economica'];
			}else{
				$data["idFormActividadEconomica"] = "";
			}
			
			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_actividad_economica';
			$this->load->view("layout", $data);	
	}

	/**
	 * Guardar formulario administrativa
     * @since 21/9/2017
	 */
	public function save_form_actividad_economica()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idFormulario = $this->input->post('hddIdentificador');

			if($this->encuesta_model->add_form_actividad_economica()) 
			{
				//redireccionamiento del formulario
				//si se termino la encuesta lo envio al formulario de control de lo contrario lo envio al siguiente formulario
				$actividad =  $this->input->post('actividad');
				$numero_personas =  $this->input->post('numero_personas');
			
				$data["redireccionamiento"] = "form_control/" . $idFormulario;
				if($actividad != 16 && $actividad != 17 && $actividad != 18){
					$data["redireccionamiento"] = "form_criticos/" . $idFormulario;
					if($numero_personas > 9){
						$data["redireccionamiento"] = "form_control/" . $idFormulario;
					}
				}
				
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }

	/**
	 * Form Características Generales de la Actividad Económica						
     * @since 20/9/2017
	 */
	public function form_criticos($idFormulario)
	{
			$data['information'] = FALSE;
			
			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_criticos($arrParam);

			if ($data['information']) { 
				$data["idFormCriticos"] = $data['information']['id_criticos'];
			}else{
				$data["idFormCriticos"] = "";
			}

			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_criticos';
			$this->load->view("layout", $data);	
	}
	
	/**
	 * Guardar formulario criticos
     * @since 21/9/2017
	 */
	public function save_form_criticos()
	{			
			header('Content-Type: application/json');
			$data = array();
		
			$idFormulario = $this->input->post('hddIdentificador');
			$data["idFormulario"] = $idFormulario;

			if($this->encuesta_model->add_form_criticos()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form financiera
     * @since 20/9/2017
	 */
	public function form_financiera($idFormulario)
	{
			$data['information'] = FALSE;
			
			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_financiera($arrParam);

			if ($data['information']) { 
				$data["idFormFinanciera"] = $data['information']['id_financiera'];
			}else{
				$data["idFormFinanciera"] = "";
			}

			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_financiera';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar formulario financiera
     * @since 21/9/2017
	 */
	public function save_form_financiera()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idFormulario = $this->input->post('hddIdentificador');
			$data["idFormulario"] = $idFormulario;

			if($this->encuesta_model->add_form_financiera()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Características Generales de la Actividad Económica						
     * @since 20/9/2017
	 */
	public function form_servicios($idFormulario)
	{
			$data['information'] = FALSE;

			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_servicios($arrParam);

			if ($data['information']) { 
				$data["idFormServicios"] = $data['information']['id_servicios'];
			}else{
				$data["idFormServicios"] = "";
			}
			
			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_servicios';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar formulario administrativa
     * @since 21/9/2017
	 */
	public function save_form_servicios()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idFormulario = $this->input->post('hddIdentificador');
			$data["idFormulario"] = $idFormulario;

			if($this->encuesta_model->add_form_servicios()) 
			{
				//redireccionamiento del formulario
				//si se termino la encuesta lo envio al formulario de control de lo contrario lo envio al siguiente formulario
$data["redireccionamiento"] = "form_control/" . $idFormulario;

$arrParam = array(
	"idFormulario" => $idFormulario
);				
			
$information_form1 = $this->encuesta_model->get_form_administrativa($arrParam);
$information_form2 = $this->encuesta_model->get_form_actividad_economica($arrParam);
$information_form4 = $this->encuesta_model->get_form_financiera($arrParam);

if($information_form1 && $information_form1['matricula'] != 1){
	$data["redireccionamiento"] = "form_formalizacion/" . $idFormulario;
}
if($information_form1 && $information_form1['rut'] != 1){
	$data["redireccionamiento"] = "form_formalizacion/" . $idFormulario;
}
if($information_form2 && $information_form2['seguridad_social'] != 1){
	$data["redireccionamiento"] = "form_formalizacion/" . $idFormulario;
}
if($information_form4 && $information_form4['impuestos'] != 1){
	$data["redireccionamiento"] = "form_formalizacion/" . $idFormulario;
}
if($information_form4 && $information_form4['contabilidad'] != 1){
	$data["redireccionamiento"] = "form_formalizacion/" . $idFormulario;
}
				
				
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Formalización Empresarial (solo se aplica a informales)							
     * @since 20/9/2017
	 */
	public function form_formalizacion($idFormulario)
	{
			$data['information'] = FALSE;

			$arrParam = array(
				"idEstablecimiento" => $idFormulario
			);
			$data['information_establecimiento'] = $this->encuesta_model->get_establecimientos($arrParam);//informacion del establecimiento
						
			//busco informacion del formulario si existe
			$arrParam = array(
				"idFormulario" => $idFormulario
			);				
			$data['information'] = $this->encuesta_model->get_form_formalizacion($arrParam);
						
			$data['information_form1'] = $this->encuesta_model->get_form_administrativa($arrParam);
			$data['information_form2'] = $this->encuesta_model->get_form_actividad_economica($arrParam);
			$data['information_form4'] = $this->encuesta_model->get_form_financiera($arrParam);

			if ($data['information']) { 
				$data["idFormFormalizacion"] = $data['information']['id_formalizacion'];
			}else{
				$data["idFormFormalizacion"] = "";
			}
			
			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'form_formalizacion';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar formulario administrativa
     * @since 21/9/2017
	 */
	public function save_form_formalizacion()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idFormulario = $this->input->post('hddIdentificador');
			$data["idFormulario"] = $idFormulario;

			if($this->encuesta_model->add_form_formalizacion()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de sectores por comuna
     * @since 22/9/2017
	 */
    public function sectorList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idComuna'] = $this->input->post('identificador');
			$lista = $this->encuesta_model->get_sector_by($arrParam);
		
			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idSector"] . "' >" . $fila["idSector"] . "</option>";
				}
			}
    }
	
	/**
	 * Lista de secciones por sector
     * @since 22/9/2017
	 */
    public function seccionList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idSector'] = $this->input->post('identificador');
			$arrParam['idComuna'] = $this->input->post('comuna');
			$lista = $this->encuesta_model->get_seccion_by($arrParam);
		
			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idSeccion"] . "' >" . $fila["idSeccion"] . "</option>";
				}
			}
    }

	/**
	 * Lista de manzanas por sector
     * @since 22/9/2017
	 */
    public function manzanaList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idSeccion'] = $this->input->post('identificador');
			$arrParam['idSector'] = $this->input->post('sector');
			$arrParam['idComuna'] = $this->input->post('comuna');
			$lista = $this->encuesta_model->get_manzana_by($arrParam);

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idManzana"] . "' >" . $fila["idManzana"] . "</option>";
				}
			}
    }
	
	/**
	 * encuesta control
     * @since 28/9/2017
	 */
	public function form_control($idFormulario)
	{
			$arrParam = array("idFormulario" => $idFormulario);
			$data['info'] = $this->encuesta_model->get_control($arrParam);

			$data["idFormulario"] = $idFormulario;
			$data["view"] = 'control';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - encuesta control
     * @since 28/9/2017
     */
    public function cargarModalControl() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idControl"] = $this->input->post("idControl");
			$data["idFormulario"] = $this->input->post("idFormulario");

			if ($data["idControl"] != 'x') 
			{
				$arrParam = array(
					"idControl" => $data["idControl"]
				);
				$data['information'] = $this->encuesta_model->get_control($arrParam);
				
				$data["idFormulario"] = $data['information'][0]['fk_id_formulario'];
			}
			
			$this->load->view("control_modal", $data);
    }
	
	/**
	 * Guardar control
     * @since 28/9/2017
	 */
	public function save_control()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idControl = $this->input->post('hddId');
			$idFormulario  = $this->input->post('hddIdFormulario');

			$msj = "Se adicionó un nuevo registro del resultado de la encuesta.";
			if ($idControl != '') {
				$msj = "Se actualizó registro.";
			}			
			
			//si la respuesta es encuenta completa, se debe validar si los formularios ya estan todos diligenciados
			$resultado = $this->input->post('resultado');
			$bandera = true;

			if($resultado == "EC"){
				
				//busco informacion del formulario si existe
				$arrParam = array(
					"idFormulario" => $idFormulario
				);				
				$information_form1 = $this->encuesta_model->get_form_administrativa($arrParam);
				$information_form2 = $this->encuesta_model->get_form_actividad_economica($arrParam);
				$information_form3 = $this->encuesta_model->get_form_criticos($arrParam);
				$information_form4 = $this->encuesta_model->get_form_financiera($arrParam);
				$information_form5 = $this->encuesta_model->get_form_servicios($arrParam);
				$information_form6 = $this->encuesta_model->get_form_formalizacion($arrParam);
				$information_form7 = $this->encuesta_model->get_last_record_control($arrParam);
				
if(!$information_form1){
		$bandera = false;//vailidacion del capitulo 1
}
				
//validaciones para saber si se debe responder capitulo 2,3,4,5,6
$banderaTerminar = false;
$banderaTerminar2 = false;
if($bandera && $information_form1 && $information_form1['estado_actual'] == 1){
	$banderaTerminar = true;
	if($information_form1['establecimiento'] == 3 || $information_form1['establecimiento'] == 4){
		$banderaTerminar = false;
	}else{
	
		if($information_form2 && $information_form2['fk_id_seccion'] != 16 && $information_form2['fk_id_seccion'] != 17 && $information_form2['fk_id_seccion'] != 18){ //validacion formulario 2
			$banderaTerminar2 = true;
			
			if($information_form2['numero_personas']>9){
				$banderaTerminar2 = false;
			}
		}
		
	}
}

//aplico la validacion 
if($banderaTerminar){
		if(!$information_form2){
			//debe responder capitulo 2
			$bandera = false;
		}
		if($bandera && $banderaTerminar2){
			if(!$information_form3 || !$information_form4 || !$information_form5){
				//debe responder capitulo 3,4,5
				$bandera = false;
			}
			
			
			//validaciones para responder el capitulo 6
			$banderaTerminar3 = false;
			if($information_form1 && $information_form1['matricula'] != 1){
				$banderaTerminar3 = true;
			}

			if($information_form1 && $information_form1['rut'] != 1){
				$banderaTerminar3 = true;
			}

			if($information_form2 && $information_form2['seguridad_social'] != 1){
				$banderaTerminar3 = true;
			}
			if($information_form4 && $information_form4['impuestos'] != 1){
				$banderaTerminar3 = true;
			}
			if($information_form4 && $information_form4['contabilidad'] != 1){
				$banderaTerminar3 = true;
			}
		
			//aplico la validacion 
			if($banderaTerminar3 && $bandera ){
				if(!$information_form6){
					//debe responder capitulo 6
					$bandera = false;
				}			
			}	
		}		
}











	
				
				
			}

			$data["idRecord"] = $idFormulario;
			if($bandera){
				if ($idControl = $this->encuesta_model->saveControl()) {
					$data["result"] = true;					
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
				}
			}else{
					$data["result"] = "error";
					$data["mensaje"] = "Faltan capítulos por diligenciar";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Faltan capítulos por diligenciar.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de divisiones por actividad
     * @since 2/10/2017
	 */
    public function divisionList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idActividad'] = $this->input->post('identificador');
			$lista = $this->encuesta_model->get_division_by($arrParam);

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["ID"] . "' >" . $fila["DESCRIPCION"] . "</option>";
				}
			}
    }

	/**
	 * foto
	 */
	public function foto($idEstablecimiento, $error = '')
	{
			if (empty($idEstablecimiento)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//busco datos del estableciiento
			$arrParam = array(
				"idEstablecimiento" => $idEstablecimiento
			);
			$data['information'] = $this->encuesta_model->get_establecimientos($arrParam);
			
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 
			$data['idEstablecimiento'] = $idEstablecimiento; 
			$data["view"] = 'establecimiento_foto';
			$this->load->view("layout", $data);
	}	

	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload($idManzana) 
	{
        $config['upload_path'] = './images/establecimientos/';
        $config['overwrite'] = true;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1008';
        $idEstablecimiento = $this->input->post("hddId");
        $config['file_name'] = $idEstablecimiento;

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->foto($idEstablecimiento,$error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
            //USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
            //ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
			$this->_create_thumbnail($file_info['file_name']);
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/establecimientos/thumbs/" . $imagen;

			
			//actualizamos el campo photo
			$arrParam = array(
				"table" => "form_establecimiento",
				"primaryKey" => "id_establecimiento",
				"id" => $idEstablecimiento,
				"column" => "foto",
				"value" => $path
			);

			$this->load->model("general_model");
			//$data['linkBack'] = "encuest/vehicle/" . $vistaRegreso;
			//$data['titulo'] = "<i class='fa fa-automobile'></i>VEHICLE";
			
			if($this->general_model->updateRecord($arrParam))
			{
				$data['clase'] = "alert-success";
				$data['msj'] = "Se subio la imagen con éxito.";
			}else{
				$data['clase'] = "alert-danger";
				$data['msj'] = "Error, contactarse con el administrador.";
			}
						
			//$data["view"] = 'template/answer';
			//$this->load->view("layout", $data);
			redirect('encuesta/establecimiento/' . $idManzana);
        }
    }
	
    //FUNCIÓN PARA CREAR LA MINIATURA A LA MEDIDA QUE LE DIGAMOS
    function _create_thumbnail($filename) 
	{
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'images/establecimientos/' . $filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image'] = 'images/establecimientos/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
	
	/**
	 * Guardar imagen
     * @since 6/8/2017
	 */
	public function ajax()
	{		
			$src = $this->input->post('src');
			$idEstablecimiento = $this->input->post('idEstablecimiento');

			//actualizamos el campo coordinador en la lista de municipios
			$arrParam = array(
				"table" => "form_establecimiento",
				"primaryKey" => "id_establecimiento",
				"id" => $idEstablecimiento,
				"column" => "foto_dispositivo",
				"value" => $src
			);

			$this->load->model("general_model");

			if ($this->general_model->updateRecord($arrParam)) {				
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', 'Se guardó la información');
			}else{
					$data["result"] = "error";				
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');					
			}
			
			$this->output->set_output($src);
	}
	
	/**
	 * Eliminar manzana
     * @since 6/10/2017
	 */
	public function eliminar_manzana()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idManzana = $this->input->post('identificador');

			$this->load->model("general_model");

			//actualizar campo estado para no mostrar mas la manzana
			$arrParam = array(
				"table" => "form_manzana",
				"primaryKey" => "id_manzana",
				"id" => $idManzana,
				"column" => "estado",
				"value" => 2
			);

			$this->load->model("general_model");
			
			if($this->general_model->updateRecord($arrParam))
			{
				$data["result"] = true;
				$data["mensaje"] = "Se eliminó la manzana.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó la Manzana');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}
	

			echo json_encode($data);
    }
	
	/**
	 * Eliminar establecimiento
     * @since 6/10/2017
	 */
	public function eliminar_establecimiento()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idEstablecimiento = $this->input->post('identificador');
			
			//obtener id manzana del establecimeinto
			$arrParam = array(
				"idEstablecimiento" => $idEstablecimiento
			);
			$data['information'] = $this->encuesta_model->get_establecimientos($arrParam);
			
			$data["idRecord"] = $data['information'][0]['fk_id_manzana'];

			$this->load->model("general_model");

			//actualizar campo estado para no mostrar mas el establecimiento
			$arrParam = array(
				"table" => "form_establecimiento",
				"primaryKey" => "id_establecimiento",
				"id" => $idEstablecimiento,
				"column" => "estado",
				"value" => 2
			);

			$this->load->model("general_model");
			
			if($this->general_model->updateRecord($arrParam))
			{
				$data["result"] = true;
				$data["mensaje"] = "Se eliminó el Establecimiento.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó el Establecimiento');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}
	

			echo json_encode($data);
    }
	
	/**
	 * Eliminar registro de control
     * @since 7/10/2017
	 */
	public function eliminar_registro_control()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idControl = $this->input->post('identificador');
			
			//obtener id formulario
			$arrParam = array(
				"idControl" => $idControl
			);
			$data['information'] = $this->encuesta_model->get_control($arrParam);
			
			$data["idRecord"] = $data['information'][0]['fk_id_formulario'];
			
			$this->load->model("general_model");

			//actualizar campo estado para no mostrar mas el registro control
			$arrParam = array(
				"table" => "form_control",
				"primaryKey" => "id_control",
				"id" => $idControl,
				"column" => "estado",
				"value" => 2
			);

			$this->load->model("general_model");
			
			if($this->general_model->updateRecord($arrParam))
			{
				$data["result"] = true;
				$data["mensaje"] = "Se eliminó el registro de control de la encuesta.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó el registro de control de la encuesta');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}
	

			echo json_encode($data);
    }
	
	/**
	 * geolocalizacion
	 */
	public function geolocalizacion($idEstablecimiento)
	{
			if (empty($idEstablecimiento)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//busco datos del estableciiento
			$arrParam = array(
				"idEstablecimiento" => $idEstablecimiento
			);
			$data['information'] = $this->encuesta_model->get_establecimientos($arrParam);
			
			$data['idEstablecimiento'] = $idEstablecimiento; 
			$data["view"] = 'establecimiento_geolocalizacion';
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    public function update_geolocalizacion($idManzana) 
	{
		if($this->encuesta_model->updateAddressEstablecimiento($arrParam))
		{
			$data['clase'] = "alert-success";
			$data['msj'] = "Se actualizarón los datos.";
		}else{
			$data['clase'] = "alert-danger";
			$data['msj'] = "Error, contactarse con el administrador.";
		}
					
		redirect('encuesta/establecimiento/' . $idManzana);
    }

	
	
}