<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CustomerModel
 * Class CustomerModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $time //
 * @property string $info //
 * @property int $customer_id //
 */
class CustomerModel extends AbstractModel
{
	protected $tableName = 'siam_customerlog';


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


	public function addData(string $time, string $info, int $customer_id): self
	{
		$data = [
		    'time'=>$time,
		    'info'=>$info,
		    'customer_id'=>$customer_id,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

