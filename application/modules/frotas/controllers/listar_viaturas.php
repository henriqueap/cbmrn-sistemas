<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Listar_viaturas extends MX_Controller {
	private $listar_viaturas;
	
	public function __construct() {
		parent::__construct();
		$this->load->model('listar_viaturas_model');
		$this->load->model('viaturas_model');
		$this->load->model('odometro_model');
		//$this->load->model('suporte_model');
	}

	public function index(){
		$listar=$this->load->view('listar_viaturas/listar', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);		 
	}
	
	/*public function listar($id=NULL){
		
		$listar_lotacoes= $this->viaturas_model->getByIdSetor();
		$listar_tipo_viaturas= $this->viaturas_model->getByIdTipoViaturas();
		$listar_viaturas_ativos= $this->viaturas_model->getInfoViaturas();
		$listar_viaturas_inativos= $this->viaturas_model->getInfoViaturas(0);*/
		/*$testa_ativo = $this->listar_viaturas_model->listarViaturas($id, 1);

		if ($testa_ativo !== FALSE ) {
			$listar_viaturas_ativos = $testa_ativo->result();
		}
		else {
			$listar_viaturas_ativos = FALSE;
		}
		if ($testa_inativo !== FALSE ) {
			$listar_viaturas_inativos = $testa_inativo->result();
		}
		else {
			$listar_viaturas_inativos = FALSE;
		}

		$listar=$this->load->view('listar_viaturas/listar',
				array(
				'listar_lotacoes'=>$listar_lotacoes,
				'listar_tipo_viaturas'=>$listar_tipo_viaturas,
				'listar_viaturas_ativos'=>$listar_viaturas_ativos ,
				'listar_viaturas_inativos'=>$listar_viaturas_inativos
			), 
			TRUE
		);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);
	} */

	public function listar($id=NULL){
		$listar_viaturas= $this->listar_viaturas_model->listar();
		/*echo "<pre>";
			var_dump($listar_viaturas->result());
		echo "</pre>"; die("Ok");*/
		$listar_lotacoes= $this->viaturas_model->getByIdSetor();
		//var_dump($listar_lotacoes->result());
		$listar_tipo_viaturas= $this->viaturas_model->getByIdTipoViaturas();
		//var_dump($listar_tipo_viaturas->result()); die();
		$listar= $this->load->view('listar_viaturas/listar',
				array(
				'listar_lotacoes'=>$listar_lotacoes,
				'listar_tipo_viaturas'=>$listar_tipo_viaturas,
				'listar_viaturas'=>$listar_viaturas
			), 
			TRUE
		);

		$this->load->view('layout/index', array('layout'=>$listar), FALSE);
	}
	
	public function listarFiltrar($id=NULL){
		$data = array(
			'idLotacao'=>$this->input->get('idLotacao'),
			'tipo'=>$this->input->get('tipo')
		);
		$listar_viaturas=$this->listar_viaturas_model->listarViaturasFiltrar($data);
		$listar=$this->load->view('listar_viaturas/resultado_consulta_listar', array('listar_viaturas'=>$listar_viaturas), FALSE);
	} 
	
	public function editar($id) { 
		$this->listar_viaturas['id']=$id;
		$listarPeloId = $this->listar_viaturas_model->listarViaturas($id)->row();
		$this->chamarViewAtualizar($listarPeloId);
	}
	
	public function chamarViewAtualizar($listarPeloId=""){
		$listar_marcas = $this->viaturas_model->getByIdMarcas();
		$listar_modelos = $this->viaturas_model->getByIdModelo(); //listar os modelos das viaturas.
		$tipo_combustivel = $this->viaturas_model->getByIdCombustiveis(); // listar os tipo dos combustiveis existentes.
		$setor_lotacao = $this->viaturas_model->getByIdSetor();
		$listar_tipo_viaturas=$this->listar_viaturas_model->listarTipoViaturas();
		$listar_viaturas = $this->odometro_model->listarViaturas();
		$listar=$this->load->view('listar_viaturas/atualizar_dados_viatura', array('listar_tipo_viaturas'=>$listar_tipo_viaturas,'listar_viaturas'=>$listar_viaturas,'listarPeloId'=>$listarPeloId, 'listar_marcas'=>$listar_marcas,'listar_modelos'=>$listar_modelos , 'setor_lotacao'=>$setor_lotacao, 'tipo_combustivel'=>$tipo_combustivel), TRUE);
		$this->load->view('layout/index', array('layout'=>$listar,), FALSE);
	}
	
	public function atualizarOperante($id){
		//var_dump($id); die();
		if ($this->listar_viaturas_model->atualizaOperante($id) == FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar status da empresa!'));
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
		}
		redirect('frotas/listar_viaturas/listar');
	}
	 
	public function atualizarDados(){
		if ($this->input->server('REQUEST_METHOD')  == 'POST') {
			$data = array(
				'id'=>$this->input->post('inputId'),
				'placa' => $this->input->post('txtPlaca'),
				'prefixo' => $this->input->post('txtPrefixo'),
				'tipo_viaturas_id' => $this->input->post('selTipo'),
				'modelo_veiculos_id' => $this->input->post('selModelo'),
				'ano_fabricacao' => $this->input->post('selAnoFab'),
				'ano_modelo' => $this->input->post('selAnoMod'),
				'tracao' => $this->input->post('selTracao'),
				'chassis' => $this->input->post('txtNumero'),
				'renavam' => $this->input->post('txtRenavam'),
				'cor' => $this->input->post('selCor'),
				'lotacoes_id' => $this->input->post('selSetor'),
				'combustivel_id' => $this->input->post('selCombustivel'),
				'chip' => $this->input->post('selChip'),
				'litros_combustivel' => $this->input->post('txtLitros'),
				'km_oleo' => $this->input->post('txtOleo'),
				'km_revisa' => $this->input->post('txtRevisa'),
				'origem' => $this->input->post('selOrigem')
			);
			if ($this->listar_viaturas_model->atualizaDados($data) == FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
			}
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
			}
			redirect('frotas/home'); 
		}
	}
	 
	public function excluir($id){
		if ($this->listar_viaturas_model->excluir($id ) == FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
		}
		redirect('frotas/listar_viaturas/listar');
	}

	public function listarOdometros($_id){
		$_viatura= $this->viaturas_model->getViatura($_id);
		$_listarOdometrosId=$this->listar_viaturas_model->listarOdometros($_id);
		$data = array(
			//'id'=>$this->input->get('inputIdViaturas'),
			'id'=> $_id,
			'data_inicial'=> $this->input->get('dataInicial'),
			'data_final'=> $this->input->get('dataFinal')
		);
		$listar=$this->load->view('listar_viaturas/listar_odometros', 
			array(
				'viatura'=> $_viatura, 
				'listarOdometrosId'=> $_listarOdometrosId, 
				'idViatura'=> $_id
			), TRUE
		);
		$this->load->view('layout/index', array('layout'=>$listar), FALSE);
	}
	 
	public function listarOdometrosFiltrar(){
		$data = array(
			'id'=>$this->input->get('id'),
			'data_inicial'=>$this->input->get('data_inicial'),
			'data_final'=>$this->input->get('data_final')
		);
		
		$listarOdometrosId=$this->listar_viaturas_model->listarOdometrosFiltrar($data);
		$listar=$this->load->view('listar_viaturas/resultado_consulta_odometro', array('listarOdometrosId'=>$listarOdometrosId), FALSE);
	}
	 
	public function editarOdometros($id){
		$this->listar_viaturas['idodometros']=$id;
		$listarOdometroId = $this->listar_viaturas_model->listarOdometro($id)->row();
		$this->chamarViewAtualizarOdometros($listarOdometroId);
	}
	
	public function chamarViewAtualizarOdometros($listarOdometrosId=""){
		$listar_marcas = $this->viaturas_model->getByIdMarcas();
		$listar_modelos = $this->viaturas_model->getByIdModelo(); //listar os modelos das viaturas.
		$tipo_combustivel = $this->viaturas_model->getByIdCombustiveis(); // listar os tipo dos combustiveis existentes.
		$setor_lotacao = $this->viaturas_model->getByIdSetor();
		$listar_viaturas = $this->odometro_model->listarViaturas();
		$listar=$this->load->view('odometro/atualizar_odometro',  array('listar_viaturas'=>$listar_viaturas,'listarOdometrosId'=>$listarOdometrosId, 'listar_marcas'=>$listar_marcas,'listar_modelos'=>$listar_modelos , 'setor_lotacao'=>$setor_lotacao, 'tipo_combustivel'=>$tipo_combustivel), TRUE);
		$this->load->view('layout/index', array('layout'=>$listar,), FALSE);
	}
	 
	public function atualizarOdometros(){	  
		if($this->input->server('REQUEST_METHOD')=='POST'){		
			$data = array(
				'id'=>$this->input->post('inputIdOdometros'),
				'militares_id'=>$this->input->post('inputIdmilitares'),
				'data'=>$this->input->post('data'),
				'viaturas_id'=>$this->input->post('selViatura'),
				'odometro'=>$this->input->post('inputOdometro'),
				'destino'=>$this->input->post('inputDestino'),
				'alteracao'=>$this->input->post('inputAlteracao')
			);

			if($this->listar_viaturas_model->atualizaDadosOdometro($data)==false){ 		
				$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
			} 
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
			}
			redirect('frotas/listar_viaturas/listarOdometros'."/".$data['viaturas_id']); 
		}
	}
	 
	/*public function listarServicos($id){
		$listarServicosId=$this->listar_viaturas_model->listarServicos($id);
		$listarTipoServicos=$this->listar_viaturas_model->getByIdTipoServicos()->result();
		$listar=$this->load->view('listar_viaturas/listar_servicos', array('listarServicosId'=>$listarServicosId,'listarTipoServicos'=>$listarTipoServicos,'idViatura'=>$id), TRUE);
		this->load->view('layout/index', array('layout'=>$listar,), FALSE);
	}
	 
	public function listarServicosFiltrar(){
		$data = array(
			'id'=>$this->input->get('id'),
			'idTipo'=>$this->input->get('idTipo'),
			'data_inicial'=>$this->input->get('data_inicial'), 
			'data_final'=>$this->input->get('data_final')
		);
		$listarServicosId=$this->listar_viaturas_model->listarServicosFiltrar($data);
		$listar=$this->load->view('listar_viaturas/resultado_consulta_servicos', array('listarServicosId'=>$listarServicosId), FALSE);
	}*/
	
	public function listarAbastecimentos($id){
		$listarAbastecimentosId=$this->listar_viaturas_model->listarAbastecimentos($id);
		$listar=$this->load->view('listar_viaturas/listar_abastecimentos', array('listarAbastecimentosId'=>$listarAbastecimentosId,'idViatura'=>$id), TRUE);
		$this->load->view('layout/index', array('layout'=>$listar,), FALSE);
	}

	/*public function listarAbastecimentosFiltrar(){
		$data = array(
			'id'=>$this->input->get('id'),
			'setor'=>$this->input->get('selLotacao'),
			'data_inicial'=>$this->input->get('data_inicial'),
			'data_final'=>$this->input->get('data_final')
		);
		$listarAbastecimentosId=$this->listar_viaturas_model->listarAbastecimentosFiltrar($data);	
		$listar=$this->load->view('listar_viaturas/resultado_consulta_abastecimento', array('listarAbastecimentosId'=>$listarAbastecimentosId), FALSE);
	}*/
}