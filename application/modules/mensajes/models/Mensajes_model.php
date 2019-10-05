<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mensajes_model extends CI_Model {
		
		/**
		 * Add/Edit TIPO MENSAJE
		 * @since 10/5/2017
		 */
		public function saveMensaje($answer) 
		{				
				$data = array(
					'mensaje' => $answer,
					'fecha_mensaje' => date("Y-m-d G:i:s")
				);

				$query = $this->db->insert('mensaje_texto', $data);
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
		public function saveRegistroVoto($answer) 
		{
			$mensaje = explode(";", $answer);
			
			$porcionesPrimerRegistro = explode("&", $mensaje[0]);
			
			$idPuesto = $porcionesPrimerRegistro[1];
			$idMesa = $porcionesPrimerRegistro[2];
			$corporacion = $porcionesPrimerRegistro[3];
			$idUser = $porcionesPrimerRegistro[4];												
						
			if ($mensaje) {
				$tot = count($mensaje);
				$conteoVotos = 0;

				for ($i = 1; $i < $tot; $i++) 
				{
					/*
					FORMATO MENSAJE DE VOTOS

					Voto&IdPuesto&IdMesa&Corporacion&idUsuarioAuditor;
					idCandidato&numeroVotos;
					idCandidato&numeroVotos;
					idCandidato&numeroVotos;
					*/					
					$porciones = explode("&", $mensaje[$i]);
					if($porciones[0])
					{
							$idCandidatos = $porciones[0];
							$numeroVotos = $porciones[1];
							$conteoVotos = $conteoVotos + $numeroVotos;
							
							$data = array(
								'fk_id_puesto_votos_rv' => $idPuesto,
								'fk_id_mesa_rv' => $idMesa,
								'fk_id_candidato_rv' => $idCandidatos,
								'fk_id_usuario_rv' => $idUser,
								'numero_votos' => $numeroVotos,
								'fecha_registro_votos' => date("Y-m-d G:i:s"),
								'tipo_registro_votos' => 2
							);	
							
							//busco primero si ya tiene datos esa mesa para ese candidato
							//si tiene datos entonces actualizo
							//si no tiene datos entonces hago un insert
							$cadena_sql = "SELECT id_registro_votos FROM registro_votos 
										WHERE fk_id_mesa_rv = ".$idMesa." AND fk_id_candidato_rv = '".$idCandidatos."'";
							$query = $this->db->query($cadena_sql);
							
							//revisar si es para adicionar o editar
							if ($query->num_rows() > 0){	
								$resultado = $query->row_array();
								$this->db->where('id_registro_votos', $resultado['id_registro_votos']);
								$query = $this->db->update('registro_votos', $data);					
								
							}else {
								$query = $this->db->insert('registro_votos', $data);
							}
							
							//guardar el LOG
							$query = $this->db->insert('log_registro_votos', $data);
					}
					
				}
				
				//actualizo el conteo de votos de la MESA para la corporacion y el estado
				if($corporacion==1){
					$campoSumatoria = "sumatoria_votos_presidente";
					$campoEstado = "estado_presidente";
				}else{
					$campoSumatoria = "sumatoria_votos_diputado";
					$campoEstado = "estado_diputado";
				}
				
				$data = array(
					$campoSumatoria => $conteoVotos,
					$campoEstado => 2
				);	
				
				$this->db->where('id_mesa', $idMesa);
				$query = $this->db->update('mesas', $data);
								
			}
			
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Guardar respuesta alerta
		 * @since 1/10/2019
		 */
		public function saveRegistroRespueta($answer) 
		{
			$porciones = explode("&", $answer);
			
			$idAlerta = $porciones[1];
			$idPuesto = $porciones[2];
			$idUsuario = $porciones[3];
			$respuesta = $porciones[4];
			$observacion = $porciones[5];

			$data = array(
				'fk_id_alerta' => $idAlerta,
				'fk_id_puesto_votacion_r' => $idPuesto,
				'fk_id_usuario_r' => $idUsuario,
				'acepta' => $respuesta,
				'observacion' => $observacion,
				'fecha_registro' => date("Y-m-d G:i:s"),
				'tipo_registro' => 2
			);	

			$query = $this->db->insert('registro', $data);

			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		

	
	    
	}