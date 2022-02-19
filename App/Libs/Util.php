<?php
namespace App\Libs;

/**
 * 
 */
class Util
{
	
	public static function savefiles($files,$spid,$type){
		if (count($files)>=0) {

			\App\Model\FilesModel::create()->where(['sp_id'=>$spid,'type'=>$type])->destroy();

			for ($i=0; $i < count($files); $i++) { 
				$data = [
					"type"=>$type,
					"sp_id"=>intval($spid),
					'filename'=>$files[$i]['filename'],
					'filepath'=>$files[$i]['filepath']
				];

				\App\Model\FilesModel::create($data)->save();
			}
		}

	}
}
