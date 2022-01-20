<?php

namespace App\HttpController\Api;

use App\Model\BorrowModel;
use EasySwoole\Component\Context\ContextManager;
use EasySwoole\HttpAnnotation\AnnotationController;
use EasySwoole\HttpAnnotation\AnnotationTag\Api;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiDescription;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiFail;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiGroup;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiGroupAuth;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiGroupDescription;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiRequestExample;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiSuccess;
use EasySwoole\HttpAnnotation\AnnotationTag\ApiSuccessParam;
use EasySwoole\HttpAnnotation\AnnotationTag\InjectParamsContext;
use EasySwoole\HttpAnnotation\AnnotationTag\Method;
use EasySwoole\HttpAnnotation\AnnotationTag\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Borrow
 * Class Borrow
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Borrow")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Borrow extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Borrow/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="customer",lengthMax="15",required="")
	 * @Param(name="phone",lengthMax="15",required="")
	 * @Param(name="bank",lengthMax="25",required="")
	 * @Param(name="mj",lengthMax="25",required="")
	 * @Param(name="xd",lengthMax="25",required="")
	 * @Param(name="card",lengthMax="30",required="")
	 * @Param(name="cash",required="",defaultValue="0.00")
	 * @Param(name="helper",lengthMax="20",required="")
	 * @Param(name="approvetime",lengthMax="15",required="")
	 * @Param(name="expiretime",lengthMax="20",required="")
	 * @Param(name="backtime",lengthMax="15",required="")
	 * @Param(name="fromwho",lengthMax="15",required="")
	 * @Param(name="way",lengthMax="15",required="")
	 * @Param(name="sourcecash",lengthMax="20",required="")
	 * @Param(name="rate",required="")
	 * @Param(name="customertype",lengthMax="6",required="")
	 * @Param(name="isbridge",lengthMax="1",required="")
	 * @Param(name="bridgecash",required="")
	 * @Param(name="remark",lengthMax="100",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'customer'=>$param['customer'],
		    'phone'=>$param['phone'],
		    'bank'=>$param['bank'],
		    'mj'=>$param['mj'],
		    'xd'=>$param['xd'],
		    'card'=>$param['card'],
		    'cash'=>$param['cash'],
		    'helper'=>$param['helper'],
		    'approvetime'=>strtotime($param['approvetime']),
		    'expiretime'=>strtotime($param['expiretime']),
		    'backtime'=>strtotime($param['backtime']),
		    'fromwho'=>$param['fromwho'],
		    'way'=>$param['way'],
		    'sourcecash'=>$param['sourcecash'],
		    'rate'=>$param['rate'],
		    'customertype'=>$param['customertype'],
		    'isbridge'=>$param['isbridge'],
		    'bridgecash'=>$param['bridgecash'],
		    'remark'=>$param['remark'],
		    'addtime'=>time(),
		];
		$model = new BorrowModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Borrow/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",required="")
	 * @Param(name="customer",lengthMax="15",optional="")
	 * @Param(name="phone",lengthMax="15",optional="")
	 * @Param(name="bank",lengthMax="25",optional="")
	 * @Param(name="mj",lengthMax="25",optional="")
	 * @Param(name="xd",lengthMax="25",optional="")
	 * @Param(name="card",lengthMax="30",optional="")
	 * @Param(name="cash",optional="",defaultValue="0.00")
	 * @Param(name="helper",lengthMax="20",optional="")
	 * @Param(name="approvetime",lengthMax="15",optional="")
	 * @Param(name="expiretime",lengthMax="20",optional="")
	 * @Param(name="backtime",lengthMax="15",optional="")
	 * @Param(name="fromwho",lengthMax="15",optional="")
	 * @Param(name="way",lengthMax="15",optional="")
	 * @Param(name="sourcecash",lengthMax="20",optional="")
	 * @Param(name="rate",optional="")
	 * @Param(name="customertype",lengthMax="6",optional="")
	 * @Param(name="isbridge",lengthMax="1",optional="")
	 * @Param(name="bridgecash",optional="")
	 * @Param(name="remark",lengthMax="100",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new BorrowModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['customer']=$param['customer'] ?? $info->customer;
		$updateData['phone']=$param['phone'] ?? $info->phone;
		$updateData['bank']=$param['bank'] ?? $info->bank;
		$updateData['mj']=$param['mj'] ?? $info->mj;
		$updateData['xd']=$param['xd'] ?? $info->xd;
		$updateData['card']=$param['card'] ?? $info->card;
		$updateData['cash']=$param['cash'] ?? $info->cash;
		$updateData['helper']=$param['helper'] ?? $info->helper;
		$updateData['approvetime']=$param['approvetime'] ?? $info->approvetime;
		$updateData['expiretime']=$param['expiretime'] ?? $info->expiretime;
		$updateData['backtime']=$param['backtime'] ?? $info->backtime;
		$updateData['fromwho']=$param['fromwho'] ?? $info->fromwho;
		$updateData['way']=$param['way'] ?? $info->way;
		$updateData['sourcecash']=$param['sourcecash'] ?? $info->sourcecash;
		$updateData['rate']=$param['rate'] ?? $info->rate;
		$updateData['customertype']=$param['customertype'] ?? $info->customertype;
		$updateData['isbridge']=$param['isbridge'] ?? $info->isbridge;
		$updateData['bridgecash']=$param['bridgecash'] ?? $info->bridgecash;
		$updateData['remark']=$param['remark'] ?? $info->remark;
		$updateData['addtime']=$param['addtime'] ?? $info->addtime;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Borrow/getOne")
	 * @ApiDescription("获取一条数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"获取成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"获取失败"})
	 * @Param(name="id",required="")
	 * @ApiSuccessParam(name="result.id",description="")
	 * @ApiSuccessParam(name="result.customer",description="")
	 * @ApiSuccessParam(name="result.phone",description="")
	 * @ApiSuccessParam(name="result.bank",description="")
	 * @ApiSuccessParam(name="result.mj",description="")
	 * @ApiSuccessParam(name="result.xd",description="")
	 * @ApiSuccessParam(name="result.card",description="")
	 * @ApiSuccessParam(name="result.cash",description="")
	 * @ApiSuccessParam(name="result.helper",description="")
	 * @ApiSuccessParam(name="result.approvetime",description="")
	 * @ApiSuccessParam(name="result.expiretime",description="")
	 * @ApiSuccessParam(name="result.backtime",description="")
	 * @ApiSuccessParam(name="result.fromwho",description="")
	 * @ApiSuccessParam(name="result.way",description="")
	 * @ApiSuccessParam(name="result.sourcecash",description="")
	 * @ApiSuccessParam(name="result.rate",description="")
	 * @ApiSuccessParam(name="result.customertype",description="")
	 * @ApiSuccessParam(name="result.isbridge",description="")
	 * @ApiSuccessParam(name="result.bridgecash",description="")
	 * @ApiSuccessParam(name="result.remark",description="")
	 * @ApiSuccessParam(name="result.addtime",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new BorrowModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Borrow/getList")
	 * @ApiDescription("获取数据列表")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"获取成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"获取失败"})
	 * @Param(name="page", from={GET,POST}, alias="页数", optional="")
	 * @Param(name="pageSize", from={GET,POST}, alias="每页总数", optional="")
	 * @ApiSuccessParam(name="result[].id",description="")
	 * @ApiSuccessParam(name="result[].customer",description="")
	 * @ApiSuccessParam(name="result[].phone",description="")
	 * @ApiSuccessParam(name="result[].bank",description="")
	 * @ApiSuccessParam(name="result[].mj",description="")
	 * @ApiSuccessParam(name="result[].xd",description="")
	 * @ApiSuccessParam(name="result[].card",description="")
	 * @ApiSuccessParam(name="result[].cash",description="")
	 * @ApiSuccessParam(name="result[].helper",description="")
	 * @ApiSuccessParam(name="result[].approvetime",description="")
	 * @ApiSuccessParam(name="result[].expiretime",description="")
	 * @ApiSuccessParam(name="result[].backtime",description="")
	 * @ApiSuccessParam(name="result[].fromwho",description="")
	 * @ApiSuccessParam(name="result[].way",description="")
	 * @ApiSuccessParam(name="result[].sourcecash",description="")
	 * @ApiSuccessParam(name="result[].rate",description="")
	 * @ApiSuccessParam(name="result[].customertype",description="")
	 * @ApiSuccessParam(name="result[].isbridge",description="")
	 * @ApiSuccessParam(name="result[].bridgecash",description="")
	 * @ApiSuccessParam(name="result[].remark",description="")
	 * @ApiSuccessParam(name="result[].addtime",description="")
	 */
	public function getList()
	{

	$redis=\EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        

        $allreds = $redis->hkeys("money");
        for ($i=0; $i < count($allreds); $i++) { 
        	$allreds[$i] = intval($allreds[$i]);
        }

        var_dump($allreds);


 \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);

		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new BorrowModel();
		$data = $model->getList($page, $pageSize);
		for ($i=0; $i < count($data['list']); $i++) { 
			if (in_array($data['list'][$i]['id'], $allreds)) {
			
				$data['list'][$i]['color'] = "red";
			}
		}
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Borrow/delete")
	 * @ApiDescription("删除数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="id",required="")
	 */
	public function delete()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new BorrowModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}


	public function getreminder(){

		 $redis=\EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
       
		// $redis=\App\Libs\RedisUtil::getInstance();
		$list = $redis->hGetall("money");
		var_dump($list);
		$ret = 0;
		foreach ($list as $key => $value) {
			if ($value == "0") {
				$ret = $key;
			}
		}

		var_dump($ret);

		$data = \App\Model\BorrowModel::create()->get(['id'=>$ret]);
  \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);

		$this->writeJson(Status::CODE_OK, $data, "删除成功.");
	}


	public function setread(){

		$datas = $this->request()->getRequestParam();

		$id = $datas['id'];

		$redis=\App\Libs\RedisUtil::getInstance();
		$redis->hSet("money",intval($id),"1");
		 \EasySwoole\Pool\Manager::getInstance()->get('redis')->recycleObj($redis);
		$this->writeJson(Status::CODE_OK, [], "删除成功.");

	}





}

