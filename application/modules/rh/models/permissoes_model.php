<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Permissoes_model extends CI_Model {

  private $table_name = "permissoes";

  function __construct() {
    parent::__construct();
    $this->load->database();
  }
}