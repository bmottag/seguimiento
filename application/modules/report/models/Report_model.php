<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Report_model extends CI_Model {

		/**
		 * Guardar respuesta del usuario
		 * @since 19/5/2017
		 */
		public function saveRegistroNotificacionOperador() 
		{
				$rol = $this->input->post('hddIdRol');
				$nota = 'Se realizó el registro por el ' . $rol;
				
				$data = array(
					'fk_id_alerta' => $this->input->post('hddIdAlerta'),
					'fk_id_puesto_votacion_r' => $this->input->post('hddIdPuesto'),
					'fk_id_usuario_r' => $this->session->id,
					'acepta' => $this->input->post('acepta'),
					'observacion' => $this->input->post('observacion'),
					'fecha_registro' => date("Y-m-d G:i:s"),
					'fk_id_user_coordinador' => $this->session->id,
					'nota' => $nota
				);	

				$query = $this->db->insert('registro', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
	    	
		
		
	    
	}