<?php

namespace App\ModelApp;

use EasySwoole\ORM\AbstractModel;

/**
 * SupplyModel
 * Class SupplyModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $contactor //
 * @property string $phone //
 * @property string $address //
 * @property string $remark //
 * @property string $info //
 * @property string $createtime //
 * @property int $status //
 */
class SupplyModel extends AbstractModel
{
	protected $tableName = 'siam_supply';


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
		string $name,
		string $contactor,
		string $phone,
		string $address,
		string $remark,
		string $info,
		string $createtime,
		int $status
	): self {
		$data = [
		    'name'=>$name,
		    'contactor'=>$contactor,
		    'phone'=>$phone,
		    'address'=>$address,
		    'remark'=>$remark,
		    'info'=>$info,
		    'createtime'=>$createtime,
		    'status'=>$status,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

