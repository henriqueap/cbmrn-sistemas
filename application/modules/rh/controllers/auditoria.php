<?php 
/**
* 
*/
class Auditoria extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$auditoria = $this->load->view('auditoria/index', '', TRUE); 
		$this->load->view('layout/index', array('layout'=>$auditoria), FALSE);
	}

	public function consulta() {
		$auditoria = $this->load->view('auditoria/index', '', TRUE); 
		$this->load->view('layout/index', array('layout'=>$auditoria), FALSE);
	}
}

