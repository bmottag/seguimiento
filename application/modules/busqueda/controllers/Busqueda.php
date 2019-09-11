<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busqueda extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("busqueda_model");
		$this->load->library('PHPExcel.php');
    }
	
	/**
	 * Search
     * @since 26/10/2017
	 */
    public function index() 
	{
			$data["view"] = "form_search";
			
			//Si envian los datos del filtro entonces lo direcciono a la lista respectiva con los datos de la consulta
			if($_POST)
			{				
				$arrParam = array(
					"idEstablecimiento" => $this->input->post('idEncuesta'),
					"nombre" => $this->input->post('nombre'),
					"documento" => $this->input->post('documento')
				);
				
				$data['info'] = $this->busqueda_model->get_establecimientos($arrParam);
				

				$data["view"] = "lista_establecimientos";
			}
			
			$this->load->view("layout", $data);
    }
	
	
	/**
	 * Lista de nombres de establecimientos
     * @since 26/10/2017
	 */
    public function nombreList() 
	{
        header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
				
		//company list
		$arrParam = array(
			"nombre" => $this->input->post('nombre') 
		);
		$lista = $this->busqueda_model->get_establecimientos($arrParam);
		
        if ($lista) {
			echo json_encode(array('res' => 'full', 'data' => $lista));
        }else{
        	echo json_encode(array('res' => 'empty'));
        }
    }
	
	/**
	 * Generate Reporte en XLS
     * @since 29/10/2017
	 */
	public function generaReporteXLS()
	{
			$info = $this->busqueda_model->get_informacion();
echo $this->db->last_query() . "<br><br>";
			echo json_encode($info); exit;
			
			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("CEIV-CCV APP")
										 ->setLastModifiedBy("CEIV-CCV APP")
										 ->setTitle("Report")
										 ->setSubject("Report")
										 ->setDescription("CEIV-CCV Report.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Report");
										 
			// Create a first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'REPORTE TOTAL ENCUESTA CEIV-CCV');
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'ID ESTABLECIMIENTO')
										->setCellValue('B4', 'Nombre propietario')
										->setCellValue('C4', 'Dirección')
										->setCellValue('D4', 'No. documento')
										->setCellValue('E4', 'Fecha registro')
										->setCellValue('F4', 'Encuestador')
										->setCellValue('G4', 'Sector')
										->setCellValue('H4', 'Sección')
										->setCellValue('I4', 'Manzana')
										->setCellValue('J4', 'Comuna')
										->setCellValue('K4', 'Barrio')
										->setCellValue('L4', 'visible')
										->setCellValue('M4', 'aviso')
										->setCellValue('N4', 'matricula')
										->setCellValue('O4', 'porqueno')
										->setCellValue('P4', 'estado_actual');													
			
			$j=5;
			foreach ($info as $data):
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['name'])
												  ->setCellValue('B'.$j, $data['start'])
												  ->setCellValue('C'.$j, $data['finish'])
												  ->setCellValue('D'.$j, $data['job_start'])
												  ->setCellValue('E'.$j, $data['job_finish'])
												  ->setCellValue('F'.$j, $data['task_description'])
												  ->setCellValue('G'.$j, $data['observation'])
												  ->setCellValue('H'.$j, $data['working_hours'])
												  ->setCellValue('I'.$j, $data['fk_id_manzana'])
												  ->setCellValue('J'.$j, $data['fk_id_comuna'])
												  ->setCellValue('K'.$j, $data['barrio'])
												  ->setCellValue('L'.$j, $data['visible'])
												  ->setCellValue('M'.$j, $data['aviso'])
												  ->setCellValue('N'.$j, $data['matricula'])
												  ->setCellValue('O'.$j, $data['porqueno'])
												  ->setCellValue('P'.$j, $data['estado_actual']);
					$j++;
			endforeach;         


			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(40);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('Work Order');

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	
	/**
	 * Search
     * @since 29/10/2017
	 */
    public function mapa($idEstablecimiento) 
	{
			$arrParam = array(
				"idEstablecimiento" => $idEstablecimiento
			);
			
			$data['info'] = $this->busqueda_model->get_establecimientos($arrParam);
			
			$data["view"] = "mapa";
			$this->load->view("layout", $data);
    }

	
	
	
	
	
	
	
	
	
	

	
}