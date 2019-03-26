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
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->clog_model->getAlmox();
		if (! $almox) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Procure o administrador, não existe almoxarifado principal cadastrado!"));
			redirect('clog/index');
		}
		$id = ($this->input->get("id") === FALSE)? NULL : $this->input->get("id");
		$estoques_id = (! $this->input->get("estoque"))? $estoques_id = $almox : $this->input->get("estoque");
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

	public function povoaAlmoxMaster() {
		$this->clog_model->povoaAlmoxMaster();
	}

	public function msgSystemAjax() {
		$msg = $this->input->get('msg');
		$msgTp = $this->input->get('msgTp');
		$pg = $this->input->get('pg');
		$this->session->set_flashdata('mensagem', array('type' => 'alert-'.$msgTp, 'msg' => $msg));
		redirect($pg);
	}

	public function cadastra_setor() {
		# Pegando os dados do Almoxarifado Principal
		$almox = $this->clog_model->getAlmox();
		$id = $this->input->get('id');
		$onEdit = FALSE;
		if (! is_bool($id)) {
			$onEdit = (! is_bool($this->clog_model->getLotacoes($id))) ? $this->clog_model->getLotacoes($id)->row() : FALSE;
		}
		$setores = $this->clog_model->getAll('lotacoes');
		$conteudo = $this->load->view('setores/index', array('almox' => $almox, 'onEdit' => $onEdit, 'setores' => $setores), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function novo_setor() {
		$id = $this->input->post('id');
		$data = array(
			'nome' => $this->input->post('nome'),
			'sigla' => $this->input->post('sigla'), 
			'superior_id' => $this->input->post('superior_id'), 
			'sala' => 0,
			'almox' => (!($this->input->post('almox')))? 0 : $this->input->post('almox')
		); # Será que precisaria testar se existe mais de um almox principal?
		if ($id != "") {
			$data['id'] = $id;
			$controle = $this->clog_model->atualizar('lotacoes', $data);
			$msgSuccess = "O setor <em>".$data['nome']."<em> foi atualizado com sucesso!";
			$msgFail = "Não foi possível atualizar o setor <em>".$data['nome']."<em>!";
			$msgAudSuccess = "Alteração de dados do setor ".$data['nome'];
			$msgAudFail = "Tentativa de alterar o setor ".$data['nome'];
		}
		else {
			$controle = $this->clog_model->salvar('lotacoes', $data);
			$msgSuccess = "O setor <em>".$data['nome']."<em> foi criada com sucesso!";
			$msgFail = "Não foi possível criar o setor <em>".$data['nome']."<em>!";
			$msgAudSuccess = "Inclusão do setor ".$data['nome']." no sistema";
			$msgAudFail = "Tentativa de criar o setor ".$data['nome'];
		}
		if (FALSE == $controle) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => $msgAudFail,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => $msgFail));
			redirect('clog/cadastra_setor');
		}
		else {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => $msgAudSuccess,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msgSuccess));
			redirect('clog/cadastra_setor');
		}
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
			'nome' => strtoupper($this->input->post('nome')),
			'sigla' => $this->input->post('sigla'), 
			'superior_id' => $this->input->post('lotacoes_id'), 
			'sala' => 1
		);
		if ($id != "") {
			$data['id'] = $id;
			$controle = $this->clog_model->atualizar('lotacoes', $data);
			$msgSuccess = "A sala <em>".$data['nome']."<em> foi atualizada com sucesso!";
			$msgFail = "Não foi possível atualizar a sala <em>".$data['nome']."<em>!";
			$msgAudSuccess = "Alteração de dados da sala ".$data['nome'];
			$msgAudFail = "Tentativa de alterar a sala ".$data['nome'];
			$tpAud = "alterar";
		}
		else {
			$controle = $this->clog_model->salvar('lotacoes', $data);
			$msgSuccess = "A sala <em>".$data['nome']."<em> foi criada com sucesso!";
			$msgFail = "Não foi possível criar a sala <em>".$data['nome']."<em>!";
			$msgAudSuccess = "Inclusão da sala ".$data['nome']." no sistema";
			$msgAudFail = "Tentativa de criar a sala ".$data['nome'];
			$tpAud = "inserir";
		}
		if (FALSE == $controle) {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => $msgAudFail,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, $tpAud);
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => $msgFail));
			redirect('clog/cadastra_sala');
		}
		else {
			# Bloco de auditoria
			$auditoria = array(
				'auditoria' => $msgAudSuccess,
				'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
				'idmodulo' => $this->session->userdata['sistema']
			);
			$this->clog_model->audita($auditoria, $tpAud);
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => $msgSuccess));
			redirect('clog/cadastra_sala');
		}
	}

	public function cadastra_responsavel() {
		# Pegando a página de retorno e jogando na sessão
		$url = explode('/', $_SERVER['REQUEST_URI']);
		$here = ltrim(($url[count($url)-3]."/".$url[count($url)-2]."/".$url[count($url)-1]), 'index.php/');
		$this->session->set_flashdata('return_to', $here);
		# Pegando o GET
		$id = $this->input->get('id');
		# Pegando o POST
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data = array(
				'militares_id' => $this->input->post('chefe_militares_id'),
				'lotacoes_id' => $this->input->post('lotacoes_id')
			);
			# Pegando os nomes do militar e do setor
			$responsavel = $this->clog_model->getMilitar($data['militares_id']);
			$lotacao = $this->clog_model->getLotacoes($data['lotacoes_id'])->row();
			# Bloqueando erro de formulário
			if ($data['lotacoes_id'] == 0 || $data['militares_id'] == "") {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "Precisa selecionar um valor válido!"));
				redirect($here);
			}
			# Checando se já existe esta linha no banco
			$controle = $this->db->get_where('responsavel_lotacoes', $data);
			if ($controle->num_rows() >0) {
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Tentativa de incluir o mesmo militar como responsável do(a) $lotacao->sigla",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => "$responsavel->militar já é responsável pelo(a) $lotacao->sigla com sucesso!"));
				redirect($here);
			}
			$inclui = $this->clog_model->salvar('responsavel_lotacoes', $data);
			# Tenta incluir e dá o retorno
			if (FALSE == $inclui) {
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Tentativa de incluir $responsavel->militar como responsável do(a) $lotacao->sigla",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "Não foi possível incluir $responsavel->militar como responsável do(a) $lotacao->sigla!"));
			}
			else {
				# Bloco de auditoria
				$auditoria = array(
					'auditoria' => "Incluiu $responsavel->militar como responsável do(a) $lotacao->sigla",
					'idmilitar' => $this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo' => $this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => "$responsavel->militar incluído(a) como responsável do(a) $lotacao->sigla com sucesso!"));
			}
		} # .POST
		$sala = (! $this->input->get('sala'))? 0 : 1;
		$lotacoes = ($sala == 0)? $this->clog_model->getLotacoes() :  $this->clog_model->getSalas();
		$lista = $this->clog_model->getLotacoesInfo();
		$conteudo = $this->load->view('setores/responsavel_setor', array('lotacoes' => $lotacoes, 'lista' => $lista, 'sala' => $sala), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

}
