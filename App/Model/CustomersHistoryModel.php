<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CustomersHistoryModel
 * Class CustomersHistoryModel
 * Create With ClassGeneration
 * @property int $id //
 * @property int $cus_id //
 * @property string $time //
 * @property string $info //
 */
class CustomersHistoryModel extends AbstractModel
{
	protected $tableName = 'siam_customers_history';


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


	public function addData(int $cus_id, string $time, string $info): self
	{
		$data = [
		    'cus_id'=>$cus_id,
		    'time'=>$time,
		    'info'=>$info,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

