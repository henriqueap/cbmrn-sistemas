<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Relatorio_geral extends MX_Controller {
	private $listar_viaturas;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('relatorio_geral_model');
	}

	public function index(){
		$listar=$this->load->view('relatorio_geral/relatorio', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);		 
	}
	
	public function relatorio(){
		$listar_relatorios=$this->relatorio_geral_model->relatorio();
		$listar_lotacoes=$this->relatorio_geral_model->listarLotacoes();
		$listar=$this->load->view('relatorio_geral/relatorio', array('listar_relatorios'=>$listar_relatorios,'listar_lotacoes'=>$listar_lotacoes), TRUE);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);		  
	}
	
		public function relatorioFiltrar(){
			$data = array(
				'idLotacao'=>$this->input->get('idLotacao'), 
				'tipo'=>$this->input->get('tipo'),				
			);
		$listar_relatorios=$this->relatorio_geral_model->relatorioFiltrar($data);
		$listar=$this->load->view('relatorio_geral/resultado_consulta_relatorio', array('listar_relatorios'=>$listar_relatorios), FALSE);
			
	}
}