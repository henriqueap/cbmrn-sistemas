<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Notas extends MX_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('clog_model', 'notas_model', 'produtos_model'));
		# $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
		# $this->load->helper('cbmrn');
	}

	public function index() {
		# Index
		$this->cadastro();
	}

	public function cadastro() {
		# Listar empresas cadastradas.
		$empresas = $this->clog_model->listar('empresas')->result();

		$info_notas_fiscais = $this->notas_model->getInfoNotas()->result();

		$notas = $this->load->view('notas/cadastro', array('empresas'=>$empresas, 'info_notas_fiscais'=>$info_notas_fiscais), TRUE);
		$this->load->view('layout/index', array('layout'=>$notas), FALSE);
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('numero', 'numero', 'trim|required|xss_clean');
			$this->form_validation->set_rules('data', 'data', 'trim|required|xss_clean');
			$this->form_validation->set_rules('empresas_id', 'empresas', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
				$id_nota_fiscal = $this->notas_model->dados_notas();
				if (is_int($id_nota_fiscal)) {
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Incluiu nova nota fiscal ID n° '.$id_nota_fiscal.' no sistema',
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					redirect("clog/notas/itens_nota/$id_nota_fiscal");
				}
				else {
					# Bloco de auditoria
						$auditoria = array(
											'auditoria'=>'Tentativa de incluir uma nova nota fiscal no sistema',
											'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
											'idmodulo'=>$this->session->userdata['sistema']
										);
						$this->clog_model->audita($auditoria, 'inserir');
					# .Bloco de auditoria
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro! Não foi possível incluir a nota!'));
					redirect('clog/notas/index');
				}
			} 
			else{
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao salvar!'));
				redirect('clog/notas/index');
			}
		} 
		else redirect('clog/notas/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function itens_nota($id_nota) {
		if (isset($id_nota)) {
			# Listar todos os produtos.
			$produtos = $this->clog_model->listar('produtos')->result();
			
			# Lista de todos os serviços.
			$tipo_servicos = $this->clog_model->listar('tipo_servicos')->result();
			
			# Informações da nota fiscal.
			$info_nota = $this->clog_model->listar('notas_fiscais', $id_nota)->row();

			# Listagem de todos os itens já cadastrados na nota fiscasl.
			$itens = $this->notas_model->itens_notas($id_nota)->result();

			$data = $this->load->view('notas/itens_nota', array('id_nota'=>$id_nota, 'info_nota'=>$info_nota, 'tipo_servicos'=>$tipo_servicos, 'produtos'=>$produtos, 'itens'=>$itens), TRUE);
			$this->load->view('layout/index', array('layout'=>$data), FALSE);

			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				# Adicionar item a nota fiscal.
				//$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item adicionado com sucesso!'));
				var_dump($id_nota);
				$this->add_itens_nota($id_nota);
			}
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao entrar na página, você acabou de ser redirecionado para página de cadastro das notas notas_fiscais!'));
			redirect('clog/notas/index');		
		}
	}

	public function add_itens_nota($id_nota) {
		# Adicionar itens a nota fiscal.
		if ($this->notas_model->add_item($id_nota) === FALSE) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de incluir novo item na nota fiscal ID n° '.$id_nota,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'inserir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao adicionar o item a nota, por favor, verifique se o preenchimento do formulário está correto!'));
		} 
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Incluiu novo item na nota fiscal ID n° '.$id_nota,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'inserir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Item adicionado com sucesso!'));
		}
		redirect("clog/notas/itens_nota/$id_nota");
	}

	public function excluir_itens_nota($id_nota, $id_notas_fiscais) {
		if (isset($id_nota)) {
			$exclusao = $this->clog_model->excluir('itens_notas_fiscais', $id_nota);
			if (! $exclusao) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de excluir o item ID n° '.$id_nota.', da nota ID n° '.$id_notas_fiscais,
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'excluir');
				# .Bloco de auditoria
			}
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Excluiu o item ID n° '.$id_nota.', da nota ID n° '.$id_notas_fiscais,
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'excluir');
				# .Bloco de auditoria
			}
			redirect("clog/notas/itens_nota/$id_notas_fiscais");
		} 
		else die(); # Checar depois
	}

	/**
	 * @param $id int
	 * 
	 */
	public function excluir_nota($id) {
		# Excluír nota fiscal caso ainda não, sido concluída.
		if ($this->notas_model->excluir_nota($id) >= 1) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Excluiu a nota fiscal ID n° '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota Fiscal excluída com sucesso!')); 
		} 
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de excluir a nota fiscal ID n° '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Nota Fiscal não foi excluída com sucesso!'));
		} 
		redirect('clog/notas/index');
	}

	public function excluir_nota_concluida($id) {
		$excluir = $this->notas_model->excluir_nota_concluida($id);
		# Excluír nota fiscal caso ainda não, sido concluída.
		if ($excluir == true) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Excluiu a nota fiscal ID n° '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota Fiscal excluída com sucesso!')); 
		} 
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de excluir a nota fiscal ID n° '.$id,
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Nota Fiscal não foi excluída com sucesso!'));
		} 
		redirect('clog/notas/index');
	}

	public function consulta() {
		# Listar Empresas.
		$listar_empresas = $this->clog_model->listar('empresas')->result();
		//var_dump($listar_empresas);

		# Views de consulta de notas fiscais.
		$notas = $this->load->view('notas/consulta', array('empresas'=>$listar_empresas), TRUE);
		$this->load->view('layout/index', array('layout'=>$notas), FALSE);
	}

	/**
	 * @param empty
	 * Consultar nota fiscal.
	 */
	public function consulta_notas_fiscais() {	
		# Inicialização de array.
		$filter = array();
		
		if ($this->input->get("nota_fiscal") != "") {
			$filter['nota_fiscal'] = $this->input->get("nota_fiscal");
		}

		if ($this->input->get("data") != "") {
			$filter['data'] = $this->input->get("data");
		}

		if ($this->input->get("empresas_id") != 0) {
			$filter['empresas_id'] = $this->input->get("empresas_id");
		}

		$consulta = $this->notas_model->consulta_notas_fiscais($filter)->result();
		# Bloco de auditoria
			/*$auditoria = array(
								'auditoria'=>'Consultou notas fiscais',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
			$this->clog_model->audita($auditoria, 'consultar');*/
		# .Bloco de auditoria
		$this->load->view('notas/resultado_consulta', array('consulta'=>$consulta), FALSE);
	}

	/**
	 * @param empty
	 * Concluir notas fiscais, pegando pelo method GET dados da nota!
	 */
	public function concluir_notas_fiscais() {	
		# GETs
		$data = array(
			'valor_final'=>$this->input->get('valor'), 
			'id_nota_fiscal'=>$this->input->get('id')
		);

		$estoque = $this->notas_model->concluir_atualizar_estoque($data['id_nota_fiscal']);
		if ($estoque === true) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Atualizou o estoque incluindo os itens da nota ID nº '.$data['id_nota_fiscal'],
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$concluir = $this->notas_model->concluir_notas_fiscais($data);
			if ($concluir === true) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Concluiu a nota ID nº '.$data['id_nota_fiscal'],
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nota fiscal concluída com sucesso!'));
			}
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de conclusão da nota ID nº '.$data['id_nota_fiscal'],
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Estoque atualizado, mas houve um erro na conclusão da nota fiscal!'));
			}
		} 
		else { 
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de atualizar o estoque incluindo os itens da nota ID nº '.$data['id_nota_fiscal'],
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao concluír nota fiscal, estoque inalterado!')); 
		} 
		redirect('clog/notas/index');
	}
	
}