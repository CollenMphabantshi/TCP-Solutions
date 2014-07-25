<?php
    if(('on' == $_SERVER['HTTPS']))
	{
		$uri = 'http://';
	}else{
		try{
			$_SERVER['HTTPS'] = 'on';
			$uri = 'http://';
		}catch(Exception $exc){
			$uri = 'http://';
		}
	}
        $uri .= $_SERVER['HTTP_HOST'];
        header('Location: '.$uri.'/ws/views/');
?>