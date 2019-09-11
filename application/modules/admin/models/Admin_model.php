<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Admin_model extends CI_Model {

	    
		/**
		 * Verify if the user already exist by the social insurance number
		 * @since  10/5/2017
		 */
		public function verifyUser($arrData) 
		{
				$this->db->where($arrData["column"], $arrData["value"]);
				$query = $this->db->get("usuario");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Verify if the user already exist by the social insurance number
		 * @since  7/6/2017
		 */
		public function verifyCodigoDane() 
		{
				$codigoDane = $this->input->post('codigoDane');
			
				$this->db->where("codigo_dane", $codigoDane);
				$query = $this->db->get("sitios");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Lista de usuarios
		 * @since 10/5/2017
		 */
		public function get_users($arrDatos) 
		{
				$this->db->select("U.*, R.*, J.nombres_usuario nombre_jefe, J.apellidos_usuario apellido_jefe");
				$this->db->join('param_roles R', 'R.id_rol = U.fk_id_rol', 'INNER');
				$this->db->join('usuario J', 'J.id_usuario = U.fk_id_jefe', 'LEFT');
				if (array_key_exists("idUsuario", $arrDatos)) {
					$this->db->where('U.id_usuario', $arrDatos["idUsuario"]);
				}
				if (array_key_exists("idRol", $arrDatos)) {
					$this->db->where('U.fk_id_rol', $arrDatos["idRol"]);
				}
				$this->db->where('U.estado', 1); //solo muestra las activas
				
				$this->db->order_by('nombres_usuario', 'asc');
				$query = $this->db->get('usuario U');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit USER
		 * @since 10/5/2017
		 */
		public function saveUser($clave) 
		{
				$idUser = $this->input->post('hddId');
				
				$data = array(
					'tipo_documento' => $this->input->post('tipoDocumento'),
					'numero_documento' => $this->input->post('documento'),
					'nombres_usuario' => $this->input->post('firstName'),
					'apellidos_usuario' => $this->input->post('lastName'),
					'direccion_usuario' => $this->input->post('address'),
					'telefono_fijo' => $this->input->post('telefono'),
					'celular' => $this->input->post('movilNumber'),
					'email' => $this->input->post('email'),
					'log_user' => $this->input->post('documento'),
					'fk_id_rol' => $this->input->post('rol'),
					'fk_id_jefe' => $this->input->post('jefe')
				);	

				//revisar si es para adicionar o editar
				if ($idUser == '') {
					$data['fecha_creacion'] = date("Y-m-d");
					$data['estado'] = 1;//si es para adicionar se coloca estado inicial como usuario ACTIVO
					$data['password'] = md5($clave);
					$data['clave'] = $clave;
					$query = $this->db->insert('usuario', $data);
					$idUser = $this->db->insert_id();
				} else {
					$data['estado'] = $this->input->post('estado');
					$this->db->where('id_usuario', $idUser);
					$query = $this->db->update('usuario', $data);
				}
				if ($query) {
					return $idUser;
				} else {
					return false;
				}
		}

	    /**
	     * Reset user´s password ---NO SE ESTA USANDO
	     * @since  11/1/2017
	     */
	    public function resetEmployeePassword($idUser)
		{
				$passwd = '123456';
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'state' => 0
				);

				$this->db->where('id_user', $idUser);
				$query = $this->db->update('user', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
	    /**
	     * Actualiar la contraseña del usuario
	     * @since  10/5/2017
	     */
	    public function updatePassword()
		{
				$idUser = $this->input->post("hddId");
				$newPassword = $this->input->post("inputPassword");
				$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
				$passwd = md5($passwd);
				
				$data = array(
					'password' => $passwd,
					'clave' => $newPassword
				);

				$this->db->where('id_usuario', $idUser);
				$query = $this->db->update('usuario', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
	    }
		
		
	    
	}