<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Clog extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', 'clog_model', 'militares_model', 'cautelas_model'));
		if (FALSE === $this->session->userdata('militar')) {
			$this->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'O sistema fechou por inatividade!'));
			redirect("acesso");
		}
		# $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$welcome = $this->load->view('welcome/index', '', TRUE);
		$this->load->view('layout/index', array('layout' => $welcome), FALSE);
	}

	public function validarTombo() {
		# Passando array
		if ($this->input->get("produto_id") !== FALSE && $this->input->get("tombo") !== FALSE) {
			$numero_tombo = array(
					'produto_id' => $this->input->get("produto_id"),
					'tombo' => $this->input->get("tombo")
			);
		}
		# Passando tombo
		else
			$numero_tombo = $this->input->get("tombo");
		# Validando
		$tombo = $this->cautelas_model->validarTombo($numero_tombo);
		$this->output->set_content_type('application/json');
		if (FALSE !== $tombo) $this->output->set_output(json_encode(array('tombo' => $tombo)));
		else $this->output->set_output(json_encode(array('tombo' => "Indisponível ou não existe no estoque")));
	}

	public function getTombos() {
		$id = $this->input->get("id");
		$estoques_id = $this->input->get("estoque");
		if ($id === FALSE) $id = NULL;
		if ($estoques_id === FALSE) $estoques_id = 23;
		$tombos_produto = $this->cautelas_model->getTombosEstoque($estoques_id, $id);
		if ($tombos_produto !== FALSE) {
			foreach ($tombos_produto as $tombo) {
				$tombo_info = array('produto_id'=>$id, 'tombo'=>$tombo->tombo, 'estoques_id'=>$estoques_id);
				$testaTombo = $this->cautelas_model->validarTombo($tombo_info);
				if((sizeof((array) $testaTombo)) < 12) $tombos_validos[] = array('tombo'=>$tombo->tombo);
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode(array('tombos_produto' => $tombos_validos)));
		} 
		else {
			$this->output->set_content_type('application/json');
			return FALSE;
		}
	}

	public function getProdutos() {
		$data = array(
				'consumo' => $this->input->get("consumo"),
				'estoques_id' => $this->input->get("estoque")
		);
		$produtos = $this->cautelas_model->getProdutos($data);
		//var_dump($produtos); die();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('produtos' => $produtos)));
	}

	public function detalhaProduto($id = NULL) {
		if (is_null($id))
			$id = $this->input->get('id');
		$produtos = $this->clog_model->listar('produtos', $id)->row();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('produto' => $produtos)));
	}

	public function auditoria() {
		#$dtIni = date('Y')."-01-01";
		$dtIni = "2014-01-01"; #Temp
		$linhas = 20;
		# Carregando os selects
		$acoes = $this->clog_model->getAll('tipo_auditoria')->result();
		$militares = $this->militares_model->getMilitares()->result();
		# Contando os registros
		# Aplicando filtro
		$filter = array('data_inicial' => $dtIni);
		$regs = $this->clog_model->getAuditoria($filter);
		if (!is_bool($regs)) {
			$num_regs = $regs->num_rows();
			$lista = $this->clog_model->getAuditoria($filter, 0, $linhas);
			$filter = array('data_inicial' => $this->clog_model->formataData($dtIni));
			$auditoria = $this->load->view('auditoria/lista', array('acoes' => $acoes, 'militares' => $militares, 'lista' => $lista->result(), 'linhas' => $linhas, 'num_regs' => $num_regs, 'filters' => $filter), TRUE);
		}
		else $auditoria = $this->load->view('auditoria/lista', array('acoes' => $acoes, 'militares' => $militares, 'filters' => $filter), TRUE);
		$this->load->view('layout/index', array('layout' => $auditoria), FALSE);
	}

	public function filtrar_auditoria() {
		$pg = (!$this->input->get('page')) ? 1 : $this->input->get('page');
		$linhas = 20;
		# Carregando os selects
		$acoes = $this->clog_model->getAll('tipo_auditoria')->result();
		$militares = $this->militares_model->getMilitares()->result();
		# Recebendo os POSTs
		$data_inicial = $this->input->post('data_inicial');
		$data_final = $this->input->post('data_final');
		$idtipo = $this->input->post('tipo_auditoria');
		$idmilitar = $this->input->post('militares_id');
		# Aplicando filtro
		$filter = array('data_inicial' => $data_inicial,
				'data_final' => $data_final,
				'idtipo' => $idtipo,
				'idmilitar' => $idmilitar
		);
		#echo "<pre>"; var_dump($filter); echo "</pre>"; die();
		$regs = $this->clog_model->getAuditoria($filter);
		if (!is_bool($regs))
			$num_regs = $regs->num_rows();
		$lista = $this->clog_model->getAuditoria($filter, ($pg - 1) * $linhas, $linhas);
		if (!is_bool($lista))
			$this->load->view('auditoria/resultado_consulta', array('lista' => $lista->result(), 'linhas' => $linhas, 'num_regs' => $num_regs, 'filters' => $filter), FALSE);
		#if (! is_bool($lista)) $auditoria = $this->load->view('auditoria/lista', array('acoes'=>$acoes, 'militares'=>$militares, 'lista'=>$lista->result(), 'linhas'=>$linhas, 'num_regs'=>$regs->num_rows(), 'filters'=>$filter), TRUE);
		#$this->load->view('layout/index', array('layout' => $auditoria), FALSE);
	}

	public function povoaCLOG() {
		$this->clog_model->povoaCLOG();
	}

	public function msgSystemAjax() {
		$msg = $this->input->get('msg');
		$msgTp = $this->input->get('msgTp');
		$pg = $this->input->get('pg');
		$this->session->set_flashdata('mensagem', array('type' => 'alert-'.$msgTp, 'msg' => $msg));
		redirect($pg);
	}

	public function cadastra_sala() {
		$id = $this->input->get('id');
		$onEdit = FALSE;
		$setores = $this->clog_model->getLotacoes();
		$salas = $this->clog_model->getSalas();
		if (! is_bool($id)) {
			$onEdit = (! is_bool($this->clog_model->getSalas($id))) ? $this->clog_model->getSalas($id)->row() : FALSE;
		}
		$conteudo = $this->load->view('salas/index', array('salas' => $salas, 'setores' => $setores, 'onEdit' => $onEdit), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function nova_sala() {
		$id = $this->input->post('id');
		$data = array(
			'nome' => $this->input->post('nome'),
			'sigla' => $this->input->post('sigla'), 
			'superior_id' => $this->input->post('lotacoes_id'), 
			'sala' => 1
		);
		if ($id != "") {
			$data['id'] = $id;
			$controle = $this->clog_model->atualizar('lotacoes', $data);
			$msgSuccess = "A sala <em>".$data['nome']."<em> foi atualizada com sucesso!";
			$msgFail = "Não foi possível atualizar a sala <em>".$data['nome']."<em>!";
		}
		else {
			$controle = $this->clog_model->salvar('lotacoes', $data);
			$msgSuccess = "A sala <em>".$data['nome']."<em> foi criada com sucesso!";
			$msgFail = "Não foi possível criar a sala <em>".$data['nome']."<em>!";
		}
		if (FALSE == $controle) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => $msgFail));
			redirect('clog/cadastra_sala');
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msgSuccess));
			redirect('clog/cadastra_sala');
		}
	}

}
