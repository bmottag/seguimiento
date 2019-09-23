<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase para consultas especificas
 */
class Specific_model extends CI_Model {

		/**
		 * Información de una alerta
		 * @since 28/7/2017
		 */
		public function get_info_alerta($arrDatos) 
		{
				$this->db->select();
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');//tipo alerta
				
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('A.id_alerta', $arrDatos["idAlerta"]); //FILTRO POR ID ALERTA
				}
				
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Contar MESAS CERRADAS PARA UN PUESTO
		 * @since 22/9/2019
		 */
		public function countMesasCerradas($arrDatos)
		{

				$sql = "SELECT count(id_mesa) CONTEO";
				$sql.= " FROM mesas";
				$sql.= " WHERE " . $arrDatos["columna"] . " = " . $arrDatos["valor"];
				if (array_key_exists("idPuesto", $arrDatos)) {
					$sql.= " AND fk_puesto_votacion_mesas = " . $arrDatos["idPuesto"];
				}
				
				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}		
		
		/**
		 * Lista de alertas para mostrar en la app
		 * @since 28/7/2017
		 */
		public function get_lista_alertas() 
		{
				$this->db->select();
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');
				$this->db->join('sesiones S', 'S.id_sesion = A.fk_id_sesion', 'INNER');
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');

				$this->db->order_by('A.fecha_inicio, P.nombre_prueba, G.nombre_grupo_instrumentos, S.sesion_prueba', 'asc');
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de sesiones para un operador
		 * @since 28/7/2017
		 */
		public function get_sesiones_operador() 
		{				
				$this->db->select("DISTINCT(id_sesion), nombre_prueba, nombre_grupo_instrumentos, fecha, sesion_prueba");

				//SITIO-SESION
				$this->db->join('sitio_sesion X', 'X.fk_id_sitio = Y.id_sitio', 'INNER');
				
				//SESION
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				//GRUPO INSTRUMENTOS
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				//PRUEBA
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');
				
				
				//FILTRO POR COORDINADOR SI EL USUARIO DE SESION ES COORDINADOR
				$userRol = $this->session->rol;
				if($userRol==3) {
					$this->db->where('Y.fk_id_user_coordinador', $this->session->id); //FILTRO POR ID DEL COORDINADOR
				}				
				//FILTRO POR OPERADOR SI EL USUARIO DE SESION ES OPERADOR
				if($userRol==6) {
					$this->db->where('Y.fk_id_user_operador', $this->session->id); //FILTRO POR ID DEL OPERADOR
				}
			
				$this->db->order_by('S.id_sesion', 'asc');
				$query = $this->db->get('sitios Y');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Obtener alertas vencidas y que se le debe dar respuesta por el delegado
		 * filtrados por operador y por sesion
		 * @since 28/7/2017
		 */
		public function get_alertas_vencidas_totales($arrDatos) 
		{		
				//fecha para buscar las que ya se vencieron
				$fechaActual = date('Y-m-d G:i:s');	
				
				//si es una consulta para el reporte con los datos filtrados por post
				$sesion = $this->input->post('sesion');
				$alerta = $this->input->post('alerta');
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');
				$region = $this->input->post('region');

				$this->db->select('distinct(id_alerta)');
								
				if ($alerta && $alerta != "") {
					$this->db->where('A.id_alerta', $alerta); //FILTRO POR ALERTA
				}
				
				if ($region && $region != "") {
					$this->db->where('Y.fk_id_region', $region); //FILTRO POR REGION
				}
				
				if ($depto && $depto != "") {
					$this->db->where('Y.fk_dpto_divipola', $depto); //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$this->db->where('Y.fk_mpio_divipola', $mcpio); //FILTRO POR MUNICIPIO
				}
				
				$this->db->where('A.estado_alerta', 1); //ALERTAS ACTIVAS
								
				$this->db->where('A.fecha_alerta <=', $fechaActual); //FECHA FINAL SEA MAYOR A LA FECHA ACTUAL
			
				$this->db->order_by('A.id_alerta', 'asc');
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de anulaciones
		 * @since 16/8/2017
		 */
		public function get_anulaciones_sin_aprobar($arrDatos) 
		{
				$this->db->select();
				$this->db->join('sitios X', 'X.id_sitio = A.fk_id_sitio', 'INNER');
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('X.fk_id_user_coordinador', $arrDatos["idCoordinador"]);
				}
				$this->db->where('A.aprobada', 0);

				$query = $this->db->get('anulaciones A');

				if ($query->num_rows() > 0) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de cuadernillos
		 * @since 16/8/2017
		 */
		public function get_cambio_cuadernillo_sin_aprobar($arrDatos) 
		{
				$this->db->select();
				$this->db->join('sitios X', 'X.id_sitio = A.fk_id_sitio', 'INNER');
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('X.fk_id_user_coordinador', $arrDatos["idCoordinador"]);
				}
				$this->db->where('A.aprobada', 0);

				$query = $this->db->get('novedades_cambio_cuadernillo A');

				if ($query->num_rows() > 0) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de holguras
		 * @since 16/8/2017
		 */
		public function get_holguras_sin_aprobar($arrDatos) 
		{
				$this->db->select();
				$this->db->join('sitios X', 'X.id_sitio = A.fk_id_sitio', 'INNER');
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('X.fk_id_user_coordinador', $arrDatos["idCoordinador"]);
				}
				$this->db->where('A.aprobada', 0);

				$query = $this->db->get('novedades_holgura A');

				if ($query->num_rows() > 0) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de otras novedades
		 * @since 16/8/2017
		 */
		public function get_otras_sin_aprobar($arrDatos)
		{
				$this->db->select();
				$this->db->join('sitios X', 'X.id_sitio = A.fk_id_sitio', 'INNER');
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('X.fk_id_user_coordinador', $arrDatos["idCoordinador"]);
				}
				$this->db->where('A.aprobada', 0);

				$query = $this->db->get('novedades_otra A');

				if ($query->num_rows() > 0) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Contar Sitios por sesion
		 * @since  3/11/2017
		 */
		public function countSitiosBySesion($arrDatos)
		{

				$sql = "SELECT count(X.fk_id_sitio) CONTEO";
				$sql.= " FROM sitio_sesion X";
				$sql.= " INNER JOIN sitios S ON S.id_sitio = X.fk_id_sitio";
				$sql.= " WHERE 1 = 1";
				
				if (array_key_exists("idSesion", $arrDatos)) {
					$sql.= " AND X.fk_id_sesion = " . $arrDatos["idSesion"];
				}
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$sql.= " AND S.fk_id_user_coordinador = " . $arrDatos["idCoordinador"];
				}
				
				if (array_key_exists("idOperador", $arrDatos)) {
					$sql.= " AND S.fk_id_user_operador = " . $arrDatos["idOperador"];
				}
				
				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		/**
		 * Obtener alertas vencidas y que se le debe dar respuesta por el delegado
		 * se filtra por alertas para un periodo de 24 horas
		 * @since 24/5/2017
		 */
		public function get_alertas_vencidas_by($arrDatos) 
		{		
				//fecha para uscar las que ya se vencieron
				$fechaActual = date('Y-m-d G:i:s');
				
				$fechaMinima = strtotime ( '-1 day' , strtotime ( $fechaActual ) ) ;
				$fechaMinima = date ( 'Y-m-d G:i:s' , $fechaMinima );//fecha minima para la busqueda
		
				$this->db->select();
				

				$this->db->where('A.estado_alerta', 1); //ALERTAS ACTIVAS
				

				
				$this->db->where('A.fecha_fin <=', $fechaActual); //FECHA FINAL SEA MAYOR A LA FECHA ACTUAL
				//$this->db->where('A.fecha_fin >', $fechaMinima); //FECHA FINAL SEA MAYOR A LA FECHA ACTUAL
				
				
				if (array_key_exists("tipoAlerta", $arrDatos)) {
					$this->db->where('A.fk_id_tipo_alerta', $arrDatos["tipoAlerta"]); //filtro por tipo de alerta
				}
				
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('A.id_alerta', $arrDatos["idAlerta"]); //id alerta
				}
			
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Revisar si se dio respuesta a la alerta para un sitio especifico y una sesion
		 * @since 12/5/2017
		 */
		public function get_respuestas_alertas_vencidas_by($arrDatos) 
		{
				$this->db->select();

				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('fk_id_alerta', $arrDatos["idAlerta"]); 
				}
				
				if (array_key_exists("respuestaAcepta", $arrDatos)) {
					$this->db->where('acepta', $arrDatos["respuestaAcepta"]); //filtro para las NOTIFICACIONES
				}
				
				if (array_key_exists("idRegistro", $arrDatos)) {
					$this->db->where('id_registro', $arrDatos["idRegistro"]); //filtro por el id del registro
				}
				
				$query = $this->db->get('registro');

				if ($query->num_rows() > 0) {
					return $query->result_array();;
				} else {
					return false;
				}
		}




		


}