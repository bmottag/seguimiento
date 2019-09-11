<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Busqueda_model extends CI_Model {
	    
		/**
		 * Establecimientos
		 * @since 26/10/2017
		 */
		public function get_establecimientos($arrDatos) 
		{
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
			
				$this->db->select('E.*, M.*, U.nombres_usuario, U.apellidos_usuario, CONCAT(K.nombres_usuario, " ", K.apellidos_usuario) jefe');
				$this->db->join('form_manzana M', 'M.id_manzana = E.fk_id_manzana', 'INNER');
				$this->db->join('usuario U', 'U.id_usuario = E.fk_id_usuario', 'INNER');
				$this->db->join('usuario K', 'K.id_usuario = U.fk_id_jefe', 'LEFT');
				if (array_key_exists("idEstablecimiento", $arrDatos) && $arrDatos["idEstablecimiento"] != '') {
					$this->db->where('id_establecimiento', $arrDatos["idEstablecimiento"]);
				}
				if (array_key_exists("nombre", $arrDatos) && $arrDatos["nombre"] != '') {
					$nombre = '%' . $arrDatos["nombre"] . '%';
					$this->db->where('nombre_propietario LIKE', $nombre);
				}
				if (array_key_exists("documento", $arrDatos) && $arrDatos["documento"] != '') {
					$this->db->where('cedula', $arrDatos["documento"]);
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
		 * Reporte total
		 * @since 29/10/2017
		 */
		public function get_informacion() 
		{
			$cadena_sql = "SELECT E.id_establecimiento, E.nombre_propietario, E.direccion, E.cedula, E.fecha_registro, CONCAT(U.nombres_usuario, ' ', U.apellidos_usuario) encuestador, 
							M.fk_id_sector, M.fk_id_seccion, M.fk_id_manzana, M.fk_id_comuna, M.barrio,
							A.visible, A.visible,A.aviso,A.matricula,A.porqueno,A.estado_actual,A.establecimiento,A.tiempo,A.rut,A.cual,
							AE.fk_id_seccion,AE.numero_personas,AE.seguridad_social,AE.lugar,AE.descripcion,AE.division,
							C.financiamiento,C.ausencia,C.capacitacion,C.competencia,C.ambiental,C.seguridad,C.ventas,C.proveedores,C.otros,C.ninguno,C.cuales,
							F.ingresos,F.contabilidad,F.mercadeo,F.planeacion,F.servicio,F.produccion,F.iso,F.otros,F.cuales,F.impuestos,
							S.motivo,S.productos,S.procesos,S.capacitacion,S.mercadeo,S.nuevos,S.informaticos,S.innovacion,S.tramites,S.participacion,S.financiamiento,S.proyectos,S.otro,S.cual_motivo,S.cual_fortalecer,
							O.formalizar,O.motivo,O.asesoria_mercados,O.apoyo,O.asesoria_juridica,O.capacitacion,O.tecnologias,O.participacion,O.simplificacion,O.tramites,O.creditos,O.impuestos";
			$cadena_sql.= " FROM form_establecimiento E";
			$cadena_sql.= " INNER JOIN usuario U ON U.id_usuario = E.fk_id_usuario";
			$cadena_sql.= " INNER JOIN form_manzana M ON M.id_manzana = E.fk_id_manzana";
			$cadena_sql.= " LEFT JOIN form_administrativa A ON A.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " LEFT JOIN form_actividad_economica AE ON AE.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " LEFT JOIN form_criticos C ON C.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " LEFT JOIN form_financiera F ON F.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " LEFT JOIN form_servicios S ON S.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " LEFT JOIN form_formalizacion O ON O.fk_id_formulario = E.id_establecimiento";
			$cadena_sql.= " WHERE E.estado = 1 AND E.id_establecimiento < 10";
			$cadena_sql.= " ORDER BY E.id_establecimiento";
			
			$query = $this->db->query($cadena_sql);
			$result = $query->result();
			
			return $result;
		}
		
		
	    
	}