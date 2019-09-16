<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
		
	/**
	 * Update field in a table
	 * @since 25/5/2017
	 */
	public function updateRecord($arrDatos) {
			$data = array(
				$arrDatos ["column"] => $arrDatos ["value"]
			);
			$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
			$query = $this->db->update($arrDatos ["table"], $data);
			if ($query) {
				return true;
			} else {
				return false;
			}
	}	
	
		/**
		 * Info PUESTO DE VOTACION
		 * @since 11/9/2019
		 */
		public function get_puesto($arrDatos) 
		{
				$this->db->select();
				$this->db->join('param_divipola D', 'D.codigo_municipio = P.fk_id_municipio', 'LEFT');
				
				if (array_key_exists("idPuesto", $arrDatos)) {
					$this->db->where('P.id_puesto_votacion', $arrDatos["idPuesto"]);
				}
												
				$this->db->order_by('P.nombre_puesto_votacion', 'asc');
				$query = $this->db->get('puesto_votacion P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
	
	
		/**
		 * Info PUESTO DE VOTACION
		 * @since 11/9/2019
		 */
		public function get_info_encargado_puesto($arrDatos) 
		{
				$this->db->select();
				$this->db->join('usuario U', 'U.id_usuario = E.fk_id_usuario', 'INNER');
				$this->db->join('puesto_votacion P', 'P.id_puesto_votacion = E.fk_id_puesto_votacion', 'INNER');
				
				if (array_key_exists("idUsuario", $arrDatos)) {
					$this->db->where('E.fk_id_usuario', $arrDatos["idUsuario"]);
				}
								
				$this->db->order_by('P.nombre_puesto_votacion', 'asc');
				$query = $this->db->get('encargado_puesto_votacion E');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
	
		/**
		 * Info MESAS
		 * @since 12/9/2019
		 */
		public function get_mesas($arrDatos) 
		{
				$this->db->select();
				
				if (array_key_exists("idPuesto", $arrDatos)) {
					$this->db->where('M.fk_puesto_votacion_mesas', $arrDatos["idPuesto"]);
				}
				
				if (array_key_exists("idMesa", $arrDatos)) {
					$this->db->where('M.id_mesa', $arrDatos["idMesa"]);
				}
												
				$this->db->order_by('M.numero_mesa', 'asc');
				$query = $this->db->get('mesas M');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Listado Candidatos
		 * @since 12/9/2019
		 */
		public function get_candidatos($arrDatos) 
		{
				$this->db->select();
				$this->db->join('corporacion U', 'U.id_corporacion = C.fk_id_corporacion', 'INNER');
				$this->db->join('partidos P', 'P.id_partido = C.fk_id_partido', 'INNER');
				
				if (array_key_exists("idCorporacion", $arrDatos)) {
					$this->db->where('fk_id_corporacion', $arrDatos["idCorporacion"]);
				}
				
				if (array_key_exists("idCandidato", $arrDatos)) {
					$this->db->where('id_candidato', $arrDatos["idCandidato"]);
				}
																
				$this->db->order_by('numero_orden_partido, numero_orden_candidato', 'asc');
				$query = $this->db->get('candidatos C');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
	
		/**
		 * Listado corporaciones
		 * @since 15/9/2019
		 */
		public function get_corporacion($arrDatos) 
		{
				$this->db->select();
				
				if (array_key_exists("idCorporacion", $arrDatos)) {
					$this->db->where('id_corporacion', $arrDatos["idCorporacion"]);
				}
				
				$this->db->order_by('corporacion', 'asc');
				$query = $this->db->get('corporacion');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}	

		/**
		 * Listado PARTIDOS
		 * @since 15/9/2019
		 */
		public function get_partido($arrDatos) 
		{
				$this->db->select();
				
				if (array_key_exists("idPartido", $arrDatos)) {
					$this->db->where('id_partido', $arrDatos["idPartido"]);
				}
				
				$this->db->order_by('numero_orden_partido', 'asc');
				$query = $this->db->get('partidos');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}	
		
		/**
		 * Lista de departamentos
		 * @since 12/5/2017
		 */
		public function get_dpto_divipola() 
		{
				$this->db->select('DISTINCT(dpto_divipola), dpto_divipola_nombre');

				$this->db->order_by('dpto_divipola_nombre', 'asc');
				$query = $this->db->get('param_divipola D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Municipios por departamento
		 * @since 12/5/2016
		 */
		public function get_municipios_by($arrDatos)
		{
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
			
				$municipios = array();
				$this->db->select();
				if (array_key_exists("idDepto", $arrDatos)) {
					$this->db->where('codigo_departamento', $arrDatos["idDepto"]);
				}
				
				if ($userRol==3) {
					$this->db->where('fk_id_coordinador_mcpio', $userID);
				}
				if ($userRol==6) {
					$this->db->where('fk_id_operador_mcpio', $userID);
				}
				
				$this->db->order_by('nombre_municipio', 'asc');
				$query = $this->db->get('param_divipola');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$municipios[$i]["idMcpio"] = $row->codigo_municipio;
						$municipios[$i]["municipio"] = $row->nombre_municipio;
						$i++;
					}
				}
				$this->db->close();
				return $municipios;
		}
		

	
	

		


		


}