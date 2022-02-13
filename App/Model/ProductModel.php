<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * ProductModel
 * Class ProductModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $name //
 * @property string $cas //
 * @property string $chemical //
 * @property int $cate //
 * @property string $brand //
 * @property string $pack //
 * @property string $market //
 * @property string $properties //
 * @property string $content //
 * @property string $usefor //
 * @property string $remark //
 * @property string $sameitem //
 * @property string $createtime //
 */
class ProductModel extends AbstractModel
{
	protected $tableName = 'siam_product';


	public function getList(int $page = 1, int $pageSize = 10, string $field = '*'): array
	{
		$list = $this
		    ->withTotalCount()
			->order("cate","ASC")
			->order($this->schemaInfo()->getPkFiledName(), 'ASC')
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
		string $cas,
		string $chemical,
		int $cate,
		string $brand,
		string $pack,
		string $market,
		string $properties,
		string $content,
		string $usefor,
		string $remark,
		string $sameitem,
		string $createtime,
		int $ordernum,
		string $aliasname
	): int {
		$data = [
		    'name'=>$name,
		    'cas'=>$cas,
		    'chemical'=>$chemical,
		    'cate'=>$cate,
		    'brand'=>$brand,
		    'pack'=>$pack,
		    'market'=>$market,
		    'properties'=>$properties,
		    'content'=>$content,
		    'usefor'=>$usefor,
		    'remark'=>$remark,
		    'sameitem'=>$sameitem,
		    'createtime'=>$createtime,
		    'ordernum'=>$ordernum,
		    'aliasname'=>$aliasname,
		];
		$model = new self($data);
		
		return $model->save();
	}
}

