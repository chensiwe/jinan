<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * XdModel
 * Class XdModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $addtime //
 */
class XdModel extends AbstractModel
{
	protected $tableName = 'siam_xd';


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


	public function addData(string $name, string $addtime): self
	{
		$data = [
		    'name'=>$name,
		    'addtime'=>$addtime,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

