<?php
	require 'firefox_FB.php';
	require 'firefox_FirePHP.php';
	ob_start();
	define('PPCART_DEBUG', true);
	function trace($content,$is_exit=false){
		ppcart_debug_trace($content,$is_exit);
	}
	function trace_param($is_exit=false){
		ppcart_debug_trace_param($is_exit);
	}
	

	function ppcart_debug_trace($content,$is_exit=false){
		if(PPCART_DEBUG===true){
			fb($content);
			if($is_exit)exit();	
		}
	}

	function ppcart_debug_trace_param($is_exit=false){
		if(PPCART_DEBUG===true){
			fb('param:',FirePHP::TRACE);
			if($is_exit)exit();
		}
	}
	
	function ppcart_debug_logs($content,$type='default',$params=null){
		if(!isset($params['save_mode'])){
			$params['save_mode'] = 'print';
		}
		$dir_logs = PPCART_ROOT_DIR_USER.'/logs';
		if(!is_dir($dir_logs)){
			mkdir($dir_logs);
		}
		$dir_logs = $dir_logs.'/'.$type;
		if(!is_dir($dir_logs)){
			mkdir($dir_logs);
		}
		if(isset($params['file_name'])){
			$file_name = $params['file_name'].'.logs';
		}else{
			$file_name = date('Y-m-d H_i_s',time()).'.logs';
		}
		$file_logs = $dir_logs.'/'.$file_name;
		
		$start_content = '';
		$end_content = '';
		if(file_exists($file_logs)){
			$start_content = file_get_contents($file_logs);
		}
		if(isset($params['title'])){
			$start_content .=("\r\n------------------------------------".$params['title']."[Start]\r\n");
			$end_content = ("\r\n------------------------------------".$params['title']."[End]\r\n");
		}
		if($params['save_mode']=='print'){
			file_put_contents($file_logs, $start_content.print_r($content,true).$end_content);
		}else if(strcmp($params['save_mode'], 'ser')==0){
			file_put_contents($file_logs, $start_content.serialize($content).$end_content);
		}
		return $file_name;
	}
	

	function ppcart_debug_exit($message){
		ppcart_exit($message);
	}
	

	function ppcart_debug_get_message_not_file($file_name_string){
		return 'File not found on '.$file_name_string;
	}