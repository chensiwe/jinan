<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CustomerItemPriceModel
 * Class CustomerItemPriceModel
 * Create With ClassGeneration
 * @property int $id //
 * @property int $pid //
 * @property string $name //
 * @property int $numbers //
 * @property float $price //
 * @property string $buytime //
 * @property int $customer_id //
 */
class CustomerItemPriceModel extends AbstractModel
{
	protected $tableName = 'siam_customer_item_price';


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


	public function addData(int $pid, string $name, int $numbers, float $price, string $buytime, int $customer_id,$brand): self
	{
		$data = [
		    'pid'=>$pid,
		    'name'=>$name,
		    'numbers'=>$numbers,
		    'price'=>$price,
		    'buytime'=>$buytime,
		    'customer_id'=>$customer_id,
		    'brand'=>$brand,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

