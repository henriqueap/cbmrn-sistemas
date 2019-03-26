<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Empresa extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('empresa_model', 'clog_model'));
		$this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}
	
	public function index() {
		$empresa = $this->load->view('empresa/cadastro', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$empresa), FALSE);		 
	}

	public function cadastro() {
		# Var $data, $data1, $data2, $data3... Ajeitar isso!  
		$empresa = $this->load->view('empresa/cadastro','', TRUE);
		$this->load->view('layout/index', array('layout' => $empresa), FALSE);
		
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$cnpjExists = $this->db->get_where('empresas', array('cnpj' => $this->input->post('inputCNPJ')));
			if ($cnpjExists->num_rows() > 0) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Já existe empresa com este CNPJ cadastrado'));
				redirect('clog/empresa/index');
			}
			$data2=array(
				'logradouro'=>$this->input->post('inputEnd'),
				'numero'=>$this->input->post('inputNum'),
				'bairro'=>$this->input->post('inputBairro'),
				'cidade'=>$this->input->post('inputCidade'),
				'cep'=>$this->input->post('cep'),
				'estado'=>$this->input->post('inputEstado'),
				'complemento'=>$this->input->post('inputCom'),
			); 
			$var2 = $this->empresa_model->cadastroRetorno($data2);	
			
			$data = array(		
				'nome_fantasia'=>$this->input->post('inputNome'),
				'razao_social'=>$this->input->post('inputRazao'),
				'cnpj'=>$this->input->post('inputCNPJ'),
				'enderecos_id'=>$var2,
			); 
			$var = $this->empresa_model->cadastroEmpresa($data);
			
			$data3 = array('telefone'=>$this->input->post('inputTel'));		
			$var3 = $this->empresa_model->cadastroRetornoTelefone($data3);
			
			$data4=array(
				'nome'=>$this->input->post('inputNomeContato'),
				'email'=>$this->input->post('inputEmail'),
				'telefones_id'=>$var3
			);		
			$var4 = $this->empresa_model->cadastroContato($data4);
			
			$data5 = array('empresas_id'=>$var, 'contatos_id'=>$var4);
			$var5 = $this->empresa_model->cadastroContatosEmpresa($data5);
			
			if ($var2 == FALSE || $var == FALSE || $var3 == FALSE || $var4 == FALSE || $var5 == FALSE) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de incluir uma empresa no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));				
			} 
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Incluiu uma empresa no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
			}		 
			
			redirect('clog/empresa/index');
		}	
	}

	public function consulta() {
		$empresa = $this->load->view('empresa/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$empresa), FALSE);
	}

	public function consultaEmpresa() {
		$filter = array();

		if ($this->input->get('razao_social') != '') {
			$filter['razao_social'] = $this->input->get('razao_social');
		}

		if ($this->input->get('nome_fantasia') != '') {
			$filter['nome_fantasia'] = $this->input->get('nome_fantasia');
		}

		if ($this->input->get('cnpj') != '') {
			$filter['cnpj'] = $this->input->get('cnpj');
		}
			
		$consulta = $this->empresa_model->consultaEmpresa($filter)->result();
		# Bloco de auditoria
			/*$auditoria = array(
								'auditoria'=>'Consultou empresa(s) no sistema',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
			$this->clog_model->audita($auditoria, 'consultar');*/
		# .Bloco de auditoria
		$this->load->view('empresa/resultado_consulta', array('consulta'=>$consulta), FALSE);
	}

	public function editar($id) {
		$dados_empresa = $this->empresa_model->getDadosEmpresa($id);
		if (! $dados_empresa) {
			$this->session->set_flashdata('Não foi possível obter os dados da empresa com ID $id', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
			redirect($this->consulta());
		}
		else {
			$dados_endereco = $this->clog_model->listar('enderecos', $dados_empresa->enderecos_id)->row();
			$dados_contato = $this->clog_model->listar('contatos',$dados_empresa->contatos_id)->row();
			$dados_telefone = $this->clog_model->listar('telefones', $dados_contato->telefones_id)->row();
			$empresas = $this->load->view('empresa/editar', 
				array(
					'dados_empresa'=>$dados_empresa, 
					'dados_endereco'=>$dados_endereco, 
					'dados_contato'=>$dados_contato, 
					'dados_telefone'=>$dados_telefone
				), TRUE);
			$this->load->view('layout/index', array('layout'=>$empresas), FALSE);
		}
	}

	public function editar_salvar() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			$data2=array(
				'id'=>$this->input->post('inputIdEnd'),
				'logradouro'=>$this->input->post('inputEnd'),
				'numero'=>$this->input->post('inputNum'),
				'bairro'=>$this->input->post('inputBairro'),
				'cidade'=>$this->input->post('inputCidade'),
				'cep'=>$this->input->post('cep'),
				'estado'=>$this->input->post('inputEstado'),
				'complemento'=>$this->input->post('inputCom'),
			); 
			$var2 = $this->empresa_model->atualizaEndereco($data2);	
			
			$data=array(	
				'id'=>$this->input->post('inputIdEmpresa'),	
				'nome_fantasia'=>$this->input->post('inputNome'),
				'razao_social'=>$this->input->post('inputRazao'),
				'cnpj'=>$this->input->post('inputCNPJ'),
				'ativo'=>$this->input->post('selAtivo'),
				'enderecos_id'=>$var2,
			); 
			$var = $this->empresa_model->atualizaEmpresa($data);
			
			$data3=array(
				'id'=>$this->input->post('inputIdTel'),
				'telefone'=>$this->input->post('inputTel')
			);		
			$var3 = $this->empresa_model->atualizaTelefone($data3);
			
			$data4=array(
				'id'=>$this->input->post('inputIdContato'),
				'nome'=>$this->input->post('inputNomeContato'),
				'email'=>$this->input->post('inputEmail'),
				'telefones_id'=>$var3
			); 
			$var4 = $this->empresa_model->atualizaContato($data4);
			
			
			if ($var2 == FALSE || $var == FALSE || $var3 == FALSE || $var4 == FALSE) {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de alterar os dados de uma empresa no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));				
			} 
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Alterou os dados de uma empresa no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'alterar');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
			}		 
			redirect('clog/empresa/editar/'.$data['id']);
		}
	}

	public function desativar($id) {	
		$ativo = $this->empresa_model->atualizaAtivo($id);
		if ($ativo == TRUE) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Inativou a empresa de ID n° '.$id.', no sistema',
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
		}
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de inativar a empresa de ID n° '.$id.', no sistema',
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'alterar');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
		}
		redirect("clog/empresa/consulta");
	}
}