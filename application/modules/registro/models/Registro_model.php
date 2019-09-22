<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Registro_model extends CI_Model {

		/**
		 * Verificar si ya esta el propietario en la BD
		 * @since  18/9/2017
		 */
		public function verifyPropietario($arrData) 
		{
				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("usuario");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		
		/**
		 * Add/Edit TIPO ALERTA
		 * @since 10/5/2017
		 */
		public function saveMensaje($answer) 
		{				
				$data = array(
					'mensaje' => $answer
				);

				$query = $this->db->insert('pruebas', $data);
				$idTipoAlerta = $this->db->insert_id();				

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Guardar votos
		 * @since 18/9/2019
		 */
		public function saveVotos() 
		{
			$idRegistroVoto = $this->input->post("hddIdRegistroVoto");
			$idPuesto = $this->input->post("hddIdPuesto");
			$idMesa = $this->input->post("hddIdMesa");
			$idUser = $this->session->userdata("id");
			$numeroVotos = $this->input->post("numeroVotos");
			
			if ($candidatos = $this->input->post('hddIdCandidato')) {
				$tot = count($candidatos);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'fk_id_puesto_votos_rv' => $idPuesto,
						'fk_id_mesa_rv' => $idMesa,
						'fk_id_candidato_rv' => $candidatos[$i],
						'fk_id_usuario_rv' => $idUser,
						'numero_votos' => $numeroVotos[$i],
						'fecha_registro_votos' => date("Y-m-d G:i:s")
					);	
					
					//revisar si es para adicionar o editar
					if ($idRegistroVoto[$i] == '') {
						$query = $this->db->insert('registro_votos', $data);
					} else {
						$this->db->where('id_registro_votos', $idRegistroVoto[$i]);
						$query = $this->db->update('registro_votos', $data);
					}
					
					//guardar el LOG
					$query = $this->db->insert('log_registro_votos', $data);

				}
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
	
	    
	}