<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */

class Relatorios extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('relatorios_model');
		$this->load->model('afastamentos_model');
		$this->load->model('militares_model');
		$this->load->model('ferias_model');
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$relatorios = $this->load->view('relatorios/index', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$relatorios), FALSE);
	}

	public function ferias() {
		$relatorios = $this->load->view('relatorios/index', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$relatorios), FALSE);
	}

	public function afastamentos() {
		$relatorios = $this->load->view('relatorios/index', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$relatorios), FALSE);
	}

	public function relatorio() {
		$html = "<html>";
		$html .= "<head></head>";
		$html .= "<body>Meu arquivo de teste</body>";
		$html .= "</html>";
		
		$this->load->library('mpdf');
		$this->mpdf->mPDF();
		$this->mpdf->WriteHTML($html, 1);	
		$this->mpdf->Output();
	}

	public function ola() {
		echo "Olá";
	}
}
