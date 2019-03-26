<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Permutas extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', '../modules/permutas/models/permutas_model'));
		if (FALSE === $this->session->userdata('militar')) {
			$this->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'O sistema fechou por inatividade!'));
			redirect("acesso");
		}
		# $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$conteudo = $this->load->view('welcome/index', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function cadastrar_permuta() {
		$militares = $this->permutas_model->getMilitares();
		$conteudo = $this->load->view('../modules/permutas/views/permutas/index', array('militares' => $militares), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data = array(
				"data_servico" => $this->permutas_model->formataData($this->input->post('data_servico')),
				"permutados_id" => $this->input->post('permutados_id'),
				"permutantes_id" => $this->input->post('permutantes_id'),
				"militares_id" => $this->input->post('militares_id')
			);
			$senha = $this->input->post('senha_auth');
			$validate = $this->permutas_model->validaPermuta($data['militares_id'], $senha);
			if (!($validate)) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Senha incorreta! Não foi possível cadastrar a permuta.'));
				redirect("permutas/index");
			}
			else {
				$controle = $this->permutas_model->salvar('permutas', $data);
				if ($this->db->affected_rows() > 0){
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Permuta cadastrada com sucesso!'));
					redirect("permutas/index");
				}
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível cadastrar a permuta!'));
					redirect("permutas/index");
				}
			}
		}
	}

	public function listar_permutas() {
		$permutado_id = $this->input->post('permutados_id');
		# var_dump($permutado_id); die();
		$permutas = (!($permutado_id) || $permutado_id == 0)? $this->permutas_model->getPermutas() : $this->permutas_model->getPermutas($permutado_id);
		$militares = $this->permutas_model->getMilitares();
		$conteudo = $this->load->view('../modules/permutas/views/permutas/lista_permutas', array('permutas' => $permutas, 'militares' => $militares), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function excluirLinha($id = NULL, $tbl = NULL) {
		$id = (! is_null($id))? $id: $this->input->get('id');
		$tbl = (! is_null($tbl))? $tbl: $this->input->get('tbl'); 
		$controle = (!($tbl) || !($id))? FALSE : $this->clog_model->excluir($tbl, $id);
		if (! $controle) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Interno: Tentativa de excluir o ID nº $id da Tabela <em>".strtoupper($tbl)."</em>",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Houve um erro, não foi possível concluir a exclusão!"));
			redirect($this->session->flashdata('return_to')); # Pegando a página de retorno da sessão
		}
		else{
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => "Interno: Excluiu o ID $id da Tabela <em>strtoupper($tbl)</em>",
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "Exclusão concluída com sucesso!"));
			redirect($this->session->flashdata('return_to')); # Pegando a página de retorno da sessão
		}
	}

	public function auditoria() {
		#$dtIni = (date('Y'))."-01-01";
		$dtIni = (date('Y')-1)."-01-01"; #Temp
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
		$linhas = (!$this->input->post('linhas')) ? 20 : $this->input->post('linhas');
		# Carregando os selects
		$acoes = $this->clog_model->getAll('tipo_auditoria')->result();
		$militares = $this->militares_model->getMilitares()->result();
		# Recebendo os POSTs
		$data_inicial = $this->input->post('data_inicial');
		$data_final = $this->input->post('data_final');
		$idtipo = $this->input->post('tipo_auditoria');
		$idmilitar = $this->input->post('militares_id');
		$auditoria = $this->input->post('auditoria');
		# Aplicando filtro
		$filter = array('data_inicial' => $data_inicial,
			'data_final' => $data_final,
			'idtipo' => $idtipo,
			'idmilitar' => $idmilitar,
			'auditoria' => $auditoria
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

	public function msgSystemAjax() {
		$msg = $this->input->get('msg');
		$msgTp = $this->input->get('msgTp');
		$pg = $this->input->get('pg');
		$this->session->set_flashdata('mensagem', array('type' => 'alert-'.$msgTp, 'msg' => $msg));
		redirect($pg);
	}

}
