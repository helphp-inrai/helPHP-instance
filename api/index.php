<?php
namespace helPHP\api;

include_once('../config/main.php');
include_once(\Config::HELPHP_FOLDER.'autoload.php');
include_once(\Config::HELPHP_FOLDER.'libs/externals/Restserver.php');

use helPHP\libs\Restresponse;
use helPHP\libs\Utils;
use RestService\Server;

/**
 * main universal routes working with the help of 
 * libs/externals/Restserver.php as REST micro server
 * and calling libs/Restreponse.php for processing.
 * 
 * You can call all methods that are in Restresponse, 
 * but also all public method of any modules !
 * 
 * @see tests/rest a test Rest client designed for this API 
 */
class routes {
    public $not_crypted=true; // do we send / receive cryted data ? 

    public function postCommand($name, $action,$param){
        $response = new Restresponse($name,$action,$param,$this->not_crypted);
        $response->format='raw';
        return $response;
    }
    public function postModule($module, $action,$param){
        $response = new Restresponse($module,$action,$param,$this->not_crypted);
        $response->format='Json';
        return $response;
    }
    public function getCommand($name, $action,$param){
        $response = new Restresponse($name,$action,$param,$this->not_crypted);
        $response->format='raw';
        return $response;
    }
    public function getModule($module, $action,$param){
        $response = new Restresponse($module,$action,$param,$this->not_crypted);
        $response->format='Json';
        return $response;
    }
    public function deleteCommand($name, $action,$param){
        $response = new Restresponse($name,$action,$param,$this->not_crypted);
        $response->format='raw';
        return $response;
    }
    public function deleteModule($module, $action,$param){
        $response = new Restresponse($module,$action,$param,$this->not_crypted);
        $response->format='Json';
        return $response;
    }
    public function putCommand($name, $action,$param){
        $response = new Restresponse($name,$action,$param,$this->not_crypted);
        $response->format='raw';
        return $response;
    }
    public function putModule($module, $action,$param){
        $response = new Restresponse($module,$action,$param,$this->not_crypted);
        $response->format='Json';
        return $response;
    }
}

//the main rest server class is documented there : https://phprest.cjr.app
//you can add aditionnal access control in setCheckAccess part 
//please adapt $limit to your needs
Server::create('/', 'helPHP\api\routes')
    ->getClient()
    ->setCustomFormat(function($response) {
        if (isset($response['data']->format)){
            if($response['data']->format=='raw'){
                return $response['data']->data;
            }else{
                header('Content-Type: application/json; charset=utf-8');
                unset($response['data']->format);
                $response['OID']=$response['data']->oid;
                $response['data']=$response['data']->data;
                return json_encode($response);
            }
        }else{
            exit;   
        }
    })
    ->setFormat('custom')
    ->getController()
    ->setDebugMode(true)
    ->collectRoutes()
    ->setCheckAccess(function($url, $route, $method, $args) {
        $redis = new \Redis();
        $redis->connect(\Config::REDIS_HOST, \Config::REDIS_PORT);;
    
        $key = "api_".$_SERVER['REMOTE_ADDR'];
        $limit = 50;
        $time = 60;
        
        $count = $redis->get($key);
        if ($count >= $limit) {
            throw new \Exception("Rate Limit Exceeded", 429);
        }
        $redis->incr($key);
        $redis->expire($key, $time);
    })
->run();