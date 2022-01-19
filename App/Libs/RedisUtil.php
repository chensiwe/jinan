<?php
namespace App\Libs;


use EasySwoole\Component\Singleton;
/**
 * 
 */
class Redisutil 
{
	
	

    use Singleton;
    
    private $redis = null;
    
    private function __construct(){
        try {
            $this->redis = new \Redis();
            $redisConfig = \EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS');
            var_dump($redisConfig);
            $result = $this->redis->connect($redisConfig['host'], $redisConfig['port']);
            
            $this->redis->auth($redisConfig['auth']);
            $this->redis->select($redisConfig['db']);
            
        } catch (\Exception $e) {
            throw new \Exception('redis链接失败');
        }
        if(!$result){
            throw new \Exception('redis链接失败');
        }
    }
     /**
     * 魔术方法静态调用
     * @param $method_name
     * @param $param
     * @return mixed
     */
    public function __call($method_name, $param)
    {
        try {
            
            return call_user_func_array([$this->redis, $method_name], $param);
        } catch (\Exception $e) {
            return false;
        }
    }








}