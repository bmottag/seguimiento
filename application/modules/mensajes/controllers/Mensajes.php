<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("mensajes_model");
    }
	
	/**
	 * Recibir mensaje de TWILIO
     * @since 16/1/2019
     * @author BMOTTAG
	 */
	public function storeSms()
	{			
			//$mensaje = $_REQUEST ['Body'];
			
			$mensaje = "VOTO&3&1&1&8;1&22;2&66;3&88;4&55;5&33;6&99;7&77;8&44;9&11;21&0;22&1;";
			//$mensaje = "ALERTA&1&1&1&1&que pasa;";
			
			$this->mensajes_model->saveMensaje($mensaje);
			
			$porciones = explode("&", $mensaje);
			$primerCampo = $porciones[0];
						
			if($primerCampo == "ALERTA"){
				$this->mensajes_model->saveRegistroRespueta($mensaje);
			}else{
				$this->mensajes_model->saveRegistroVoto($mensaje);
			}
			
			
	}	

	
	
	
	
	
	
	
	

	
	
}