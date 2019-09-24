<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard_model extends CI_Model {

		/**
		 * Contar Puestos de votación
		 * @since  6/6/2017
		 */
		public function countPuestos($arrDatos)
		{

				$sql = "SELECT count(id_puesto_votacion) CONTEO";
				$sql.= " FROM puesto_votacion";
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$sql.= " WHERE fk_id_user_coordinador = " . $arrDatos["idCoordinador"];
				}
				
				if (array_key_exists("idOperador", $arrDatos)) {
					$sql.= " WHERE fk_id_user_operador = " . $arrDatos["idOperador"];
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}


		
		/**
		 * Muestra las alertas ACTIVAS para el USUARIO
		 * @since 14/5/2017
		 */
		public function get_alerta_by($arrDatos) 
		{
				$fecha = date("Y-m-d G:i:s");
				$userRol = $this->session->rol;
				$userID = $this->session->id;

			
				$this->db->select();
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');//tipo alerta
				$this->db->join('param_roles R', 'R.id_rol = A.fk_id_rol', 'INNER');//ROLES - ALERTA
				$this->db->join('sesiones S', 'S.id_sesion = A.fk_id_sesion', 'INNER');//SESIONES - ALERTA
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER'); //GRUPO INSTRUMENTO - SESIONES
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');//PRUEBA - GRUPO INSTRUMENTO
				$this->db->join('sitio_sesion X', 'X.fk_id_sesion = S.id_sesion', 'INNER');//SITIO - SESION
				$this->db->join('sitios Y', 'Y.id_sitio = X.fk_id_sitio', 'INNER');//SITIO

				$this->db->where('A.estado_alerta', 1); //ALERTA ACTIVA
				$this->db->where('A.fecha_inicio <=', $fecha); //FECHA INICIAL MAYOR A LA ACTUAL
				$this->db->where('A.fecha_fin >=', $fecha); //FECHA FINAL MAYOR A LA ACTUAL
				
				$tipoMensaje = array(1, 2);//filtrar por alertas que se muestren en el APP
				$this->db->where_in('A.tipo_mensaje', $tipoMensaje);	
				
				if (array_key_exists("tipoAlerta", $arrDatos)) {
					$this->db->where('A.fk_id_tipo_alerta', $arrDatos["tipoAlerta"]); //FILTRO POR TIPO ALERTA
				}
				
				$this->db->where('A.fk_id_rol', $userRol); //filtro por ROL DEL USUARIO
				$this->db->where('Y.fk_id_user_delegado', $userID); //filtro por ID DEL USUARIO
				
				$this->db->order_by('A.id_alerta', 'desc');
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Muestra las alertas ACTIVAS para el USUARIO
		 * @since 14/5/2017
		 * @revies 4/6/2017
		 */
		public function get_alerta_operadors_by($arrDatos) 
		{
				$fecha = date("Y-m-d G:i:s");
				$userRol = $this->session->rol;
				$userID = $this->session->id;

			
				$this->db->select();
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');//tipo alerta
				
				$this->db->where('A.estado_alerta', 1); //ALERTA ACTIVA
				$this->db->where('A.fecha_inicio <=', $fecha); //FECHA INICIAL MAYOR A LA ACTUAL
				$this->db->where('A.fecha_fin >=', $fecha); //FECHA FINAL MAYOR A LA ACTUAL
								
				if (array_key_exists("tipoAlerta", $arrDatos)) {
					$this->db->where('A.fk_id_tipo_alerta', $arrDatos["tipoAlerta"]); //FILTRO POR TIPO ALERTA
				}
				
				$this->db->order_by('A.id_alerta', 'desc');
				$query = $this->db->get('alertas A');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Guardar respuesta del usuario
		 * @since 19/5/2017
		 */
		public function saveRegistroInformativo() 
		{
				$data = array(
					'fk_id_alerta' => $this->input->post('hddId'),
					'fk_id_usuario' => $this->session->id,
					'fk_id_sitio_sesion' => $this->input->post('hddIdSitioSesion'),
					'acepta' => 1,
					'fecha_registro' => date("Y-m-d G:i:s")
				);	

				$query = $this->db->insert('registro', $data);
				
				$query = $this->db->insert('log_registro', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Consultar si el usuario ya dio respuesta a la alerta
		 * @since 19/5/2017
		 */
		public function get_registro_by($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('fk_id_alerta', $arrDatos["idAlerta"]);
				}
				$this->db->where('fk_id_usuario_r', $this->session->id);
				$query = $this->db->get('registro');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Guardar respuesta del usuario
		 * @since 19/5/2017
		 */
		public function saveRegistroNotificacion() 
		{
				$data = array(
					'fk_id_alerta' => $this->input->post('hddId'),
					'fk_id_usuario_r' => $this->session->id,
					'fk_id_puesto_votacion_r' => $this->input->post('hddIdPrueba'),
					'acepta' => $this->input->post('acepta'),
					'observacion' => $this->input->post('observacion'),
					'fecha_registro' => date("Y-m-d G:i:s")
				);	

				$query = $this->db->insert('registro', $data);
				
				$query = $this->db->insert('log_registro', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Guardar respuesta del usuario
		 * @since 19/5/2017
		 */
		public function saveRegistroConsolidacion($infoSitioSesion) 
		{
				$ausentes = $this->input->post('ausentes');
				$idSitioSesion = $this->input->post('hddIdSitioSesion');
		
				$data = array(
					'fk_id_alerta' => $this->input->post('hddId'),
					'fk_id_usuario' => $this->session->id,
					'fk_id_sitio_sesion' => $idSitioSesion,
					'acepta' => 1,
					'ausentes' => $ausentes,
					'fecha_registro' => date("Y-m-d G:i:s")
				);	

				$query = $this->db->insert('registro', $data);
				
				$query = $this->db->insert('log_registro', $data);

				if ($query) {
					
					//actualizo tabla sitio_sesion con la cantidad de ausentes
					$presentes = $infoSitioSesion[0]['numero_citados'] - $ausentes;
					
					$data = array(
						'numero_ausentes' => $ausentes,
						'numero_presentes_efectivos' => $presentes
					);

					$this->db->where('id_sitio_sesion', $idSitioSesion);
					$query = $this->db->update('sitio_sesion', $data);

					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Consultar informacion del sitio-sesion
		 * @since 19/5/2017
		 */
		public function get_info_sitio_sesion() 
		{
				$this->db->select();
				$this->db->where('id_sitio_sesion', $this->input->post('hddIdSitioSesion'));
				$query = $this->db->get('sitio_sesion SS');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Contar pruebas
		 * @since  21/5/2017
		 */
		public function countPruebas()
		{
				$year = date('Y');

				$sql = "SELECT count(id_prueba) CONTEO";
				$sql.= " FROM pruebas";
				$sql.= " WHERE anio_prueba = '$year'";

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		

		
		/**
		 * Contar pruebas
		 * @since  21/5/2017
		 */
		public function countAlertasByTipo($tipoAlerta)
		{
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));

				$sql = "SELECT count(id_registro) CONTEO";
				$sql.= " FROM registro R";
				$sql.= " INNER JOIN alertas A ON A.id_alerta = R.fk_id_alerta";
				$sql.= " WHERE R.fecha_registro >= '$firstDay'";
				$sql.= " AND A.fk_id_tipo_alerta = '$tipoAlerta'";

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		/**
		 * Sesiones abiertas para un rango +7 dias y -7dias a la fecha actual
		 * @since 22/5/2017
		 */
		public function get_sesiones_actuales($arrDatos) 
		{			
				$this->db->select();
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER'); //GRUPO INSTRUMENTO - SESIONES
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');//PRUEBA - GRUPO INSTRUMENTO
				$this->db->join('sitio_sesion X', 'X.fk_id_sesion = S.id_sesion', 'INNER');//SITIO - SESION
				$this->db->join('sitios Y', 'Y.id_sitio = X.fk_id_sitio', 'INNER');//SITIO
				$this->db->join('param_divipola D', 'D.mpio_divipola = Y.fk_mpio_divipola', 'INNER');//DIVIPOLA

				if (array_key_exists("fechaInicio", $arrDatos)) {
					$this->db->where('G.fecha >=', $arrDatos["fechaInicio"]); //FECHA INICIAL MAYOR A LA ACTUAL
				}

				if (array_key_exists("fechaFin", $arrDatos)) {
					$this->db->where('G.fecha <=', $arrDatos["fechaFin"]); //FECHA FINAL MENOR A LA ACTUAL
				}
				
				$this->db->order_by('P.nombre_prueba, G.nombre_grupo_instrumentos, S.sesion_prueba', 'asc');
				$query = $this->db->get('sesiones S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de municipios asignados al coordinador
		 * @since 24/5/2017
		 */
		public function get_municipios_coordinador() 
		{
				$userID = $this->session->userdata("id");
			
				$this->db->select('distinct(fk_mpio_divipola), dpto_divipola_nombre, mpio_divipola_nombre');
				$this->db->join('param_divipola D', 'D.mpio_divipola = S.fk_mpio_divipola', 'INNER');
				$this->db->where('S.fk_id_user_coordinador', $userID);
				
				$this->db->order_by('dpto_divipola_nombre, mpio_divipola_nombre', 'asc');
				$query = $this->db->get('sitios S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de municipios asignados al coordinador
		 * @since 24/5/2017
		 */
		public function get_municipios_coordinador_v2() 
		{
				$userID = $this->session->userdata("id");
			
				$this->db->select();
				$this->db->where('fk_id_coordinador_mcpio', $userID);
				$this->db->order_by('dpto_divipola_nombre, mpio_divipola_nombre', 'asc');
				$query = $this->db->get('param_divipola');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de municipios asignados al coordinador
		 * @since 4/6/2017
		 */
		public function get_municipios_operador() 
		{
				$userID = $this->session->userdata("id");
			
				$this->db->select('distinct(fk_mpio_divipola), dpto_divipola_nombre, mpio_divipola_nombre');
				$this->db->join('param_divipola D', 'D.mpio_divipola = S.fk_mpio_divipola', 'INNER');
				$this->db->where('S.fk_id_user_operador', $userID);
				
				$this->db->order_by('dpto_divipola_nombre, mpio_divipola_nombre', 'asc');
				$query = $this->db->get('sitios S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Guardar ausentes
		 * @since 3/11/2017
		 */
		public function guardar_ausentes($codigoDane, $idSesion) 
		{
			//limpio los ausentes
			$data = array('ausente' => 0);
			$this->db->where('fk_codigo_dane', $codigoDane);
			$this->db->where('fk_id_sesion', $idSesion);
			$query = $this->db->update('examinandos', $data);
			
			//ausentes
			$query = 1;
			if ($ausentes = $this->input->post('ausentes')) {
				$tot = count($ausentes);
				for ($i = 0; $i < $tot; $i++) {
					$data = array(
						'ausente' => 1
					);
					$this->db->where('id_examinando', $ausentes[$i]);
					$query = $this->db->update('examinandos', $data);
				}
			}
			if ($query) {
				return true;
			} else{
				return false;
			}
		}
		
		/**
		 * Contar PUESTOS DE VOTACION
		 * @since 22/9/2019
		 */
		public function countPuestosVotacion($arrDatos)
		{

				$sql = "SELECT count(id_puesto_votacion) CONTEO";
				$sql.= " FROM puesto_votacion";
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$sql.= " WHERE fk_id_user_coordinador = " . $arrDatos["idCoordinador"];
				}
				
				if (array_key_exists("idOperador", $arrDatos)) {
					$sql.= " WHERE fk_id_usuario_operador = " . $arrDatos["idOperador"];
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}		


		
		
		
		
	}