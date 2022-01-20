<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * RateModel
 * Class RateModel
 * Create With ClassGeneration
 * @property int $id //
 * @property float $name //
 */
class RateModel extends AbstractModel
{
	protected $tableName = 'siam_rate';


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


	public function addData(float $name): self
	{
		$data = [
		    'name'=>$name,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

