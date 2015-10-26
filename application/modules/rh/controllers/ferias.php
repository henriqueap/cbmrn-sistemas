<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @version 1.0
 */
class Ferias extends MX_Controller {

  function __construct() {
    parent::__construct();
    # Diretamente usada em uma view para executar a função date().
    date_default_timezone_set('America/Recife');
    $this->load->model('ferias_model');
    $this->load->model('militares_model');
    $this->load->model('afastamentos_model');
    $this->load->helper('cbmrn');
    # $this->output->enable_profiler(TRUE);
  }

  public function index() {
    $this->consulta();
  }

  /**
   * @param empty 
   * Cadastro de turma de férias.
   */
  public function cadastro($data = "") {
    $conteudo = $this->load->view('ferias/cadastro', array('data' => $data), TRUE);
    $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
  }

  /**
   * @param empty 
   * Consulta de turma de férias.
   */
  public function consulta() {
    $conteudo = $this->load->view('ferias/consulta', '', TRUE);
    $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
  }

  /**
   * @param empty 
   * Editar de turma de férias.
   */
  public function editar($id) {
    $data = $this->ferias_model->getById($id);
    $this->cadastro($data);
  }

  /**
   * @param empty 
   * Excluír turma de férias.
   */
  public function excluir($id) {
    $this->ferias_model->excluir($id);
    redirect('rh/ferias/consulta');
  }

  /**
   * @param empty 
   * Salvar turma de férias.
   */
  public function salvar() {
    # Method respónsavel por salvar dados das turmas de férias.
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
      $this->form_validation->set_rules('numero', 'Número da Turma', 'required');
      $this->form_validation->set_rules('data_inicio', 'Data de Início', 'required');
      $this->form_validation->set_rules('exercicio', 'Exercicio', 'required|max_length[4]');

      if ($this->form_validation->run() === FALSE) {
        $this->cadastro();
      } else {
        $data = array(
          'id' => $this->input->post('id'),
          'numero' => $this->input->post('numero'),
          'data_inicio' => $this->input->post('data_inicio'),
          'exercicio' => $this->input->post('exercicio')
        );

        if (empty($data['id'])) {
            if ($this->ferias_model->salvar($data)) {
              $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
            } else {
              $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
            }
        } else {
          if ($this->ferias_model->atualizar($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
          }
        }

        # Redirecionar para página de consulta.
        redirect('rh/ferias/consulta/');
      }
    }
  }

  /**
   * @param empty 
   * Consultar turmas de férias.
   */
  public function consultar_turma() {
    $filter = array();

    if ($this->input->get("numero") != "") {
      $filter['numero'] = $this->input->get("numero");
    }

    if ($this->input->get("exercicio") != "") {
      $filter['exercicio'] = $this->input->get("exercicio");
    }

    $turma = $this->ferias_model->getTurmaFerias($filter, TRUE);
    $this->load->view('rh/ferias/resultado_consulta', array('turma' => $turma), FALSE);
  }

  /**
   * @param empty 
   * Cadastro de férias dos militares.
   */
  public function cadastro_ferias() {
    # Cadastro de turma de férias.
    if ($this->input->server('REQUEST_METHOD') == "POST") {
      $this->form_validation->set_rules('exercicio', 'Exercício', 'required');
      $this->form_validation->set_rules('numero', 'Número da Turma', 'required');
      $this->form_validation->set_rules('matriculas', 'Matrículas', 'required');

      if ($this->form_validation->run() == FALSE) {
        $this->cadastro_ferias();
      } else {
        # Cadastrar militares em férias.
        $novo_arr = explode(",", $this->input->post('matriculas'));

        # Váriavel abaixo para debug do method POST.
        # $debug = "";
        if (isset($debug)) {
          echo "<pre>";
            var_dump($novo_arr);
          echo "</pre>";
          
          foreach ($novo_arr as $key => $value) {
            echo $key." => ".$value."<br/>";
          }
        } # endif Debug.

        # Pegar dados do post.
        $data = array(
          'exercicio_id'=>$this->input->post('exercicio'),
          'numero_id'=>$this->input->post('numero') 
        );

        # Pegar os valores do array várias vezes e inserir no banco pelo model.
        foreach ($novo_arr as $value) {
          $array_consulta = array(
            'exercicio_id'=>$data['exercicio_id'], 
            'numero_id'=>$data['numero_id'], 
          );

          # Pegar novos dados e salvar todos na tabela militares_ferias.
          $novo_data = array(
            'turma_ferias_id'=>$this->ferias_model->getTurmaFeriasByIdCadastroFerias($array_consulta), 
            'militares_id'=>$this->militares_model->getByMatricula($value, TRUE)
          );

          if (!$this->ferias_model->salvar_ferias($novo_data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
          } else $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
        }

        # Redirecionar página para consulta.
        redirect('rh/ferias/consulta_ferias');
      } # Fim else.
    }

    # Listar campos da tabela turma de férias.
    $ferias = $this->ferias_model->getById();
    
    $conteudo = $this->load->view('ferias/cadastro_ferias', array('ferias'=>$ferias), TRUE);
    $this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
  }

  /**
   * @param empty 
   * Exibir o resultado das consultas de férias dos militares.
   */
  public function resultado_consulta_ferias() {
    # Listar campos da tabela turma de férias.
    $ferias = $this->ferias_model->getById(NULL, 'turma_ferias');

    $conteudo = $this->load->view('ferias/cadastro_ferias', array('ferias' => $ferias), TRUE);
    $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
  }

  /**
   * @param empty 
   * Exibir a página de consulta férias.
   */
  public function consulta_ferias() {
    $conteudo = $this->load->view('ferias/consulta_ferias', array(), TRUE);
    $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
  }

  /**
   * @param empty 
   * Method responsável por pegar via method GET dados sobre exercicio e numero do mesmo, depois filtrar.
   * Fazer relatório sobre as férias do militar(es).
   * NOTA: Busca complexa no model.
   */
  public function consulta_militares_ferias() {
    $filter = array();

    if ($this->input->get("exercicio") != "") {
      $filter['exercicio'] = $this->input->get("exercicio");
    }

    if ($this->input->get("numero") != "") {
      $filter['numero'] = $this->input->get("numero");
    }

    if ($this->input->get("matricula") != "") {
      $filter['chefe_militares_id_hidden'] = $this->input->get("chefe_militares_id_hidden");
    }

    # $resultado_consulta = $this->ferias_model->consulta_militares_ferias($filter);
    # var_dump($resultado_consulta);
    $this->load->view('ferias/consulta_militares_ferias', '', FALSE);
  }

  /**
   * @param $arr $str 
   */
  public function arr_set_index($arr, $str) {
    if (count($arr) != 0) {
      foreach ($arr as $key => $value) {
        $i = $str . '_' . $key;
        $novo_arr[$i] = $value;
      }
      return $novo_arr;
    } else return false;
  }

  /**
   * @param empty
   * Consultar dados pelo exercício.
   */
  public function consultaDadosTurmas() {
    $filter = array();

    if ($this->input->get("exercicio") != "") {
      $filter['exercicio'] = $this->input->get("exercicio");
    }

    $options = $this->ferias_model->getTurmaFerias($filter, FALSE);
    $data = array("options" => $this->arr_set_index($options, 'linha'));
    $this->load->view('ferias/turmas', $data, FALSE);
  }

  /**
   * @param empty 
   * Sustar férias usando a matrícula e o exercício desejado.
   */
  public function sustar_ferias() {

    # Listar exercicios de turmas.
    $turma_ferias = $this->ferias_model->getById()->result();

    # Exibir as views da turma de férias.
    $ferias = $this->load->view('ferias/sustar_ferias', array('turma_ferias' => $turma_ferias), TRUE);
    $this->load->view('layout/index', array('layout' => $ferias), FALSE);
  }

  public function get_militares_ferias() {
    # Pegar filtros enviados pelo GET.
    $filter = array();

    # Filtros.
    if (!$this->input->get("militar") == "") {
      $filter['militar'] = $this->input->get("militar");    
    } else {
      echo "Militar Inexistente ou não possui turma cadastrada neste exercício.";
      exit();
    }

    if (!$this->input->get("exercicio") == "") {
      $filter['exercicio'] = $this->input->get("exercicio");
    } else exit();

    $info_militares = $this->ferias_model->get_info_militares($filter)->row();
    $this->load->view('ferias/resultado_sustar', $info_militares, FALSE);
  }

  /**
   * @param empty
   * Salvar sustar férias, na tabela sustar_ferias com o id da turma de férias do militar e os dias restantes.
   */
  public function salvar_sustar_ferias() {

    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      # Form validation dos dados enviados pelo input hidden do formulário.
      $this->form_validation->set_rules('data_fim', '', 'required');
      $this->form_validation->set_rules('militares_ferias_id', '', 'required');

      # Verificar validação.
      if ($this->form_validation->run() == TRUE) {
        # Pegar valores enviados.
        $data = array(
          'dias'=>abs($this->input->post('data_fim')), 
          'militares_ferias_id'=>$this->input->post('militares_ferias_id')
        );
        
        if (count($this->ferias_model->salvar_sustar($data)) > 0) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Férias sustardas com sucesso!'));
          redirect('rh/ferias/sustar_ferias');
        } else {
          # Exibir erros caso não tenha sido feita com sucesso;
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao sustar férias!'));
          $this->sustar_ferias();
        }
      } else {
        # Exibir erros caso não tenha sido feita com sucesso;
        $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao sustar férias!'));
        redirect('rh/ferias/sustar_ferias');
      }
    }
  }

  /**
   * @param empty
   * Exibir página de reaprazamento das férias.
   */
  public function reaprazamento_ferias() {
    # Listar exercicios de turmas.
    $turma_ferias = $this->ferias_model->getById()->result();
    
    $reaprazamento = $this->load->view('rh/ferias/reaprazamento', array('turma_ferias'=>$turma_ferias), TRUE);
    $this->load->view('layout/index', array('layout' => $reaprazamento), FALSE);
  }

  /**
   * @param empty
   * Pegar informações do militar e sobre o reaprazamento, depois exibir tudo na página.
   */
  public function get_info_reaprazamento() {
    # Capturar method GET enviado.
    $filter = array();

    # Filtros.
    if (!$this->input->get("militar") == "") {
      $filter['militar'] = $this->input->get("militar");    
    } else {
      echo "Militar Inexistente ou não possui turma cadastrada neste exercício.";
      exit();
    }

    if (!$this->input->get("exercicio") == "") {
      $filter['exercicio'] = $this->input->get("exercicio");
    } else exit();

    # Pegar informações sobre as férias do militar.
    $info_militares = $this->ferias_model->get_info_militares($filter)->row();

    # Exibir view do militar.
    $this->load->view('ferias/consulta_reaprazamento', $info_militares, FALSE);
  }

  /**
   * @param empty 
   * Salvar reaprazamento de férias com os dados enviados pelo method POST.
   */
  public function salvar_reaprazamento() {
    if ($this->input->server('REQUEST_METHOD') == 'POST') {
      # Salvar formulário enviado pelo method POST.
      $this->form_validation->set_rules('turma_ferias_id', 'turma de férias', 'required');
      $this->form_validation->set_rules('militares_id', 'militar', 'required');
      $this->form_validation->set_rules('data_inicio', 'data de início', 'required|min_length[10]|max_length[10]');
      $this->form_validation->set_rules('data_fim', 'data de término', 'required');
      $this->form_validation->set_rules('justificativas', 'justificativas', 'required');

      # Idéia ruim, usar uma string para pesquisar em banco de dados FAIL.
      $afastamentos = $this->afastamentos_model->getTipoAfastamentosByTipo('Reaprazamento de Férias');

      # Código... Defeito grave com a manipulação de datas.
      # Quantidade de dias que serão adicionados ao reaprazamento de férias parciais.
      $quant_dias_add = $this->input->post('data_fim');

      # Data de inicio do reaprazamento.
      $data_inicio = date('Y-d-m', strtotime($this->input->post('data_inicio')));

      # Pegar a data final conjunto com a data inicial.
      $data_fim = date('Y-m-d', strtotime(" +" . $quant_dias_add . " days", strtotime($data_inicio)));

      # Verificar validação do form_validation. 
      switch ($this->form_validation->run()) {
        case TRUE:
          # Dados capturados pelo method POST.
          $data = array(
            'turma_ferias_id'=>$this->input->post('turma_ferias_id'), 
            'tipo_afastamentos_id'=>$afastamentos->id, 
            'militares_id'=>$this->input->post('militares_id'), 
            'data_inicio'=>$data_inicio, 
            'data_fim'=>$data_fim, 
            'justificativas'=>$this->input->post('justificativas')
          );
          
          if ($this->ferias_model->salvar_reaprazamento($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Reaprazamento feito com sucesso!'));
            redirect('rh/ferias/reaprazamento_ferias');
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Reaprazamento não foi feito com sucesso!'));
            redirect('rh/ferias/reaprazamento_ferias');
          } break;
        case FALSE:
          $this->reaprazamento_ferias();
          break;
        default:
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Reaprazamento não foi feito com sucesso!'));
          redirect('rh/ferias/reaprazamento_ferias');
          break;
      } # Fim bloco switch
    } else {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Reaprazamento não foi feito com sucesso!'));
      redirect('rh/ferias/reaprazamento_ferias');
    }
  } # Fim Reaprazamentos.
}

