<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class almanaque extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('almanaque_model');
		$this->load->helper(array('cbmrn', 'file'));
		//$this->load->library('auth');
		//$this->output->enable_profiler(TRUE);
	}

	public function index() {
		$areas=$this->cursos_model->listarAreas();
		$conteudo = $this->load->view('cursos/cadastro_area', array('listar_areas' => $areas) , TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}



}
