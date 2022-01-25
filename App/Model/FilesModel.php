<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * FilesModel
 * Class FilesModel
 * Create With ClassGeneration
 * @property int $id //
 * @property int $type //
 * @property int $sp_id //
 * @property string $filepath //
 * @property string $filename //
 */
class FilesModel extends AbstractModel
{
	protected $tableName = 'siam_files';


	public function getList(int $page = 1, int $pageSize = 10, string $field = '*'): array
	{
		$list = $this
		    ->withTotalCount()
			->order($this->schemaInfo()->getPkFiledName(), 'DESC')
		    ->field($field)
		    ->page($page, $pageSize)
		    ->all();
		$total = $this->lastQueryResult()->getTotalCount();
		$data = [
		    'page'=>$page,
		    'pageSize'=>$pageSize,
		    'list'=>$list,
		    'total'=>$total,
		    'pageCount'=>ceil($total / $pageSize)
		];
		return $data;
	}


	public function addData(int $type, int $sp_id, string $filepath, string $filename): self
	{
		$data = [
		    'type'=>$type,
		    'sp_id'=>$sp_id,
		    'filepath'=>$filepath,
		    'filename'=>$filename,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

