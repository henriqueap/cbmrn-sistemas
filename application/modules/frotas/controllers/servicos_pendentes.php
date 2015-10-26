<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servicos_pendentes extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('servicos_pendentes_model');
    $this->load->model('odometro_model');
  }



  public function listar() {
    $listar_pendentes = $this->servicos_pendentes_model->listarServicos()->result();
  	$servicos_pendentes = $this->load->view('servicos_pendentes/listar', array('listar_pendentes' => $listar_pendentes), TRUE);
  	$this->load->view('layout/index', array('layout' => $servicos_pendentes ), FALSE);
  }
  public function listarFiltrar() {
    $data = array(
        'data_inicial'=>$this->input->get('data_inicio'), 
        'data_final'=>$this->input->get('data_fim'),         
      );
    $listar_pendentes = $this->servicos_pendentes_model->listarServicosFiltrar($data)->result();
    $servicos_pendentes = $this->load->view('servicos_pendentes/resultado_consulta_pendentes', array('listar_pendentes' => $listar_pendentes), FALSE);
    
  }

   public function detalhamento($id) {    
    $carregarNota = $this->servicos_pendentes_model->carregaNotaFiscal($id);
    $detalhamento = $this->servicos_pendentes_model->detalhamentoServicos($id);
    $detalhamento_servicos = $this->load->view('servico/detalhamento_servico', array('detalhamento' => $detalhamento,'carregarNota' => $carregarNota), TRUE);
    $this->load->view('layout/index', array('layout' => $detalhamento_servicos ), FALSE);
  }

  public function concluirServico($id) {  
    $detalhamento = $this->servicos_pendentes_model->detalhamentoServicos($id);   
    $concluir_servicos = $this->load->view('servico/concluir_servico', array('detalhamento' => $detalhamento), TRUE);
    $this->load->view('layout/index', array('layout' => $concluir_servicos ), FALSE);    
  }

  public function execucaoServico($id) {  
    $detalhamento = $this->servicos_pendentes_model->detalhamentoServicos($id);   
    $concluir_servicos = $this->load->view('servico/iniciar_servico', array('detalhamento' => $detalhamento), TRUE);
    $this->load->view('layout/index', array('layout' => $concluir_servicos ), FALSE);    
  }

  public function atualizarConclusaoServico() { 
     $militar = $this->servicos_pendentes_model->getByIdMilitar();
    if($this->input->server('REQUEST_METHOD')=='POST'){
          $data = array(
              'id'=>$this->input->post('idServico'),
              'data'=>$this->input->post('data'),
              'viaturas_id'=>$this->input->post('idViatura'),
              'militares_id'=>$militar,
              'odometro'=>$this->input->post('txtOdom'),
              'tipo'=>6,
            );  

          $var = $this->servicos_pendentes_model->cadastroRetornoIdOdometroConclusao($data);  
          if($var == false){
              $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!Talvez o seu odometro ou a data de conclusão estejam com valores errados.O odometro deve ser maior ou igual ao anterior da viatura e a data de inicio deve se maior ou igual a data de abertura.'));
             } else{
              $data2 = array(
                'id'=>$this->input->post('idServico'),
                'data_fim'=>$this->input->post('data'),
                'alteracao'=>$this->input->post('txtAlteracao'),
                'odometro_id_conclusao'=>$var,
                'km_oleo'=>$this->input->post('txtOleo'),
                'situacao_id'=>4,
              );

               
              if( $this->servicos_pendentes_model->atualizarServico($data2) == false  ){    
                $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
              } else {
                $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
              }
            }
          redirect('frotas/servicos_pendentes/listar'); 
           
      }
  }

  public function atualizarExecucaoServico() { 
     $militar = $this->servicos_pendentes_model->getByIdMilitar();
    if($this->input->server('REQUEST_METHOD')=='POST'){
          $data = array(
              'id'=>$this->input->post('idServico'),
              'data'=>$this->input->post('data'),
              'viaturas_id'=>$this->input->post('idViatura'),
              'militares_id'=>$militar,
              'odometro'=>$this->input->post('txtOdom'),
              'tipo'=>6,
            ); 

          $var = $this->servicos_pendentes_model->cadastroRetornoIdOdometroExecucao($data);
          if($var == false){
              $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!Talvez o seu odometro ou a data de inicio estejam com valores errados.O odometro deve ser maior ou igual ao anterior da viatura e a data de inicio deve se maior ou igual a data de abertura.'));
             } else{

            $data2 = array(
              'id'=>$this->input->post('idServico'),
              'data_inicio'=>$this->input->post('data'),
              'odometro_id_inicio'=>$var,
              'situacao_id'=>3,
            );

             
          if( $this->servicos_pendentes_model->atualizarServico($data2) == false ){    
              $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
           
          }else{
              $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
            }
          }
          redirect('frotas/servicos_pendentes/listar'); 
           
      }
  }

  public function atualizarStatusCancelado($id){
    if ($this->servicos_pendentes_model->atualizarCancelado($id) == FALSE) {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar status do Serviço!'));        
    } else {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
    }    
    redirect('frotas/servicos_pendentes/listar');  

  }

  public function cadastrarJustificativa() { 
    if($this->input->server('REQUEST_METHOD')=='POST'){
        $data = array(
            'id'=>$this->input->post('idServico'),
            'autorizado'=>$this->input->post('ckbAutorizado'),
            'justificado'=>$this->input->post('txtJustificativa'),
            'situacao_id'=>2
        );
       if( $this->servicos_pendentes_model->atualizarAutorizacao($data) == false){    
            $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
          }
          redirect('frotas/servicos_pendentes/listar');  
    }
  }
} 