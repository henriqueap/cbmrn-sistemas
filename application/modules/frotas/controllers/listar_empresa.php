<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
  class Listar_empresa extends MX_Controller {
	private $listar_contatos_empresa;
	  
	function __construct() {
    	parent::__construct();
    	$this->load->model('listar_empresa_model');		
  	}
	function index(){
		$listar=$this->load->view('listar_empresa/listar', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);		
	}
	
	function listar($id=NULL){
		$testa_ativo = $this->listar_empresa_model->listarContatosEmpresa($id, 1);
		$testa_inativo = $this->listar_empresa_model->listarContatosEmpresa($id, 0);
		if ($testa_ativo !== FALSE ) {
			$data['listar_contatos_empresa_ativos'] = $testa_ativo->result();
		}
		else $data['listar_contatos_empresa_ativos'] = FALSE;
		if ($testa_inativo !== FALSE ) {
			$data['listar_contatos_empresa_inativos'] = $testa_inativo->result();;
		}
		else $data['listar_contatos_empresa_inativos'] = FALSE;
		$listar=$this->load->view('listar_empresa/listar', $data, TRUE);
		$this->load->view('layout/index', array('layout'=>$listar,), FALSE);	
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
	
	public function atualizarAtivo($id){		
				// $var = $this->listar_empresa_model->atualizaAtivo($id);				
				if ($this->listar_empresa_model->atualizaAtivo($id) == FALSE) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar status da empresa!'));				
				} else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
				}		 
				redirect('frotas/listar_empresa/listar');		
 	} // FIM METHOD	
} // FIM CLASSE 