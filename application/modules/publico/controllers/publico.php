<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */

class Publico extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('publico_model');
		$this->load->helper('path');
		$this->load->library('auth');
	}

	public function index()
	{
		$index = $this->load->view('publico/publico/index', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$index), FALSE);
	}

	public function cadastro()
	{
		$index = $this->load->view('publico/publico/cadastro', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$index), FALSE);	
		if($this->input->server('REQUEST_METHOD')=='POST'){
			#$diretory = 'cbmrn/new/uploads/';			
			#$diretory = $_SERVER['DOCUMENT_ROOT'].'uploads/';
			$diretory = 'uploads/';
			$arquivoName=$_FILES["boletimUpload"]["name"];
			$arquivoName = htmlentities($arquivoName, ENT_QUOTES, "UTF-8");
			$arquivoTmpLoc = $_FILES["boletimUpload"]["tmp_name"];
			$arquivoType = $_FILES["boletimUpload"]["type"];
			$arquivoSize = $_FILES["boletimUpload"]["size"];

			date_default_timezone_set('America/Sao_Paulo');

			$data = array(
				'codigo'=>substr_replace($this->input->post('cod'),$ano=date('Y'),-4),
				'data_gerado'=>$this->input->post('dataIni'),
				'data_publicado'=>date('Y-m-d h:i:s'),
				'nome_boletim'=>$arquivoName,	
				'boletimExtra'=>$this->input->post('ckbExtra')			
			);
			
			if($arquivoType != "application/pdf" ||  $arquivoSize > 1073741824){
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!Arquivo Inválido.'));
			}else{
				if($data['boletimExtra']==1){
					$novoName="becb_".substr($data['codigo'], 0, 3)."_".substr($data['codigo'], -4).".pdf";
					$diretory = htmlentities('uploads/'.$novoName, ENT_QUOTES, "UTF-8");
	            	$upload = move_uploaded_file ($arquivoTmpLoc, $diretory);
	            	if ($upload == true) {
	            		$data['nome_boletim']=$novoName;
	            		$cadastro=$this->publico_model->cadastro($data);
	            		//var_dump($cadastro);
	            		//var_dump($data);
	            		if($cadastro===true){
	            			//echo 11; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));	
	            		}elseif($cadastro==3){
	            			//echo 12; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O boletim não é extra e já existe um boletim geral criado nessa data.'));	            		
	            		}else{
	            			//echo 13; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O Boletim não é extra, e sim geral.'));
	            		}
	           		}else{
	           			//echo 14; teste de entrada na condicão
	            		$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao fazer upload do arquivo! Arquivo Inválido'));
	            	}
            	}else{
            		$novoName="bgcb_".substr($data['codigo'], 0, 3)."_".substr($data['codigo'], -4).".pdf";
					$diretory = htmlentities('uploads/'.$novoName, ENT_QUOTES, "UTF-8");
	            	$upload = move_uploaded_file ($arquivoTmpLoc, $diretory);
	            	
	            	if ($upload == true) {
	            		$data['nome_boletim']=$novoName;
	            		$cadastro=$this->publico_model->cadastro($data);
	            		//var_dump($cadastro);
	            		//var_dump($data);
	            		if($cadastro===true){
	            			//echo 15; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));	
	            		}elseif($cadastro==2){
	            			//echo 16; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Já existe boletim criado com essa data.'));
	            		}else{
	            			//echo 18; teste de entrada na condicão
	            			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O boletim é EXTRA.'));
	            		}
	           		}else{
	           			//echo 19; teste de entrada na condicão
	            		$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao fazer upload do arquivo! Arquivo Inválido'));
	            	}
            	}			
			}
			redirect('publico/publico/index');
		}
	}

	public function listarBoletins()
	{
		$consulta = $this->publico_model->consulta();
		$diretory = 'cbmrn/new/uploads/';
		$meses=$this->publico_model->numMeses();
		$anos=$this->publico_model->numAnos();
		$index = $this->load->view('publico/publico/lista_boletins',array('consulta'=>$consulta,'diretory'=>$diretory,'meses'=>$meses,'anos'=>$anos), TRUE);
		$this->load->view('layout/index', array('layout'=>$index), FALSE);	
	}

	public function listarBoletinsIframe()
	{

		$consulta = $this->publico_model->consulta();
		$diretory = 'cbmrn/new/uploads/';
		$meses=$this->publico_model->numMeses();
		$anos=$this->publico_model->numAnos();
		$index = $this->load->view('publico/publico/listaIframe',array('consulta'=>$consulta,'diretory'=>$diretory,'meses'=>$meses,'anos'=>$anos), FALSE);
		
	}

	public function chamarIframe()
	{
		$consulta = $this->publico_model->consulta();
		$diretory = 'cbmrn/new/uploads/';
		$meses=$this->publico_model->numMeses();
		$anos=$this->publico_model->numAnos();
		$index = $this->load->view('publico/publico/iframe',array('consulta'=>$consulta,'diretory'=>$diretory,'meses'=>$meses,'anos'=>$anos), FALSE);
		
	}
	
	public function consultar()
	{	
		$resultConsulta=false;
		$index = $this->load->view('publico/publico/consulta',array('resultConsulta'=>$resultConsulta), TRUE);
		$this->load->view('layout/index', array('layout'=>$index), FALSE);
		
	}

	public function resultadoConsulta(){
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$data=array(
				'dataIni'=>$this->input->post('dataInicial'),
				'dataFim'=>$this->input->post('dataFinal'),
				);
			$resultConsulta = $this->publico_model->resultadoConsulta($data);
			$diretory = 'cbmrn/new/uploads/';	
			$index = $this->load->view('publico/publico/consulta',array('resultConsulta'=>$resultConsulta,'diretory'=>$diretory), TRUE);
			$this->load->view('layout/index', array('layout'=>$index), FALSE);
		}
	}

	public function viewExcluir()
	{	
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$data=array(
				'dataIni'=>$this->input->post('dataInicial'),
				'dataFim'=>$this->input->post('dataFinal'),
				);
			$resultConsulta = $this->publico_model->resultadoConsulta($data);
			$consulta = $this->publico_model->consulta();
			$diretory = 'cbmrn/new/uploads/';
			$meses=$this->publico_model->numMeses();
			$anos=$this->publico_model->numAnos();
			$index = $this->load->view('publico/publico/excluir',array('consulta'=>$consulta,'diretory'=>$diretory,
				'meses'=>$meses,'anos'=>$anos,'resultConsulta'=>$resultConsulta), TRUE);
			$this->load->view('layout/index', array('layout'=>$index), FALSE);
		}else{
			$consulta = $this->publico_model->consulta();
			$diretory = 'cbmrn/new/uploads/';
			$meses=$this->publico_model->numMeses();
			$anos=$this->publico_model->numAnos();
			$resultConsulta=false;
			$index = $this->load->view('publico/publico/excluir',array('consulta'=>$consulta,'diretory'=>$diretory,
				'meses'=>$meses,'anos'=>$anos,'resultConsulta'=>$resultConsulta), TRUE);
			$this->load->view('layout/index', array('layout'=>$index), FALSE);
		}
	}

	public function excluir($id){
	     if ($this->publico_model->excluir($id) == FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao excluir!'));
			  } else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Excluído com sucesso!'));
			  }
		redirect('publico/publico/viewExcluir');       
   }

}

