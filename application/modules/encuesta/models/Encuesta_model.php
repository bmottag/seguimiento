<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Encuesta_model extends CI_Model {

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
		 * Lista de establecimientos
		 * @since 18/9/2017
		 */
		public function get_establecimientos($arrDatos) 
		{
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
			
				$this->db->select('E.*, U.nombres_usuario, U.apellidos_usuario, CONCAT(K.nombres_usuario, " ", K.apellidos_usuario) jefe');
				$this->db->join('usuario U', 'U.id_usuario = E.fk_id_usuario', 'INNER');
				$this->db->join('usuario K', 'K.id_usuario = U.fk_id_jefe', 'LEFT');
				if (array_key_exists("idEstablecimiento", $arrDatos)) {
					$this->db->where('id_establecimiento', $arrDatos["idEstablecimiento"]);
				}
				if (array_key_exists("idManzana", $arrDatos)) {
					$this->db->where('E.fk_id_manzana', $arrDatos["idManzana"]);
				}
				$this->db->where('E.estado != ', 2); //estado diferente a inactivo
				
				//FILTRO POR EL ENCUESTADOR
				if($userRol==3) {					
					$this->db->where('E.fk_id_usuario', $userID);
				}
				//FILTRO POR EL SUPERVISOR
				if($userRol==2) {					
					$this->db->where('U.fk_id_jefe', $userID);
				}				
				
				$this->db->order_by('id_establecimiento', 'asc');
				$query = $this->db->get('form_establecimiento E');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit FORM ESTABLECIMIENTO
		 * @since 19/9/2017
		 */
		public function saveEstablecimiento() 
		{
				$idEstablecimiento = $this->input->post('hddId');
				
				$data = array(
					'nombre_propietario' => $this->input->post('nombre'),
					'direccion' => $this->input->post('address2'),
					'telefono' => $this->input->post('telefono'),
					'cedula' => $this->input->post('documento'),
					'fk_id_manzana' => $this->input->post('hddIdManzana'),
					'tipo_documento' => $this->input->post('tipo_documento'),
					'digito' => $this->input->post('digito')
				);	
				
				
				if($this->input->post('latitud') != 0){				
					$data['latitud'] = $this->input->post('latitud');
					$data['longitud'] = $this->input->post('longitud');
					$data['address'] = $this->input->post('address');
				}


				//revisar si es para adicionar o editar
				if ($idEstablecimiento == '') {
					$data['fk_id_usuario'] = $this->session->id;
					$data['fecha_registro'] = date("Y-m-d G:i:s");
					$data['estado'] = 1;
					
					$query = $this->db->insert('form_establecimiento', $data);
					$idEstablecimiento = $this->db->insert_id();

				} else {
					
					$userRol = $this->session->userdata("rol");
					if($userRol == 2 || $userRol == 4){//si es supervisor o coordinador deja guardar el estado
						
						if($userRol == 2){	
							$data['aprobacion_supervisor'] = $this->input->post('estado');
						}elseif($userRol == 4 && $this->input->post('estado')){
							$data['aprobacion_coordinador'] = $this->input->post('estado');
						}
							
							//guardo todos los cambio de estado
							$estado['fk_id_establecimiento'] = $idEstablecimiento;
							$estado['fk_id_usuario'] = $this->session->id;
							$estado['fecha_registro_estado'] = date("Y-m-d G:i:s");
							$estado['estado'] = $this->input->post('estado');							
							$query = $this->db->insert('log_estado_establecimiento', $estado);
							
					}
					
					$this->db->where('id_establecimiento', $idEstablecimiento);
					$query = $this->db->update('form_establecimiento', $data);
				}
				if ($query) {
					return $idEstablecimiento;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista manzanas
		 * @since 19/9/2017
		 */
		public function get_manzanas($arrDatos) 
		{		
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
		
				$this->db->select('U.nombres_usuario, U.apellidos_usuario, M.*, CONCAT(K.nombres_usuario, " ", K.apellidos_usuario) jefe');
				$this->db->join('usuario U', 'U.id_usuario = M.fk_id_usuario', 'INNER');
				$this->db->join('usuario K', 'K.id_usuario = U.fk_id_jefe', 'LEFT');
				if (array_key_exists("idManzana", $arrDatos)) {
					$this->db->where('M.id_manzana', $arrDatos["idManzana"]);
				}
				//FILTRO POR EL ENCUESTADOR
				if($userRol==3) {					
					$this->db->where('M.fk_id_usuario', $userID);
				}
				//FILTRO POR EL SUPERVISOR
				if($userRol==2) {					
					$this->db->where('U.fk_id_jefe', $userID);
				}
				$this->db->where('M.estado', 1); //solo muestra las activas
				
				$this->db->order_by('M.id_manzana', 'asc');
				$query = $this->db->get('form_manzana M');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit MANZANA
		 * @since 19/9/2017
		 */
		public function saveManzana() 
		{
				$identificador = $this->input->post('hddId');
				
				$data = array(
					'fk_id_sector' => $this->input->post('sector'),
					'fk_id_seccion' => $this->input->post('seccion'),
					'fk_id_manzana' => $this->input->post('manzana'),
					'fk_id_comuna' => $this->input->post('comuna'),
					'barrio' => $this->input->post('barrio')
				);
				
				//revisar si es para adicionar o editar
				if ($identificador == '') {
					$data['fk_id_usuario'] = $this->session->id;
					$data['fecha_creacion'] = date("Y-m-d G:i:s");
					$data['estado'] = 1;
					$query = $this->db->insert('form_manzana', $data);
					$identificador = $this->db->insert_id();				
				} else {
					$this->db->where('id_manzana', $identificador);
					$query = $this->db->update('form_manzana', $data);
				}
				if ($query) {
					return $identificador;
				} else {
					return false;
				}
		}
		
		/**
		 * Info formulario administrativa
		 * @since 21/9/2017
		 */
		public function get_form_administrativa($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormAdministrativa", $arrDatos)) {
					$this->db->where('A.id_administrativa', $arrDatos["idFormAdministrativa"]);
				}
				
				$query = $this->db->get('form_administrativa A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form administrativa
		 * @since 21/9/2017
		 */
		public function add_form_administrativa() 
		{
			$idFormAdministrativa = $this->input->post('hddIdFormAdministrativa');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'visible' => $this->input->post('visible'),
				'aviso' => $this->input->post('aviso'),
				'matricula' => $this->input->post('matricula'),
				'porqueno' => $this->input->post('porqueno'),
				'estado_actual' => $this->input->post('estado_actual'),
				'establecimiento' => $this->input->post('establecimiento'),
				'tiempo' => $this->input->post('tiempo'),
				'rut' => $this->input->post('rut'),
				'cual' => $this->input->post('cual')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormAdministrativa == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_administrativa');

						if ($query->num_rows() > 0) {
							return false;
						} else {
							$data['fecha_registro'] = date("Y-m-d G:i:s");
							$query = $this->db->insert('form_administrativa', $data);				
						}				

			} else {
				$this->db->where('id_administrativa', $idFormAdministrativa);
				$query = $this->db->update('form_administrativa', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Info formulario actividad economica
		 * @since 21/9/2017
		 */
		public function get_form_actividad_economica($arrDatos) 
		{
				$this->db->select();
				$this->db->join('param_actividad_economica P', 'P.id_param_actividad_economica = A.division', 'LEFT');
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormActividadEconomica", $arrDatos)) {
					$this->db->where('A.id_actividad_economica', $arrDatos["idFormActividadEconomica"]);
				}
				
				$query = $this->db->get('form_actividad_economica A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form actividad economica
		 * @since 21/9/2017
		 */
		public function add_form_actividad_economica() 
		{
			$idFormActividadEconomica = $this->input->post('hddIdFormActividadEconomica');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'fk_id_seccion' => $this->input->post('actividad'),
				'numero_personas' => $this->input->post('numero_personas'),
				'seguridad_social' => $this->input->post('seguridad_social'),
				'lugar' => $this->input->post('lugar'),
				'descripcion' => $this->input->post('descripcion'),
				'division' => $this->input->post('division')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormActividadEconomica == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_actividad_economica');

						if ($query->num_rows() > 0) {
							return false;
						} else {
							$data['fecha_registro'] = date("Y-m-d G:i:s");
							$query = $this->db->insert('form_actividad_economica', $data);				
						}

			} else {
				$this->db->where('id_actividad_economica', $idFormActividadEconomica);
				$query = $this->db->update('form_actividad_economica', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Info formulario criticos
		 * @since 21/9/2017
		 */
		public function get_form_criticos($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormCriticos", $arrDatos)) {
					$this->db->where('A.id_criticos', $arrDatos["idFormCriticos"]);
				}
				
				$query = $this->db->get('form_criticos A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form criticos
		 * @since 21/9/2017
		 */
		public function add_form_criticos() 
		{
			$idFormCriticos = $this->input->post('hddIdFormCriticos');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'financiamiento' => $this->input->post('financiamiento'),
				'ausencia' => $this->input->post('ausencia'),
				'capacitacion' => $this->input->post('capacitacion'),
				'competencia' => $this->input->post('competencia'),
				'ambiental' => $this->input->post('ambiental'),
				'seguridad' => $this->input->post('seguridad'),
				'ventas' => $this->input->post('ventas'),
				'proveedores' => $this->input->post('proveedores'),
				'otros' => $this->input->post('otros'),
				'ninguno' => $this->input->post('ninguno'),
				'cuales' => $this->input->post('cuales')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormCriticos == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_criticos');

						if ($query->num_rows() > 0) {
							return false;
						} else {
							$data['fecha_registro'] = date("Y-m-d G:i:s");
							$query = $this->db->insert('form_criticos', $data);
						}
				
			} else {
				$this->db->where('id_criticos', $idFormCriticos);
				$query = $this->db->update('form_criticos', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Info formulario financiera
		 * @since 21/9/2017
		 */
		public function get_form_financiera($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormFinanciera", $arrDatos)) {
					$this->db->where('A.id_financiera', $arrDatos["idFormFinanciera"]);
				}
				
				$query = $this->db->get('form_financiera A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form financiera
		 * @since 21/9/2017
		 */
		public function add_form_financiera() 
		{
			$idFormFinanciera = $this->input->post('hddIdFormFinanciera');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'ingresos' => $this->input->post('ingresos'),
				'contabilidad' => $this->input->post('contabilidad'),
				'mercadeo' => $this->input->post('mercadeo'),
				'planeacion' => $this->input->post('planeacion'),
				'servicio' => $this->input->post('servicio'),
				'produccion' => $this->input->post('produccion'),
				'iso' => $this->input->post('iso'),
				'otros' => $this->input->post('otros'),
				'cuales' => $this->input->post('cuales'),
				'impuestos' => $this->input->post('impuestos')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormFinanciera == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_financiera');

						if ($query->num_rows() > 0) {
							return false;
						} else {
							$data['fecha_registro'] = date("Y-m-d G:i:s");
							$query = $this->db->insert('form_financiera', $data);
						}

				
			} else {
				$this->db->where('id_financiera', $idFormFinanciera);
				$query = $this->db->update('form_financiera', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Info formulario servicios
		 * @since 21/9/2017
		 */
		public function get_form_servicios($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormServicios", $arrDatos)) {
					$this->db->where('A.id_servicios', $arrDatos["idFormServicios"]);
				}
				
				$query = $this->db->get('form_servicios A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form servicios
		 * @since 21/9/2017
		 */
		public function add_form_servicios() 
		{
			$idFormServicios = $this->input->post('hddIdFormServicios');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'motivo' => $this->input->post('motivo'),
				'productos' => $this->input->post('productos'),
				'procesos' => $this->input->post('procesos'),
				'capacitacion' => $this->input->post('capacitacion'),
				'mercadeo' => $this->input->post('mercadeo'),
				'nuevos' => $this->input->post('nuevos'),
				'informaticos' => $this->input->post('informaticos'),
				'innovacion' => $this->input->post('innovacion'),
				'tramites' => $this->input->post('tramites'),
				'participacion' => $this->input->post('participacion'),
				'financiamiento' => $this->input->post('financiamiento'),				
				'proyectos' => $this->input->post('proyectos'),
				'otro' => $this->input->post('otro'),
				'cual_motivo' => $this->input->post('cual_motivo'),
				'cual_fortalecer' => $this->input->post('cual_fortalecer')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormServicios == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_servicios');

						if ($query->num_rows() > 0) {
							return false;
						} else {
								$data['fecha_registro'] = date("Y-m-d G:i:s");
								$query = $this->db->insert('form_servicios', $data);				
						}

			} else {
				$this->db->where('id_servicios', $idFormServicios);
				$query = $this->db->update('form_servicios', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Info formulario formalizacion
		 * @since 21/9/2017
		 */
		public function get_form_formalizacion($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				if (array_key_exists("idFormFormalizacion", $arrDatos)) {
					$this->db->where('A.id_formalizacion', $arrDatos["idFormFormalizacion"]);
				}
				
				$query = $this->db->get('form_formalizacion A');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add form formalizacion
		 * @since 21/9/2017
		 */
		public function add_form_formalizacion() 
		{
			$idFormFormalizacion = $this->input->post('hddIdFormFormalizacion');
			$idFormulario = $this->input->post('hddIdentificador');
			
			$data = array(
				'fk_id_formulario' => $idFormulario,
				'fk_id_usuario' => $this->session->userdata("id"),
				'formalizar' => $this->input->post('formalizar'),
				'motivo' => $this->input->post('motivo'),
				'asesoria_mercados' => $this->input->post('asesoria_mercados'),
				'apoyo' => $this->input->post('apoyo'),
				'asesoria_juridica' => $this->input->post('asesoria_juridica'),
				'capacitacion' => $this->input->post('capacitacion'),
				'tecnologias' => $this->input->post('tecnologias'),
				'participacion' => $this->input->post('participacion'),
				'simplificacion' => $this->input->post('simplificacion'),
				'tramites' => $this->input->post('tramites'),
				'creditos' => $this->input->post('creditos'),
				'impuestos' => $this->input->post('impuestos')
			);
			
			//revisar si es para adicionar o editar
			if ($idFormFormalizacion == '') {
				
						//verificar que no existe un registro con ese formulario
						$this->db->select();
						$this->db->where('fk_id_formulario', $idFormulario);
						$query = $this->db->get('form_formalizacion');

						if ($query->num_rows() > 0) {
							return false;
						} else {
							$data['fecha_registro'] = date("Y-m-d G:i:s");
							$query = $this->db->insert('form_formalizacion', $data);				
						}
				
				

			} else {
				$this->db->where('id_formalizacion', $idFormFormalizacion);
				$query = $this->db->update('form_formalizacion', $data);
			}
			
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Sector by comuna
		 * @since 22/9/2017
		 */
		public function get_sector_by($arrDatos)
		{			
				$sector = array();
				$this->db->select("DISTINCT(sector)");
				if (array_key_exists("idComuna", $arrDatos)) {
					$this->db->where('comuna', $arrDatos["idComuna"]);
				}
								
				$this->db->order_by('sector', 'asc');
				$query = $this->db->get('param_comuna');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$sector[$i]["idSector"] = $row->sector;
						$i++;
					}
				}
				$this->db->close();
				return $sector;
		}
		
		/**
		 * Seccion by sector
		 * @since 22/9/2017
		 */
		public function get_seccion_by($arrDatos)
		{			
				$seccion = array();
				$this->db->select("DISTINCT(seccion)");
				if (array_key_exists("idSector", $arrDatos)) {
					$this->db->where('sector', $arrDatos["idSector"]);
				}
				if (array_key_exists("idComuna", $arrDatos)) {
					$this->db->where('comuna', $arrDatos["idComuna"]);
				}
								
				$this->db->order_by('seccion', 'asc');
				$query = $this->db->get('param_comuna');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$seccion[$i]["idSeccion"] = $row->seccion;
						$i++;
					}
				}
				$this->db->close();
				return $seccion;
		}
		
		/**
		 * Manzana by seccion
		 * @since 22/9/2017
		 */
		public function get_manzana_by($arrDatos)
		{			
				$manzana = array();
				$this->db->select("DISTINCT(manzana)");
				if (array_key_exists("idSeccion", $arrDatos)) {
					$this->db->where('seccion', $arrDatos["idSeccion"]);
				}
				if (array_key_exists("idSector", $arrDatos)) {
					$this->db->where('sector', $arrDatos["idSector"]);
				}
				if (array_key_exists("idComuna", $arrDatos)) {
					$this->db->where('comuna', $arrDatos["idComuna"]);
				}
								
				$this->db->order_by('manzana', 'asc');
				$query = $this->db->get('param_comuna');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$manzana[$i]["idManzana"] = $row->manzana;
						$i++;
					}
				}
				$this->db->close();
				return $manzana;
		}
		
		/**
		 * Listado control encuesta
		 * @since 28/9/2017
		 */
		public function get_control($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				
				if (array_key_exists("idControl", $arrDatos)) {
					$this->db->where('id_control', $arrDatos["idControl"]);
				}
				$this->db->where('estado', 1); //solo muestra las activas
				
				$this->db->order_by('id_control', 'asc');
				$query = $this->db->get('form_control');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit FORM CONTROL
		 * @since 28/9/2017
		 */
		public function saveControl() 
		{
				$idControl = $this->input->post('hddId');
				
				$data = array(
					'fk_id_formulario' => $this->input->post('hddIdFormulario'),
					'resultado_encuesta' => $this->input->post('resultado'),
					'observaciones' => $this->input->post('observaciones'),
					'fecha' => $this->input->post('date')
				);	

				//revisar si es para adicionar o editar
				if ($idControl == '') {
					$data['fecha_registro'] = date("Y-m-d G:i:s");
					$data['estado'] = 1;
					$query = $this->db->insert('form_control', $data);
					$idControl = $this->db->insert_id();
				} else {
					$this->db->where('id_control', $idControl);
					$query = $this->db->update('form_control', $data);
				}
				if ($query) {
					return $idControl;
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de actividades economicas
		 * @since 1/10/2017
		 */
		public function get_lista_actividad_economica() 
		{		
				$this->db->select('distinct(id_seccion), descripcion_seccion_app');
				$query = $this->db->get('param_actividad_economica P');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * DIvision by actividad
		 * @since 2/10/2017
		 */
		public function get_division_by($arrDatos)
		{			
				$lista = array();
				$this->db->select("");
				if (array_key_exists("idActividad", $arrDatos)) {
					$this->db->where('id_seccion', $arrDatos["idActividad"]);
				}

				$query = $this->db->get('param_actividad_economica');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$lista[$i]["ID"] = $row->id_param_actividad_economica;
						$lista[$i]["DESCRIPCION"] = $row->descripcion_division_app;
						$i++;
					}
				}
				$this->db->close();
				return $lista;
		}
		
		/**
		 * Verificar si ya existe la manzana para el usuario en sesion
		 * @since  6/10/2017
		 */
		public function verificarManzana() 
		{
				$this->db->where('fk_id_sector', $this->input->post('sector'));
				$this->db->where('fk_id_seccion', $this->input->post('seccion'));
				$this->db->where('fk_id_manzana', $this->input->post('manzana'));
				$this->db->where('fk_id_comuna', $this->input->post('comuna'));
				$this->db->where('fk_id_usuario', $this->session->id);
				$query = $this->db->get("form_manzana");
		

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Ultimo registro de control
		 * @since 8/10/2017
		 */
		public function get_last_record_control($arrDatos) 
		{
				$this->db->select();
				if (array_key_exists("idFormulario", $arrDatos)) {
					$this->db->where('fk_id_formulario', $arrDatos["idFormulario"]);
				}
				$this->db->where('estado', 1); //solo muestra las activas
				
				$this->db->order_by('id_control', 'desc');
				$query = $this->db->get('form_control');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * updateAddressEstablecimiento
		 * @since 30/10/2017
		 */
		public function updateAddressEstablecimiento() 
		{
				$idEstablecimiento = $this->input->post('hddId');
							
				if($this->input->post('latitud') != 0){				
					$data['latitud'] = $this->input->post('latitud');
					$data['longitud'] = $this->input->post('longitud');
					$data['address'] = $this->input->post('address');
					
					
					$this->db->where('id_establecimiento', $idEstablecimiento);
					$query = $this->db->update('form_establecimiento', $data);
				}

				if ($query) {
					return true;
				} else {
					return false;
				}
		}





	
	    
	}