<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SAP RFC Email Class
 *
 * Memungkinan berkomunikasi dengan data SAP via BAPI.
 *
 * @package		Awsomeness
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Freon L
 */
class Saprfc{
	var $ashost		= '10.9.11.100';
	var $sysnr 		= '30';
	var $client 	= '600';
	var $user 		= 'HCM-PORTAL-1';
	var $passwd 	= 'hris2010';
	var $msgsrv 	= '';
	var $r3name 	= 'LHR';
	var $codepage = '4110';

	function Saprfc($config = array()){
		if (count($config) == 0)
		{
			$config['ashost'] = $this->ashost;
			$config['sysnr'] = $this->sysnr;
			$config['client'] = $this->client;
			$config['user'] = $this->user;
			$config['passwd'] = $this->passwd;
			$config['msgsrv'] = $this->msgsrv;
			$config['r3name'] = $this->r3name;
			$config['codepage'] = $this->codepage;
		}

			$this->sapAttr($config);
	}
	
	function sapAttr($config) {
		$this->sapConn = array (
			"ASHOST"=>$config['ashost'],
			"SYSNR"=>$config['sysnr'],
			"CLIENT"=>$config['client'],
			"USER"=>$config['user'],
			"PASSWD"=>$config['passwd'],
			"MSGSRV"=>$config['msgsrv'],
			"R3NAME"=>$config['r3name'],
			"CODEPAGE"=>$config['codepage']);
		return $this->sapConn;	
	}
		
	function connect() {
		return $this->rfc = saprfc_open($this->sapConn);
	}
	
	function functionDiscover($functionName) {
		$this->fce = saprfc_function_discover($this->rfc, $functionName) or die ("fungsi $functionName tidak ditemukan");

	}

	function importParameter($importParamName, $importParamValue) {
		
		for ($i=0;$i<count($importParamName);$i++) {
			saprfc_import ($this->fce,$importParamName[$i],$importParamValue[$i]);
		}
	}
		
	function setInitTable($initTableName) {
		saprfc_table_init ($this->fce,$initTableName);
	}
	
	function executeSAP() {
		$this->rfc_rc = saprfc_call_and_receive($this->fce);
		if ($this->rfc_rc != SAPRFC_OK){
			if ($this->rfc == SAPRFC_EXCEPTION )
				echo ("Exception raised: ".saprfc_exception($this->fce));
			else
				echo ("Call error: ".saprfc_error($this->fce));
		}
		return $this->rfc_rc;
	}
	function getParameter($ParamName){
		return saprfc_export ($this->fce,$ParamName);
	}
	function fetch_rows($initTableName) { //untuk banyak baris

		$rows = saprfc_table_rows($this->fce,$initTableName);

		if($rows < 1){ 
			$_dataRows = NULL; 
		}
		for ($i=1; $i<=$rows; $i++){
	 		$_dataRows[$i] = saprfc_table_read ($this->fce,$initTableName,$i);
	 	}
		return $_dataRows;
	}
	function fetch_row($initTableName) { //untuk satu baris
		$_dataRows = saprfc_table_read ($this->fce,$initTableName,1);
		return $_dataRows;
	}
	
	function free() {
		saprfc_function_free($this->fce);
	}
	
	function close() {
		saprfc_close($this->rfc);
	}
	
	function insert($initTableName,$importParamValue){
		return saprfc_table_insert ($this->fce, $initTableName, $importParamValue, 1);
	}
	
	function export($initTableName){
		return saprfc_export ($this->fce,$initTableName);
	}
}
