<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servicos_concluidos extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('servicos_concluidos_model');
  }

  public function index(){
    $index=$this->load->view('welcome/index', '', TRUE);
    $this->load->view('layout/index', array('layout'=>$index), FALSE);

  }

  public function listar() {
    $listar_nenhum_servico = $this->servicos_concluidos_model->listarNenhumServico();
    $listar_concluidos = $this->servicos_concluidos_model->listarServicos();  
    $listar_viaturas = $this->servicos_concluidos_model->listarViaturas();

    if($listar_concluidos === FALSE){       
      $listar_nenhum_servico=false;
      $servicos_concluidos = $this->load->view('servicos_concluidos/listar', array('listar_nenhum_servico'=>$listar_nenhum_servico,'listar_concluidos' => $listar_concluidos, 'listar_viaturas'=>$listar_viaturas), TRUE);
      $this->load->view('layout/index', array('layout' => $servicos_concluidos ), FALSE);
    }else{
    
    	$servicos_concluidos = $this->load->view('servicos_concluidos/listar', array('listar_nenhum_servico'=>$listar_nenhum_servico,'listar_viaturas'=>$listar_viaturas,'listar_concluidos' => $listar_concluidos), TRUE);
    	$this->load->view('layout/index', array('layout' => $servicos_concluidos ), FALSE);
    }
  }

  public function listarFiltrar($id="") {

    $data=array(
        'viaturas_id'=>$this->input->get('viaturas_id'), 
        'data_inicio'=>$this->input->get('data_inicio'), 
        'data_fim'=>$this->input->get('data_fim'),
        );  

    $listar_concluidos=$this->servicos_concluidos_model->listarServicosFiltrar($data);
    //var_dump($listar_concluidos);
    $listar=$this->load->view('servicos_concluidos/resultado_consulta_lista', array('listar_concluidos'=>$listar_concluidos), FALSE);
  }

  public function atualizarStatusEntregue(){

    $data=array(
      'id'=>$this->input->post('idServico'),
      'situacao_id'=>5,
      'data_entrega'=>$this->input->post('data'),
      );
      $var=$this->servicos_concluidos_model->atualizarEntrega($data);      
    if ($var == FALSE) {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar status do Serviço!'));        
    } else {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
    } 
     redirect('frotas/servicos_concluidos/listar');   
  }
}