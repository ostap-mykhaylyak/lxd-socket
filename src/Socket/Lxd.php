<?php
namespace Socket;

class Lxd
{
    public static $socket = '/var/lib/lxd/unix.socket';
    public static $api = 'a/1.0/';


    public static function Execute($parameters, $request, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, self::$socket);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);

        $writeFunction = function ($ch, $string)
        {
            //echo $string;
            $length = strlen($string);
            //printf("Received %d byte\n", $length);
            flush();
            return $length;
        }
        ;
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, $writeFunction);
        // if request POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

        curl_setopt($ch, CURLOPT_URL, self::$api . $url);
        curl_exec($ch);

        if (curl_errno($ch))
        {
            var_dump(curl_error($ch));
        }
        curl_close($ch);
    }

    public static function setApi($api)
    {
        self::$api = $api;
    }

    public static function setSocket($socket)
    {
        self::$socket = $socket;
    }

    public static function create($parameters)
    {
        Lxd::Execute($parameters, 'POST', 'containers');
    }

    public static function start($name)
    {
        $parameters = '{"action": "start"}';
        Lxd::Execute($parameters, 'PUT', 'containers/' . $name . '/state');
    }

    public static function stop($name)
    {
        $parameters = '{"action": "stop", "force": true}';
        Lxd::Execute($parameters, 'PUT', 'containers/' . $name . '/state');
    }

    public static function remove($name)
    {
        $parameters = '';
        Lxd::Execute($parameters, 'DELETE', 'containers/' . $name);
    }
}