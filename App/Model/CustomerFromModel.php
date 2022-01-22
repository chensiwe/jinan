<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CustomerFromModel
 * Class CustomerFromModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 */
class CustomerFromModel extends AbstractModel
{
	protected $tableName = 'siam_customer_from';


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

