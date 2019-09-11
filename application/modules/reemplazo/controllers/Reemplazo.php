<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reemplazo extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("reemplazo_model");
		$this->load->library("validarsesion");
    }

    /**
	 * Lista de REEMPLAZOS
     * @since 1/10/2017
	 */
	public function index()
	{
			$arrParam = array();
			$data['info'] = $this->reemplazo_model->get_reemplazos($arrParam);
			
			$data["view"] = 'reemplazo';
			$this->load->view("layout", $data);
	}

	/**
     * Cargo modal - formulario reemplazos
     * @since 1/10/2017
     */
    public function cargarModalReemplazo() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");	
			
			if ($data["identificador"] != 'x') {				
				$arrParam = array(
					"idReemplazo" => $data["identificador"]
				);
				$data['information'] = $this->reemplazo_model->get_reemplazos($arrParam);
			}
			$this->load->view("reemplazo_modal", $data);
    }
	
	/**
	 * Update REEMPLAZO
     * @since 1/10/2017
	 */
	public function save_reemplazo()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$identificador = $this->input->post('hddId');
			
			$msj = "Se adicionó el reemplazo con éxito.";
			if ($identificador != '') {
				$msj = "Se actualizó el reemplazo con éxito.";
			}

			if ($identificador = $this->reemplazo_model->saveReemplazo()) {
				$data["result"] = true;
				$data["idRecord"] = $identificador;
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["idRecord"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }

    /**
	 * Lista de reemplazos por manzana
     * @since 02/10/2017
	 */
    public function reemplazosList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idManzana'] = $this->input->post('identificador');
			$arrParam['idSeccion'] = $this->input->post('seccion');
			$arrParam['idSector'] = $this->input->post('sector');
			$arrParam['idComuna'] = $this->input->post('comuna');

			$lista = $this->reemplazo_model->get_reemplazo_by($arrParam);

			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idReemplazo"] . "' >" . $fila["idReemplazo"] . "</option>";
				}
			}
    }
}