<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Empresa extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('empresa_model');
  }
  	function index(){
		$empresa=$this->load->view('empresa/cadastro', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$empresa), FALSE);	 
	}

  public function cadastro(){
	#$listar_estados=$this->empresa_model->getByIdEstados();
  	$empresa = $this->load->view('empresa/cadastro',''/*array('listar_estados'=>$listar_estados)*/, TRUE);
  	$this->load->view('layout/index', array('layout' => $empresa ), FALSE);
		if($this->input->server('REQUEST_METHOD')=='POST'){
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
			if ($var2 == FALSE){
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! '));		
			}else{	
				$data=array(		
					'nome_fantasia'=>$this->input->post('inputNome'),
					'razao_social'=>$this->input->post('inputRazao'),
					'cnpj'=>$this->input->post('inputCNPJ'),
					'ativo'=>$this->input->post('selAtivo'),
					'login'=>$this->input->post('inputLogin'),
					'senha'=>$this->input->post('inputSenha'),
					'enderecos_id'=>$var2,
				); 
				$var = $this->empresa_model->cadastroEmpresa($data);
				if ($var == "Login"){
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Login inválido, o mesmo já existe.'));		
			
				}elseif ($var == "CNPJ"){
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! CNPJ inválido, o mesmo já existe.'));		
				}else{	
					$data3=array(
					'telefone'=>$this->input->post('inputTel'));		
					$var3 = $this->empresa_model->cadastroRetornoTelefone($data3);
					if ($var3 == FALSE){
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! '));	
					}else{
						$data4=array(
						'nome'=>$this->input->post('inputNomeContato'),
						'email'=>$this->input->post('inputEmail'),
						'telefones_id'=>$var3,);		
						$var4 = $this->empresa_model->cadastroContato($data4);
						if ($var4 == FALSE){
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! '));	
						}else{			
							$data5=array(
								'empresas_id'=>$var,
								'contatos_id'=>$var4
							);
							$var5 = $this->empresa_model->cadastroContatosEmpresa($data5);
							if ($var5 == FALSE){
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! '));	
							}else{	
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
						  	}
						}
					}
				}
			}		 
			redirect('frotas/home');
		}	
	}

	public function editar($id) { 
	 	$this->listar_contatos_empresa['idempresa']=$id ;       
	   	$listarPeloId = $this->listar_empresa_model->listarContatosEmpresa($id)->row();	
		$this->chamarViewAtualizar($listarPeloId);	
	}
	
	
	public function chamarViewAtualizar($listarPeloId=""){
		$listar=$this->load->view('listar_empresa/atualiza_dados', array('listarPeloId'=>$listarPeloId), TRUE);
		$this->load->view('layout/index', array('layout'=>$listar,), FALSE);
			
	}
		
	public function atualizar(){ 			
			if($this->input->server('REQUEST_METHOD')=='POST'){
			
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
				$var2 = $this->listar_empresa_model->atualizaEndereco($data2);	
				
				$data=array(	
					'id'=>$this->input->post('inputIdEmpresa'),	
					'nome_fantasia'=>$this->input->post('inputNome'),
					'razao_social'=>$this->input->post('inputRazao'),
					'cnpj'=>$this->input->post('inputCNPJ'),
					'ativo'=>$this->input->post('selAtivo'),
					'enderecos_id'=>$var2,
				); 
				$var = $this->listar_empresa_model->atualizaEmpresa($data);
				
				$data3=array(
					'id'=>$this->input->post('inputIdTel'),
					'telefone'=>$this->input->post('inputTel')
				);		
				$var3 = $this->listar_empresa_model->atualizaTelefone($data3);
				
				$data4=array(
					'id'=>$this->input->post('inputIdContato'),
					'nome'=>$this->input->post('inputNomeContato'),
					'email'=>$this->input->post('inputEmail'),
					'telefones_id'=>$var3
				); 
				$var4 = $this->listar_empresa_model->atualizaContato($data4);
				
				
				/*echo "<pre>";
					var_dump($data4);				
				echo "<pre>";*/
				
				if ($var2 == FALSE || $var == FALSE || $var3 == FALSE || $var4 == FALSE) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));				
				} else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
				}		 
				redirect('frotas/home');	
		}
	 } // FIM METHOD
}