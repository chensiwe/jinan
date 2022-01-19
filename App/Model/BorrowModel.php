<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * BorrowModel
 * Class BorrowModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $customer //
 * @property string $phone //
 * @property string $bank //
 * @property string $mj //
 * @property string $xd //
 * @property string $card //
 * @property float $cash //
 * @property string $helper //
 * @property string $approvetime //
 * @property string $expiretime //
 * @property string $backtime //
 * @property string $fromwho //
 * @property string $way //
 * @property string $sourcecash //
 * @property float $rate //
 * @property string $customertype //
 * @property int $isbridge //
 * @property int $bridgecash //
 * @property string $remark //
 * @property string $addtime //
 */
class BorrowModel extends AbstractModel
{
	protected $tableName = 'siam_borrow';


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


	public function getall(){


		$list = $this->all();
		return $list;

	}

	public function addData(
		string $customer,
		string $phone,
		string $bank,
		string $mj,
		string $xd,
		string $card,
		float $cash,
		string $helper,
		string $approvetime,
		string $expiretime,
		string $backtime,
		string $fromwho,
		string $way,
		string $sourcecash,
		float $rate,
		string $customertype,
		int $isbridge,
		int $bridgecash,
		string $remark,
		string $addtime
	): self {
		$data = [
		    'customer'=>$customer,
		    'phone'=>$phone,
		    'bank'=>$bank,
		    'mj'=>$mj,
		    'xd'=>$xd,
		    'card'=>$card,
		    'cash'=>$cash,
		    'helper'=>$helper,
		    'approvetime'=>$approvetime,
		    'expiretime'=>$expiretime,
		    'backtime'=>$backtime,
		    'fromwho'=>$fromwho,
		    'way'=>$way,
		    'sourcecash'=>$sourcecash,
		    'rate'=>$rate,
		    'customertype'=>$customertype,
		    'isbridge'=>$isbridge,
		    'bridgecash'=>$bridgecash,
		    'remark'=>$remark,
		    'addtime'=>$addtime,
		];
		$model = new self($data);
		$model->save();
		return $model;
	}
}

