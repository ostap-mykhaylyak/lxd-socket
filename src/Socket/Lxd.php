<?php

namespace Socket;

class Lxd
{
	public static $socket = '/var/lib/lxd/unix.socket';
/*	
    public static function run()
    {
        $parameters = '{"name": "xenial", "source": {"type": "image", "protocol": "simplestreams", "server": "https://cloud-images.ubuntu.com/daily", "alias": "18.04"}}';
        
        $socket = '/var/lib/lxd/unix.socket';
        
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $socket);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
        
        $writeFunction = function($ch, $string)
        {
            echo $string;
            $length = strlen($string);
            printf("Received %d byte\n", $length);
            flush();
            return $length;
        };
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, $writeFunction);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        
        curl_setopt($ch, CURLOPT_URL, "a/1.0/containers");
        curl_exec($ch);
		
		if (curl_errno($ch)) {
			var_dump(curl_error($ch));
		}
		curl_close($ch);
    }
*/	
	public static function create($parameters){
		self::execute($parameters, 'POST', 'a/1.0/containers');
	}
	
	public static function remove($name){
		$parameters['name'] = $name;
		self::execute($parameters, 'DELETE', 'a/1.0/containers/'. $name);
	}
	
	public static function start($name){
		$parameters['name'] = $name;
		self::execute($parameters, 'POST', 'a/1.0/containers/'. $name);
	}
	
	public static function stop($name){
		$parameters['name'] = $name;
		self::execute($parameters, 'POST', 'a/1.0/containers/'. $name);
	}
	
	public static function info($name){
		$parameters['name'] = $name;
		self::execute($parameters, 'GET', 'a/1.0/containers/'. $name);
	}
	
	public static function list(){
		self::execute($parameters, 'POST', 'a/1.0/containers');
	}
	
	public static function execute($parameters, $request, $url, $socket){
		$parameters = json_encode($parameters);
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $socket);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
        
        $writeFunction = function($ch, $string)
        {
            echo $string;
            $length = strlen($string);
            // printf("Received %d byte\n", $length);
            flush();
            // return $length;
        };
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, $writeFunction);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
		
		if (curl_errno($ch)) {
			var_dump(curl_error($ch));
		}
		curl_close($ch);	
	}
}