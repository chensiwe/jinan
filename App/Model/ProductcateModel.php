<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * ProductcateModel
 * Class ProductcateModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $createtime //
 * @property int $status //
 */
class ProductcateModel extends AbstractModel
{
	protected $tableName = 'siam_productcate';


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


	public function addData(string $name, string $createtime, int $status): self
	{
		$data = [
		    'name'=>$name,
		    'createtime'=>$createtime,
		    'status'=>$status,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

