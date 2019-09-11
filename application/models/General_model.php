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
		 * Contar establecimientos
		 * filtrado por id manzana
		 * @since  19/9/2017
		 */
		public function countEstablecimientos($arrDatos)
		{
				$sql = "SELECT count(id_establecimiento) CONTEO";
				$sql.= " FROM form_establecimiento E";
				$sql.= " WHERE 1 = 1";
				
				if (array_key_exists("idManzana", $arrDatos)) {
					$sql.= " AND fk_id_manzana = " . $arrDatos["idManzana"];
				}
				$sql.= " AND estado != 2";

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
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
	
	
	
	
	
	
	
	
	

		


		


}