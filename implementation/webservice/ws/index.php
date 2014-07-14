<?php
    if(('on' == $_SERVER['HTTPS']))
	{
		$uri = 'https://';
	}else{
		try{
			$_SERVER['HTTPS'] = 'on';
			$uri = 'https://';
		}catch(Exception $exc){
			$uri = 'http://';
		}
	}
        $uri .= $_SERVER['HTTP_HOST'];
        header('Location: '.$uri.'/ws/views/');
?>