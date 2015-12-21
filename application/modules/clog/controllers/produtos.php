<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Produtos extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model(array('produtos_model', 'clog_model', 'cautelas_model'));
    $this->load->library(array('auth'));
    # $this->output->enable_profiler(TRUE);
  }

  /**
   * @param Empty
   */
  public function index() {
    # Index
    $this->cadastro();
  }

  /**
   * @param $data Array
   */
  public function cadastro($data = "") {
    $produtos = $this->clog_model->listar('grupo_produtos')->result();
    $marcas = $this->clog_model->listar('marcas_produtos')->result();

    # Carregar views.
    $produtos = $this->load->view('produtos/index', array('data' => $data, 'produtos' => $produtos, 'marcas' => $marcas), TRUE);
    $this->load->view('layout/index', array('layout' => $produtos), FALSE);
  }

  /**
   * @param $id int
   */
  public function editar($id) {
    # Editar
    $data = $this->clog_model->listar('produtos', $id)->row();
    if (!$data)
      die();
    else
      $this->cadastro($data);
  }

  /**
   * @param $id int
   */
  public function excluir($id) {
    # Excluir
    $exclusao = $this->clog_model->excluir('produtos', $id);
    $info_produto = $this->produtos_model->detalheProdutos($id)->row();
    if (!$exclusao) {
      # Bloco de auditoria
      $auditoria = array(
          'auditoria' => 'Tentativa de excluir o produto <em>'.$info_produto->modelo.'</em>, de ID n° ' . $id . ' do sistema',
          'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
          'idmodulo' => $this->session->userdata['sistema']
      );
      $this->clog_model->audita($auditoria, 'excluir');
      # .Bloco de auditoria
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro. requisição não concluída!'));
    } else {
      # Bloco de auditoria
      $auditoria = array(
          'auditoria' => 'Excluiu o produto <em>'.$info_produto->modelo.'</em>, de ID n° ' . $id . ' do sistema',
          'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
          'idmodulo' => $this->session->userdata['sistema']
      );
      $this->clog_model->audita($auditoria, 'excluir');
      # .Bloco de auditoria
      $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Excluído com sucesso!'));
    }
    redirect('clog/produtos/index');
  }

  /**
   * @param empty
   */
  public function salvar() {
    # Validação de formulários.
    $this->form_validation->set_rules('modelo', 'modelo', 'trim|required|xss_clean');
    $this->form_validation->set_rules('quantidade_minima', 'quantidade_minima', 'trim|required|xss_clean');

    # Salvar
    if ($this->form_validation->run() == TRUE) {

      # Declarando configurações de arquivos suportados no servidor.
      $this->config = array(
          'upload_path' => dirname($_SERVER["SCRIPT_FILENAME"]) . "/imagens/",
          'upload_url' => base_url() . "imagens/",
          'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|xml",
          'overwrite' => TRUE,
          'max_size' => "10000KB",
          'max_height' => "2048",
          'max_width' => "3072"
      );

      # Adicionando configuirações no servidor.
      $this->load->library('upload', $this->config);
      $this->upload->initialize($this->config);
      $data_upload_file = $this->upload->data();
      # var_dump($data_upload_file);
      # Declarando array e capturando informações via method POST.
      $data = array(
          'id' => $this->input->post('id'),
          'modelo' => $this->input->post('modelo'),
          'quantidade_minima' => $this->input->post('quantidade_minima'),
          'consumo' => $this->input->post('tipo_produto'),
          'marcas_produtos_id' => $this->input->post('marcas_produtos_id'),
          'grupo_produtos_id' => $this->input->post('grupo_produtos_id'),
          'imagem' => $data_upload_file['file_name']
      );

      # Nome do campo file.
      $file_name = 'imagem_ilustrativa';

      if (empty($data['id'])) {
        if ($this->clog_model->salvar('produtos', $data)) {
          $this->load->library('upload', $this->config);
          # Verificar se existe imagens no POST.
          if (empty($data['imagem'])) {
            if ($this->upload->do_upload($file_name))
              echo "file upload success";
            else {
              echo "file upload failed";
              echo $this->upload->display_errors();
            }
          }
          # Bloco de auditoria
          $auditoria = array(
              'auditoria' => 'Incluiu novo produto('.$data['modelo'].') no sistema',
              'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
              'idmodulo' => $this->session->userdata['sistema']
          );
          $this->clog_model->audita($auditoria, 'inserir');
          # .Bloco de auditoria
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
        } else {
          # Bloco de auditoria
          $auditoria = array(
              'auditoria' => 'Tentativa de inclusão de novo produto('.$data['modelo'].') no sistema',
              'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
              'idmodulo' => $this->session->userdata['sistema']
          );
          $this->clog_model->audita($auditoria, 'inserir');
          # .Bloco de auditoria
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar, verifique os campos do formulário ou o arquivo enviado!'));
        }
        # Redirect for produtos.
        redirect('clog/produtos/index');
      } else {
        $info_produto = $this->produtos_model->detalheProdutos( $data['id'])->row();
        if ($this->clog_model->atualizar('produtos', $data)) {
          # Bloco de auditoria
          $auditoria = array(
              'auditoria' => 'Alterou os dados do produto <em>'.$info_produto->modelo.'</em>, de ID n° ' . $data['id'] . ', no sistema',
              'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
              'idmodulo' => $this->session->userdata['sistema']
          );
          $this->clog_model->audita($auditoria, 'alterar');
          # .Bloco de auditoria
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
        } else {
          # Bloco de auditoria
          $auditoria = array(
              'auditoria' => 'Tentativa de alterar os dados do produto <em>'.$info_produto->modelo.'</em>, de ID n° ' . $data['id'] . ', no sistema',
              'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
              'idmodulo' => $this->session->userdata['sistema']
          );
          $this->clog_model->audita($auditoria, 'alterar');
          # .Bloco de auditoria
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
        }
        # Redirect for produtos.
        redirect('clog/produtos/index');
      }
    }
  }

  /**
   * @param empty.
   */
  public function consulta() {
    # Consulta.
    $grupo = $this->clog_model->listar('grupo_produtos')->result();
    $marcas_produtos = $this->clog_model->listar('marcas_produtos')->result();

    # Views.
    $produtos = $this->load->view('produtos/consulta', array('grupo_produtos' => $grupo, 'marcas_produtos' => $marcas_produtos), TRUE);
    $this->load->view('layout/index', array('layout' => $produtos), FALSE);
  }

  /**
   * @param empty
   */
  public function estoque() {
    # Listar empresas.
    $listar_empresas = $this->clog_model->listar('empresas')->result();
    # Listar Marcas de Produtos
    $listar_marcas = $this->clog_model->listar('marcas_produtos')->result();
    # Listar Grupos de Produtos
    $grupo = $this->clog_model->listar('grupo_produtos')->result();
    # Listar Setores
    $setores = $this->clog_model->getLotacoes()->result();
    $produtos = $this->load->view('produtos/estoque', array('grupo_produtos' => $grupo, 'empresa' => $listar_empresas, 'marcas' => $listar_marcas, 'setores' => $setores), TRUE);
    $this->load->view('layout/index', array('layout' => $produtos), FALSE);
  }

  public function consulta_estoque() {
    # Consulta Estoque.
    $filter = array();
    if ($this->input->get('zerados') != "true")
      $filter['zerados'] = $this->input->get('zerados');
    if ($this->input->get('tipo') != "") 
      $filter['tipo'] = $this->input->get('tipo');
    if ($this->input->get('grupo_produtos') != "") 
      $filter['grupo_produtos_id'] = $this->input->get('grupo_produtos');
    if ($this->input->get('modelo') != "")
      $filter['modelo'] = $this->input->get('modelo');
    if ($this->input->get('marcas') != 0)
      $filter['marcas_produtos_id'] = $this->input->get('marcas');
    if ($this->input->get('almox') != 0)
      $filter['lotacoes_id'] = $this->input->get('almox');

    $consulta = $this->produtos_model->consulta_produtos_estoque($filter)->result();
    # Bloco de auditoria
    /* $auditoria = array(
      'auditoria'=>'Consultou o estoque de produtos',
      'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
      'idmodulo'=>$this->session->userdata['sistema']
      );
      $this->clog_model->audita($auditoria, 'consultar'); */
    # .Bloco de auditoria
    $this->load->view('produtos/resultado_consulta_estoque', array('consulta' => $consulta), FALSE);
  }

  public function lista_produtos_estoque() {
    # Consulta Estoque.
    $filter = array();
    if ($this->input->get('zerados') != "true")
      $filter['zerados'] = $this->input->get('zerados');
    if ($this->input->get('tipo') != "")
      $filter['tipo'] = $this->input->get('tipo');
    if ($this->input->get('modelo') != "")
      $filter['modelo'] = $this->input->get('modelo');
    if ($this->input->get('marcas') != 0)
      $filter['marcas_produtos_id'] = $this->input->get('marcas');
    if ($this->input->get('almox') != 0)
      $filter['lotacoes_id'] = $this->input->get('almox');

    $consulta = $this->produtos_model->consulta_produtos_estoque($filter)->result();
    # Bloco de auditoria
    /* $auditoria = array(
      'auditoria'=>'Consultou o estoque de produtos',
      'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
      'idmodulo'=>$this->session->userdata['sistema']
      );
      $this->clog_model->audita($auditoria, 'consultar'); */
    # .Bloco de auditoria
    $content = $this->load->view('produtos/resultado_consulta_estoque', array('consulta' => $consulta), TRUE);
    $this->load->view('produtos/lista_produtos_estoque', array('layout' => $content), FALSE);
  }

  public function consulta_produtos() {
    # Consulta Estoque.
    $filter = array();

    if ($this->input->get('marcas_produtos_id') != "") {
      $filter['marcas_produtos_id'] = $this->input->get('marcas_produtos_id');
    }

    if ($this->input->get('grupo_produtos') != "") {
      $filter['grupo_produtos_id'] = $this->input->get('grupo_produtos');
    }

    if ($this->input->get('modelo') != "") {
      $filter['modelo'] = $this->input->get('modelo');
    }

    $consulta = $this->produtos_model->consulta_produtos($filter)->result();
    # Bloco de auditoria
    /* $auditoria = array(
      'auditoria'=>'Consultou os produtos no sistema',
      'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
      'idmodulo'=>$this->session->userdata['sistema']
      );
      $this->clog_model->audita($auditoria, 'consultar'); */
    # .Bloco de auditoria
    $this->load->view('produtos/resultado_consulta', array('consulta' => $consulta), FALSE);
  }

  public function printDetProdutos() {
    $tombo = $this->input->get('tombo');
    $tombo_info = $this->produtos_model->produtoByTombo($tombo);
    $historico = $this->produtos_model->historicoByTombo($tombo);
    $this->load->view('clog/produtos/imprime_historico_produto_full', array('historico' => $historico->result(), 'tombo_info' => $tombo_info), FALSE);
  }

  public function detalheProdutos($id) {
    $produtos = $this->produtos_model->detalheProdutos($id)->row();
    $lista_tombos = $this->produtos_model->getTombosProduto($id);
    if (! is_bool($lista_tombos)) {
      foreach ($lista_tombos as $tombo) {
        $tombos[$tombo->tombo] = $this->cautelas_model->getTomboInfo($tombo->tombo);
      }
      $detalhe = $this->load->view('clog/produtos/detalhe_produtos', array('produtos' => $produtos, 'tombos' => $tombos), TRUE); 
    }  
    else
      $detalhe = $this->load->view('clog/produtos/detalhe_produtos', array('produtos' => $produtos), TRUE); 
    $this->load->view('layout/index', array('layout' =>$detalhe), FALSE);
  }

  public function historico_produto() {
    $tombo = $this->input->get('tombo');
    if (!is_bool($tombo)) {
      $tombo_info = $this->produtos_model->produtoByTombo($tombo);
      $historico = $this->produtos_model->historicoByTombo($tombo);
      if (!is_bool($historico) && !is_bool($tombo_info))
        $this->load->view('clog/produtos/historico_produto', array('historico' => $historico->result(), 'tombo_info' => $tombo_info), FALSE);
      else
        return FALSE;
    } else
      return FALSE;
  }

  public function imprime_historico_produto() {
    $tombo = $this->input->get('tombo');
    if (!is_bool($tombo)) {
      $tombo_info = $this->produtos_model->produtoByTombo($tombo);
      $historico = $this->produtos_model->historicoByTombo($tombo);
      if (!is_bool($historico) && !is_bool($tombo_info))
        $this->load->view('clog/produtos/imprime_historico_produto', array('historico' => $historico->result(), 'tombo_info' => $tombo_info), FALSE);
      else
        return FALSE;
    } else
      return FALSE;
  }

}
