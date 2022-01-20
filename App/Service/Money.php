<?php
namespace App\Service;

use App\Libs\RedisUtil;
/**
 * 
 */
class Money
{
	

	public static function check(){

		 $redis=\EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
    
   
		$model = new \App\Model\BorrowModel();
		$alllist = $model->getall();
		foreach ($alllist as $key => $value) {
			
			$expiretime = $value['expiretime'];


			if ($redis->hExists("money",$value['id']) == false) {
				
			
			if (($expiretime-time())<=2*30*24*60*60) {
				//小于提醒日期，写入提醒redis list
				//0代提醒，1已提醒
				$redis->hSet("money",$value['id'],0);
			}
		}
}

  \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);

	}



}