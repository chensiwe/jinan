<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * ContactorModel
 * Class ContactorModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $items //
 * @property string $phone //
 * @property string $addtime //
 * @property int $supplyid //
 */
class ContactorModel extends AbstractModel
{
	protected $tableName = 'siam_contactor';


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


	public function addData(string $name, string $items, string $phone, string $addtime, int $supplyid): self
	{
		$data = [
		    'name'=>$name,
		    'items'=>$items,
		    'phone'=>$phone,
		    'addtime'=>$addtime,
		    'supplyid'=>$supplyid,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

