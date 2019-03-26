<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class almanaque_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}



}