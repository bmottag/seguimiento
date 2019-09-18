<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("dashboard_model");
    }
	
	/**
	 * Index Page for this controller.
	 */
	public function admin()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$userID = $this->session->userdata("id");
			$data['rol_busqueda'] = "Representantes";
			
			/**
			 * Esta vista solo es para ADMINISTRADORES
			 */
			if($userRol!=1){			
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
	 //inicio consulta de PUESTOS DE VOTACION
			$arrParam = array();
			$data['noSitios'] = $this->dashboard_model->countPuestos($arrParam);//cuenta de sitios
			
	//listado de PUESTOS DE VOTACION
			$arrParam = array();
			$data['infoPuestos'] = $this->general_model->get_puesto($arrParam);
			

			$data["view"] = "dashboard";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Controlador para operadores
	 */
	public function auditor()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$userID = $this->session->userdata("id");
			
	/**
	 * ACA SOLO PUEDE INGRESAR EL USUARIO AUDITOR
	 */
			if($userRol!=2){
				show_error('ERROR!!! - You are in the wrong place.');	
			}
			
			//Busco el ID del sitio
			$arrParam = array('idUsuario' => $userID);
			$data['infoEncargado'] = $this->general_model->get_info_encargado_puesto($arrParam);
			
			$arrParam = array('idPuesto' => $data['infoEncargado'][0]['fk_id_puesto_votacion']);
			$data['infoPuesto'] = $this->general_model->get_puesto($arrParam);

					
//se buscan las alertas asignadas al operador			
			$arrParam = array("tipoAlerta" => 1);
			$data['infoAlertaInformativa'] = $this->dashboard_model->get_alerta_operadors_by($arrParam);
			
			$arrParam = array("tipoAlerta" => 2);
			$data['infoAlertaNotificacion'] = $this->dashboard_model->get_alerta_operadors_by($arrParam);

			$arrParam = array("tipoAlerta" => 3);
			$data['infoAlertaConsolidacion'] = $this->dashboard_model->get_alerta_operadors_by($arrParam);
			
			$data["view"] = "dashboard_auditor";
			$this->load->view("layout", $data);
	}
	
	
	
	
	
	
	
	

/**
 * BASURA DE ACA PARA ABAJO
 */				 
	
	
	
	
	
	
	
	
	
	


	
	/**
	 * Registro de la aceptacion de la alerta informativa
	 * @since 19/5/2017
	 */
	public function registro_informativo()
	{
			$data = array();
			$userRol = $this->session->userdata("rol");
						
			$msj = "Gracias por su respuesta.";
			
			if ($this->dashboard_model->saveRegistroInformativo()) {
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			if($userRol==4){
				redirect("/dashboard/delegados","location",301);
			}else{
				redirect("/dashboard/coordinadores","location",301);	
			}
	}
	
	/**
	 * Registro de la aceptacion de la alerta notificacion
	 * @since 19/5/2017
	 */
	public function registro_notificacion()
	{
			$data = array();
			$userRol = $this->session->userdata("rol");

			$msj = "Gracias por su respuesta.";
			
			$acepta = $this->input->post('acepta');
			$observacion = $this->input->post('observacion');

			if($observacion == ""){
				$this->session->set_flashdata('retornoErrorNotificacion', '<strong>Error!!!</strong> Debe indicar la Observación.');
			}elseif($acepta==""){
				$this->session->set_flashdata('retornoErrorNotificacion', '<strong>Error!!!</strong> Debe indicar su respuesta.');
			}else{
				if ($this->dashboard_model->saveRegistroNotificacion()) {
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$this->session->set_flashdata('retornoErrorNotificacion', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}

			$userRol = $this->session->userdata("rol");
	
			if($userRol==2){
				redirect("/dashboard/auditor","location",301);
			}else{
				redirect("/dashboard/coordinadores","location",301);	
			}
	}
	
	/**
	 * Registro de la aceptacion de la alerta notificacion
	 * @since 19/5/2017
	 */
	public function registro_consolidacion()
	{
			$data = array();
			$userRol = $this->session->userdata("rol");
			$ausentes = $this->input->post('ausentes');
			$ausentesConfirmar = $this->input->post('ausentesConfirmar');
			$citados = $this->input->post('citados');
			
			//buscar datos de la tabla sitio_sesion		
			$infoSitioSesion = $this->dashboard_model->get_info_sitio_sesion();

			$msj = "Gracias por su respuesta.";

			if($ausentes == ""){
				$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> Debe indicar los ausentes.');
			}else{
				if($ausentes < 0){
					$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> La cantidad de ausentes no puede ser menor que 0.');
				}else{				
					if($ausentes != $ausentesConfirmar){
						$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> Confirmar la cantidad de ausentes.');
					}else{				
							if($ausentes > $citados){
								$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> La cantidad de ausentes no puede ser mayor a la cantidad de citados.');
							}else{
								if ($this->dashboard_model->saveRegistroConsolidacion($infoSitioSesion)) {
									$this->session->set_flashdata('retornoExito', $msj);
								} else {
									$this->session->set_flashdata('retornoErrorConsolidacion', '<strong>Error!!!</strong> Contactarse con el Administrador.');
								}
							}
					}
				}
			}

			if($userRol==4){
				redirect("/dashboard/delegados","location",301);
			}else{
				redirect("/dashboard/coordinadores","location",301);	
			}
	}
	
	/**
	 * Controlador para delegados
	 */
	public function delegados()
	{	
			$userRol = $this->session->userdata("rol");
			$userID = $this->session->userdata("id");
	/**
	 * SI es delegado busco en que sitio esta asignado y que sesiones tiene pendientes
	 */
			if($userRol==4){
				$this->load->model("general_model");
				$arrParam = array("idDelegado" => $userID);
				$data['infoSitoDelegado'] = $this->general_model->get_sitios($arrParam);//informacion del sitio asignado al usuario
		
			}else{
				show_error('ERROR!!! - You are in the wrong place.');	
			}
			
			$arrParam = array("tipoAlerta" => 1);
			$data['infoAlertaInformativa'] = $this->dashboard_model->get_alerta_by($arrParam);
			
			$arrParam = array("tipoAlerta" => 2);
			$data['infoAlertaNotificacion'] = $this->dashboard_model->get_alerta_by($arrParam);

			$arrParam = array("tipoAlerta" => 3);
			$data['infoAlertaConsolidacion'] = $this->dashboard_model->get_alerta_by($arrParam);

			//LISTADO DE RESPUESTAS QUE HA DADO EL USUARIO
			$arrParam = array("idSitio" => $data['infoSitoDelegado'][0]['id_sitio']);
			$data['infoRespuestas'] = $this->general_model->get_respuestas_usuario_by($arrParam);


			$data["view"] = "dashboard_delegado";
			$this->load->view("layout", $data);
	}
		
	/**
	 * Controlador para coordinadores
	 */
	public function coordinador()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$userID = $this->session->userdata("id");
			$data['rol_busqueda'] = "Representantes";
	 //inicio consulta de SITIOS
			$arrParam = array("idCoordinador" => $userID);
			$data['noSitios'] = $this->dashboard_model->countSitios($arrParam);//cuenta de sitios
			
	//listado de sitios para el coordinador
			$arrParam = array('idCoordinador' => $userID);
			$data['infoSitios'] = $this->general_model->get_sitios($arrParam);
	/**
	 * ACA SOLO PUEDE INGRESAR EL USUARIO COORDINADOR
	 */
			if($userRol!=3){
				show_error('ERROR!!! - You are in the wrong place.');	
			}
		
//conteo de los sitios segun el filtro
			$data['conteoSitios'] = $this->general_model->get_numero_sitios_por_filtro_by_coordinador($arrParam);
//conteo de citados			
			$data['conteoCitados'] = $this->general_model->get_numero_citados_por_filtro_by_coordinnador();

			/**
			 * INICIO
			 * Listado de alertas
			 * @since 28/7/2017
			 */			 
			 
			 //alertas para el coordinador en sesion
			$this->load->model("specific_model");
			$data["listadoSesiones"] = $this->specific_model->get_sesiones_operador();
		
			/**
			 * FIN
			 */


			/**
			 * INICIO
			 * consultar en las novedades si existe alguna sin responder para colocar un mensaje en el dashboard 
			 * @since 16/8/2017
			 */			 			 

			$arrParam = array("idCoordinador" => $userID);
			$anulaciones = $this->specific_model->get_anulaciones_sin_aprobar($arrParam);
			
			$arrParam = array("idCoordinador" => $userID);
			$cambio_cuadernillo = $this->specific_model->get_cambio_cuadernillo_sin_aprobar($arrParam);
			
			$arrParam = array("idCoordinador" => $userID);
			$holguras = $this->specific_model->get_holguras_sin_aprobar($arrParam);
			
			$arrParam = array("idCoordinador" => $userID);
			$otras = $this->specific_model->get_otras_sin_aprobar($arrParam);
			
			$data['msjNovedades'] = false;
			if($anulaciones || $cambio_cuadernillo || $holguras || $otras){
				$data['msjNovedades'] = "Existen novedades por aprobar:"; 
				if($anulaciones){
					$data['msjNovedades'].= " - Anulaciones";
				}
				if($cambio_cuadernillo){
					$data['msjNovedades'].= " - Cambio de cuadernillo";
				}
				if($holguras){
					$data['msjNovedades'].= " - Holguras";
				}
				if($otras){
					$data['msjNovedades'].= " - Otras novedades";
				}
			}
			
			/**
			 * FIN
			 */

			$data["view"] = "dashboard_coordinador";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Lista de alertas sin respuesta del delegado
	 * @since 24/5/2017
	 * @review 4/6/2017
	 */
	public function respuesta_coordinador($tipoAlerta, $rol)
	{
			$this->load->model("general_model");
			
			$arrParam = array(
							"tipoAlerta" => $tipoAlerta,
							"rol" => $rol
						);
			$data['infoAlertaVencida'] = $this->general_model->get_alertas_vencidas_by($arrParam);
			
			$data["rol"] = $rol;//se pasa el rol del operador o del coordinador
			$data["view"] = "lista_respuestas_faltantes";
						
			$this->load->view("layout", $data);
	}
	
	
	/**
	 * Dashboard directivo
	 */
	public function directivo()
	{	
			$this->load->model("general_model");
			$userRol = $this->session->userdata("rol");
			$userID = $this->session->userdata("id");
			$data['rol_busqueda'] = "Representantes";
	 //inicio consulta de SITIOS
			$arrParam = array();
			$data['noSitios'] = $this->dashboard_model->countSitios($arrParam);//cuenta de sitios
			
	//listado de sitios
			$arrParam = array();
			$data['infoSitios'] = $this->general_model->get_sitios($arrParam);
			
	/**
	 * ACA SOLO PUEDE INGRESAR EL USUARIO COORDINADOR
	 */
			if($userRol!=2){
				show_error('ERROR!!! - You are in the wrong place.');	
			}
			
//conteo de los sitios segun el filtro
			$data['conteoSitios'] = $this->general_model->get_numero_sitios_por_filtro($arrParam);
//conteo de citados			
			$data['conteoCitados'] = $this->general_model->get_numero_citados_por_filtro($arrParam);

			/**
			 * INICIO
			 * Listado de alertas
			 * @since 28/7/2017
			 */			 
			 
			 //alertas para el coordinador en sesion
			$this->load->model("specific_model");
			$data["listadoSesiones"] = $this->specific_model->get_sesiones_operador();
		
			/**
			 * FIN
			 */				 

			$data["view"] = "dashboard_directivo";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Lista de todas las alertas para una alerta especifica
	 * Fltrada para el operador o coordinador de sesion
	 * @since 29/7/2017
	 */
	public function alerta_especifica($idAlerta, $rol, $respuesta="")
	{
			$this->load->model("specific_model");
			$this->load->model("general_model");

			//consultar informacion de la alerta
			$arrParam = array("idAlerta" => $idAlerta);
			$data['infoAlerta'] = $this->specific_model->get_info_alerta($arrParam);
				

			//se buscan las alertas INFORMATIVAS que se tienen el OPERADOR a cargo
			$data['infoAlertaVencida'] = $this->general_model->get_alertas_vencidas_by($arrParam);

			
			$data["rol"] = $rol;//se pasa el rol del operador o del coordinador
			
			$data["view"] = "lista_respuestas_por_alerta";
			switch ($respuesta) {
				case "contestaron":
					$data["answer"] = $respuesta;
					break;
				case "si":
					$data["answer"] = $respuesta;
					break;
				case "no":
					$data["answer"] = $respuesta;
					break;
				default:
					$data["view"] = "lista_respuestas_faltantes_por_alerta";
			}
						
			$this->load->view("layout", $data);
	}
	
	/**
	 * Formulario para seleccionar los ausentes
     * @since 3/11/2017
	 */
	public function ausentes($codigoDane, $idSesion)
	{
			$this->load->helper('form');
			$this->load->model("general_model");
			
			$data['codigoDane'] = $codigoDane;
			$data['idSesion'] = $idSesion;
			
			$arrParam = array("codigoDane" => $codigoDane, "idSesion" => $idSesion);
			$data['infoExaminandos'] = $this->general_model->get_examinandos($arrParam);//info lista de examinandos por sitio

			$data["view"] = 'ausentes';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar ausentes
     * @since 3/11/2017
     * @author BMOTTAG
	 */
	public function save_ausentes()
	{			
			header('Content-Type: application/json');
			$data = array();
			$codigoDane = $this->input->post('hddCodigoDane');
			$idSesion = $this->input->post('hddIdSesion');
			$data["idRecord"] = $codigoDane . "/" . $idSesion;

			if ($this->dashboard_model->guardar_ausentes($codigoDane, $idSesion)) {
				$data["result"] = true;
				$data["mensaje"] = "Solicitud guardada correctamente.";
				
				$this->session->set_flashdata('retornoExito', 'Solicitud guardada correctamente.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error al guardar. Intente nuevamente o actualice la p\u00e1gina.";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Intente nuevamente o actualice la p\u00e1gina');
			}

			echo json_encode($data);
    }

	
	
}

