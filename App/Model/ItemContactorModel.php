<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * ItemContactorModel
 * Class ItemContactorModel
 * Create With ClassGeneration
 * @property int $id //
 * @property int $conid //
 * @property int $itemid //
 * @property string $addtime //
 */
class ItemContactorModel extends AbstractModel
{
	protected $tableName = 'siam_item_contactor';


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


	public function addData(int $conid, int $itemid, string $addtime): self
	{
		$data = [
		    'conid'=>$conid,
		    'itemid'=>$itemid,
		    'addtime'=>$addtime,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

