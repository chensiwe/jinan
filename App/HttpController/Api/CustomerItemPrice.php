<?php

namespace App\HttpController\Api;

use App\Model\CustomerItemPriceModel;
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
 * CustomerItemPrice
 * Class CustomerItemPrice
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.CustomerItemPrice")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class CustomerItemPrice extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/CustomerItemPrice/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="pid",lengthMax="11",required="")
	 * @Param(name="name",lengthMax="100",required="")
	 * @Param(name="numbers",lengthMax="11",required="")
	 * @Param(name="price",lengthMax="Array",required="")
	 * @Param(name="buytime",lengthMax="16",required="")
	 * @Param(name="customer_id",lengthMax="11",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'pid'=>$param['pid'],
		    'name'=>$param['name'],
		    'numbers'=>$param['numbers'],
		    'price'=>$param['price'],
		    'buytime'=>$param['buytime'],
		    'customer_id'=>$param['customer_id'],
		];
		$model = new CustomerItemPriceModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/CustomerItemPrice/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="pid",lengthMax="11",optional="")
	 * @Param(name="name",lengthMax="100",optional="")
	 * @Param(name="numbers",lengthMax="11",optional="")
	 * @Param(name="price",lengthMax="Array",optional="")
	 * @Param(name="buytime",lengthMax="16",optional="")
	 * @Param(name="customer_id",lengthMax="11",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CustomerItemPriceModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['pid']=$param['pid'] ?? $info->pid;
		$updateData['name']=$param['name'] ?? $info->name;
		$updateData['numbers']=$param['numbers'] ?? $info->numbers;
		$updateData['price']=$param['price'] ?? $info->price;
		$updateData['buytime']=$param['buytime'] ?? $info->buytime;
		$updateData['customer_id']=$param['customer_id'] ?? $info->customer_id;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/CustomerItemPrice/getOne")
	 * @ApiDescription("获取一条数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"获取成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"获取失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @ApiSuccessParam(name="result.id",description="")
	 * @ApiSuccessParam(name="result.pid",description="")
	 * @ApiSuccessParam(name="result.name",description="")
	 * @ApiSuccessParam(name="result.numbers",description="")
	 * @ApiSuccessParam(name="result.price",description="")
	 * @ApiSuccessParam(name="result.buytime",description="")
	 * @ApiSuccessParam(name="result.customer_id",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CustomerItemPriceModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/CustomerItemPrice/getList")
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
	 * @ApiSuccessParam(name="result[].pid",description="")
	 * @ApiSuccessParam(name="result[].name",description="")
	 * @ApiSuccessParam(name="result[].numbers",description="")
	 * @ApiSuccessParam(name="result[].price",description="")
	 * @ApiSuccessParam(name="result[].buytime",description="")
	 * @ApiSuccessParam(name="result[].customer_id",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new CustomerItemPriceModel();

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/CustomerItemPrice/delete")
	 * @ApiDescription("删除数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 */
	public function delete()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CustomerItemPriceModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

