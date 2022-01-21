<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * SupplyProductRelateModel
 * Class SupplyProductRelateModel
 * Create With ClassGeneration
 * @property int $id //
 * @property int $supplyid //
 * @property string $supplyname //
 * @property string $contactorname //
 * @property string $contactphone //
 * @property string $supplytype //
 * @property string $createtime //
 * @property float $price //
 * @property string $address //
 * @property string $priceinfo //
 * @property int $buynumber //
 * @property int $pid //
 */
class SupplyProductRelateModel extends AbstractModel
{
	protected $tableName = 'siam_supply_product_relate';


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


	public function addData(
		int $supplyid,
		string $supplyname,
		string $contactorname,
		string $contactphone,
		string $supplytype,
		string $createtime,
		float $price,
		string $address,
		string $priceinfo,
		int $buynumber,
		int $pid
	): self {
		$data = [
		    'supplyid'=>$supplyid,
		    'supplyname'=>$supplyname,
		    'contactorname'=>$contactorname,
		    'contactphone'=>$contactphone,
		    'supplytype'=>$supplytype,
		    'createtime'=>$createtime,
		    'price'=>$price,
		    'address'=>$address,
		    'priceinfo'=>$priceinfo,
		    'buynumber'=>$buynumber,
		    'pid'=>$pid,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

