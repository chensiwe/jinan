<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CallbookModel
 * Class CallbookModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $address //
 * @property string $type //
 * @property string $contact //
 * @property string $phone //
 * @property string $ramark //
 * @property string $info //
 * @property int $addtime //
 */
class CallbookModel extends AbstractModel
{
	protected $tableName = 'siam_callbook';


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
		string $address,
		string $type,
		string $contact,
		string $phone,
		string $ramark,
		string $info,
		int $addtime
	): self {
		$data = [
		    'name'=>$name,
		    'address'=>$address,
		    'type'=>$type,
		    'contact'=>$contact,
		    'phone'=>$phone,
		    'ramark'=>$ramark,
		    'info'=>$info,
		    'addtime'=>$addtime,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

