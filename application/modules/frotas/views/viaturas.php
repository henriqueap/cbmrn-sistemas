<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Viaturas extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('viaturas_model');
  }

  public function index(){
  	$this->cadastro();
  }

  public function cadastro(){ //carregar a view para cadastro da viatura e listar as marcas ja existentes.
  	$listar_tipo_viaturas = $this->viaturas_model->getByIdTipoViaturas(); //listar os tipos viaturas existentes
    $listar_marcas = $this->viaturas_model->getByIdMarcas(); //listar as marcas limitadas das viaturas.
    $listar_modelos = $this->viaturas_model->getByIdModelo(); //listar os modelos das viaturas.
    $tipo_combustivel = $this->viaturas_model->getByIdCombustiveis(); // listar os tipo dos combustiveis existentes.
    $setor_lotacao = $this->viaturas_model->getByIdSetor(); //listar os setores/lotações disponiveis.
    
    $viaturas = $this->load->view('viaturas/cadastro', array('listar_tipo_viaturas'=>$listar_tipo_viaturas, 'listar_modelos'=>$listar_modelos , 'setor_lotacao'=>$setor_lotacao ,'listar_marcas'=>$listar_marcas , 'tipo_combustivel'=>$tipo_combustivel), TRUE); //arrays que carrega: os setores/lotação, os marcas das viaturas e os combustiveis existentes.
  	$this->load->view('layout/index', array('layout' => $viaturas ), FALSE);
  }

  public function salvar() { //metodo para cadastrar viaturas e tratar erros ao tentar cadastrar 
    if ($this->input->server('REQUEST_METHOD')  === 'POST') {
      $this->form_validation->set_rules('txtPlaca', 'a placa não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtPrefixo', 'o prefixo não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('selModelo', 'campo modelo não preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtNumero', 'Numero do chassis não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtRenavam', 'Renavam não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtLitros', 'Litros não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtOleo', 'Óleo não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtRevisa', 'Revisa não foi preenchido corretamente', 'required');
          
      if ($this->form_validation->run() === FALSE) {
        $this->cadastro();
        } else {
          $data = array(
            'placa' => $this->input->post('txtPlaca'),
            'prefixo' => $this->input->post('txtPrefixo'),
            'tipo_viaturas_id' => $this->input->post('selTipo'),
            'modelo_veiculos_id' => $this->input->post('selModelo'),
            'ano_fabricacao' => $this->input->post('selAnoFab'),
            'ano_modelo' => $this->input->post('selAnoMod'),
            'tracao' => $this->input->post('selTracao'),
            'chassis' => $this->input->post('txtNumero'),
            'renavam' => $this->input->post('txtRenavam'),
            'cor' => $this->input->post('selCor'),
            'lotacoes_id' => $this->input->post('selSetor'),
            'combustivel_id' => $this->input->post('selCombustivel'),
            'chip' => $this->input->post('selChip'),
            'litros_combustivel' => $this->input->post('txtLitros'),
            'km_oleo' => $this->input->post('txtOleo'),
            'km_revisa' => $this->input->post('txtRevisa'),
            'origem' => $this->input->post('selOrigem')
          );

        if ($this->viaturas_model->cadastrar($data) == FALSE) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
        } else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
        }
      }
      redirect('frotas/index'); 
    }
  }

  public function carregaModelos() {
    $marca = $this->input->get('marca');
    $return_modelos = $this->viaturas_model->getModeloVeiculos($marca);
    $this->load->view('viaturas/modelos', array('modelos'=>$return_modelos));
  }   
} 


