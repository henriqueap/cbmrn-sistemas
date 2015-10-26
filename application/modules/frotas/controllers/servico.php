<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servico extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('servico_model');
	$this->load->model('odometro_model');
  }

  public function cadastro(){
	$listar_viaturas=$this->odometro_model->listarViaturas();
	$listar_empresas=$this->servico_model->listarEmpresas();
	$listar_servicos=$this->servico_model->listarTipoServicos();
  	
	$servico = $this->load->view('servico/cadastro', array('listar_viaturas'=>$listar_viaturas, 'listar_empresas'=>$listar_empresas,'listar_servicos'=>$listar_servicos), TRUE);
  	$this->load->view('layout/index', array('layout' => $servico ), FALSE);
	if($this->input->server('REQUEST_METHOD')=='POST'){
			
			  $this->form_validation->set_rules('data', 'a data não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('selServico', 'o tipo de servico não foi preenchido corretamente', 'required');
			  $this->form_validation->set_rules('selViatura', 'a viatura não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('selEmpresa', 'a empresa não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('txtDescricao', 'campo não preenchido corretamente', 'required');			  
			
			$data = array(
				'data_abertura'=>$this->input->post('dataIni'),
				'tipo_servicos_id'=>$this->input->post('selTipo'),
				'viaturas_id'=>$this->input->post('selViatura'),
				'id_empresa'=>$this->input->post('selEmpresa'),
				'situacao_id'=>1,
				'alteracao'=>$this->input->post('txtDescricao'),
				);
			$result = $this->servico_model->cadastro($data);
			
			 if ($result == FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O serviço não pode ser cadastro com data diferente da de hoje. Se o serviço for RETROATIVO, por favor cadastrar em Serviços Retroativos.'));				
			  } else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
			  }
			  redirect('frotas/home');
	}
  }
  public function cadastroRetroativo(){
	$listar_viaturas=$this->odometro_model->listarViaturas();
	$listar_empresas=$this->servico_model->listarEmpresas();
	$listar_servicos=$this->servico_model->listarTipoServicos();
  	
	$servico = $this->load->view('servico/cadastro_retroativo', array('listar_viaturas'=>$listar_viaturas, 'listar_empresas'=>$listar_empresas,'listar_servicos'=>$listar_servicos), TRUE);
  	$this->load->view('layout/index', array('layout' => $servico ), FALSE);
	if($this->input->server('REQUEST_METHOD')=='POST'){
			
			  $this->form_validation->set_rules('data', 'a data não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('selServico', 'o tipo de servico não foi preenchido corretamente', 'required');
			  $this->form_validation->set_rules('selViatura', 'a viatura não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('selEmpresa', 'a empresa não foi preenchida corretamente', 'required');
			  $this->form_validation->set_rules('txtDescricao', 'campo não preenchido corretamente', 'required');			  
			
			$data = array(
				'data_abertura'=>$this->input->post('dataIni'),
				'data_inicio'=>$this->input->post('dataIni'),
				'data_fim'=>$this->input->post('dataFim'),
				'tipo_servicos_id'=>$this->input->post('selTipo'),
				'viaturas_id'=>$this->input->post('selViatura'),
				'id_empresa'=>$this->input->post('selEmpresa'),
				'situacao_id'=>4,
				'retroativo'=>1,
				'alteracao'=>$this->input->post('txtDescricao'),
				);
			 if ($this->servico_model->cadastroRetroativo($data) == FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));				
			  } else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
			  }
			  redirect('frotas/home');
	}
  }
}
