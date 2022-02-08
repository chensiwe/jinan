<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * ThinkModel
 * Class ThinkModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 */
class ThinkModel extends AbstractModel
{
	protected $tableName = 'siam_think';


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


	public function addData(string $name): self
	{
		$data = [
		    'name'=>$name,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

