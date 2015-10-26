<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servicos_cancelados_autorizados extends MX_Controller {

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
    $listar_cancelados_nao_autorizados = $this->servicos_concluidos_model->listarServicos();
    //var_dump( $listar_cancelados_nao_autorizados);

    if($listar_cancelados_nao_autorizados===FALSE){
      $listar_nenhum_servico=false;
      $cancelados_nao_autorizados = $this->load->view('lista_cancelado_autorizado/servicos_cancelados_autorizados', array('listar_nenhum_servico'=>$listar_nenhum_servico), TRUE);
      $this->load->view('layout/index', array('layout' => $cancelados_nao_autorizados ), FALSE);
    }else{
      $cancelados_nao_autorizados = $this->load->view('lista_cancelado_autorizado/servicos_cancelados_autorizados', array('listar_cancelados_nao_autorizados' => $listar_cancelados_nao_autorizados,'listar_nenhum_servico'=>$listar_nenhum_servico), TRUE);
      $this->load->view('layout/index', array('layout' => $cancelados_nao_autorizados ), FALSE);
    }
  }

  public function listarFiltrar() {

    $data=array(
        'intTipo'=>$this->input->get('intTipo'), 
        'data_inicio'=>$this->input->get('data_inicio'), 
        'data_fim'=>$this->input->get('data_fim'),
        );  

    $listar_cancelados_nao_autorizados=$this->servicos_concluidos_model->listarServicosFiltrarCanceladosNaoAutorizados($data);    
    $listar=$this->load->view('lista_cancelado_autorizado/resultado_consulta_lista', array('listar_cancelados_nao_autorizados'=>$listar_cancelados_nao_autorizados), FALSE);
  }
}