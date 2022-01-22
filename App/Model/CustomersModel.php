<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * CustomersModel
 * Class CustomersModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $address //
 * @property string $type //
 * @property string $contact //
 * @property string $phone //
 * @property string $think //
 * @property string $fromwhere //
 * @property string $remark //
 * @property string $info //
 * @property string $addtime //
 */
class CustomersModel extends AbstractModel
{
	protected $tableName = 'siam_customers';


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
		string $think,
		string $fromwhere,
		string $remark,
		string $info,
		string $addtime
	): int {
		$data = [
		    'name'=>$name,
		    'address'=>$address,
		    'type'=>$type,
		    'contact'=>$contact,
		    'phone'=>$phone,
		    'think'=>$think,
		    'fromwhere'=>$fromwhere,
		    'remark'=>$remark,
		    'info'=>$info,
		    'addtime'=>$addtime,
		];
		$model = new self($data);
		return $model->save();
	}
}

