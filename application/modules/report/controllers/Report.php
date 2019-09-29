<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("report_model");
    }
		
	/**
	 * Formulario para dar respuesta a la alerta
     * @since 23/5/2017
	 */
	public function responder_alerta($idPuesto, $idAuditor, $idAlerta, $rol)
	{
			$this->load->model("general_model");
			$this->load->model("specific_model");

			//consultar informacion de la alerta
			$arrParam = array("idAlerta" => $idAlerta);
			$data['infoAlerta'] = $this->specific_model->get_info_alerta($arrParam);
							
			//listado de PUESTOS DE VOTACION para el OPERADOR
			$arrParam = array('idPuesto' => $idPuesto);
			$data['infoPuestos'] = $this->general_model->get_puesto($arrParam);

			$data["idAuditor"] = $idAuditor;//se pasa el rol del operador o del coordinador
			$data["rol"] = $rol;//se pasa el rol del operador o del coordinador
			$data["view"] = 'form_responder_alerta';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Registro de la aceptacion de la alerta notificacion
	 * @since 25/9/2019
	 */
	public function registro_notificacion_by_operador()
	{
			$data = array();

			$rol = $this->input->post('hddIdRol');
			$idAlerta = $this->input->post('hddIdAlerta');
			$idPuesto = $this->input->post('hddIdPuesto');
			
			$acepta = $this->input->post('acepta');
			$observacion = $this->input->post('observacion');

			$error = true;
			if($acepta && $acepta==2 && $observacion == ""){
				$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> Debe indicar la Observación.');
			}elseif($acepta==""){
				$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> Debe indicar su respuesta.');
			}else{
				if ($this->report_model->saveRegistroNotificacionOperador()) {
					$error = false;
					$this->session->set_flashdata('retornoExito', "Gracias por su respuesta.");
				} else {
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}

			if($error){
				redirect("/report/responder_alerta/" . $idPuesto . "/" . $idAlerta . "/" . $rol,"location",301);
			}else{
				redirect("/dashboard/" . $rol,"location",301);
			}
	}

	
	
	
	

	
}