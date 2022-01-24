<?php

namespace App\HttpController\Api;

use App\Model\SupplyProductRelateModel;
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
 * SupplyProductRelate
 * Class SupplyProductRelate
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.SupplyProductRelate")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class SupplyProductRelate extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/SupplyProductRelate/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="supplyid",lengthMax="11",required="")
	 * @Param(name="createtime",lengthMax="15",required="")
	 * @Param(name="address",lengthMax="150",required="")
	 * @Param(name="priceinfo",lengthMax="50",required="")
	 * @Param(name="buynumber",lengthMax="10",required="",defaultValue="0")
	 * @Param(name="pid",lengthMax="11",required="")
	 */
	public function add()
	{
		$param = $this->request()->getRequestParam();
		// $param = ContextManager::getInstance()->get('param');
		$supplyid  = $param['supplyid'];
		$supply = \App\Model\SupplyModel::create()->get(['id'=>intval($supplyid)]);

		$contact =\App\Model\ContactorModel::create()->get($param['contact']);
		$data = [
		    'supplyid'=>$param['supplyid'],
		    'supplyname'=>$supply['name'],
		    'contactorname'=>$contact['name'],
		    'contactphone'=>$contact['phone'],
		    'supplytype'=>$supply['type'],
		    'createtime'=>strtotime($param['createtime']),
		    'price'=>$param['price'],
		    'address'=>$param['address'],
		    'priceinfo'=>$param['priceinfo'],
		    'buynumber'=>$param['buynumber'],
		    'pid'=>$param['pid'],
		];
		$model = new SupplyProductRelateModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/SupplyProductRelate/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="supplyid",lengthMax="11",optional="")
	 * @Param(name="supplyname",lengthMax="100",optional="")
	 * @Param(name="contactorname",lengthMax="30",optional="")
	 * @Param(name="contactphone",lengthMax="15",optional="")
	 * @Param(name="supplytype",lengthMax="20",optional="")
	 * @Param(name="createtime",lengthMax="15",optional="")
	 * @Param(name="price",lengthMax="Array",optional="")
	 * @Param(name="address",lengthMax="150",optional="")
	 * @Param(name="priceinfo",lengthMax="50",optional="")
	 * @Param(name="buynumber",lengthMax="10",optional="",defaultValue="0")
	 * @Param(name="pid",lengthMax="11",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new SupplyProductRelateModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['supplyid']=$param['supplyid'] ?? $info->supplyid;
		$updateData['supplyname']=$param['supplyname'] ?? $info->supplyname;
		$updateData['contactorname']=$param['contactorname'] ?? $info->contactorname;
		$updateData['contactphone']=$param['contactphone'] ?? $info->contactphone;
		$updateData['supplytype']=$param['supplytype'] ?? $info->supplytype;
		$updateData['createtime']=$param['createtime'] ?? $info->createtime;
		$updateData['price']=$param['price'] ?? $info->price;
		$updateData['address']=$param['address'] ?? $info->address;
		$updateData['priceinfo']=$param['priceinfo'] ?? $info->priceinfo;
		$updateData['buynumber']=$param['buynumber'] ?? $info->buynumber;
		$updateData['pid']=$param['pid'] ?? $info->pid;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/SupplyProductRelate/getOne")
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
	 * @ApiSuccessParam(name="result.supplyid",description="")
	 * @ApiSuccessParam(name="result.supplyname",description="")
	 * @ApiSuccessParam(name="result.contactorname",description="")
	 * @ApiSuccessParam(name="result.contactphone",description="")
	 * @ApiSuccessParam(name="result.supplytype",description="")
	 * @ApiSuccessParam(name="result.createtime",description="")
	 * @ApiSuccessParam(name="result.price",description="")
	 * @ApiSuccessParam(name="result.address",description="")
	 * @ApiSuccessParam(name="result.priceinfo",description="")
	 * @ApiSuccessParam(name="result.buynumber",description="")
	 * @ApiSuccessParam(name="result.pid",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new SupplyProductRelateModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}

	

public function getmany()
	{
		$param = $this->request()->getRequestParam();
		$model = new SupplyProductRelateModel();
		$info = $model->all(['pid' => intval($param['pid'])]);
		for ($i=0; $i < count($info); $i++) { 
				$info[$i]['createtime']= strtotime("Y-m-d",$info[$i]['createtime']);
		}
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/SupplyProductRelate/getList")
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
	 * @ApiSuccessParam(name="result[].supplyid",description="")
	 * @ApiSuccessParam(name="result[].supplyname",description="")
	 * @ApiSuccessParam(name="result[].contactorname",description="")
	 * @ApiSuccessParam(name="result[].contactphone",description="")
	 * @ApiSuccessParam(name="result[].supplytype",description="")
	 * @ApiSuccessParam(name="result[].createtime",description="")
	 * @ApiSuccessParam(name="result[].price",description="")
	 * @ApiSuccessParam(name="result[].address",description="")
	 * @ApiSuccessParam(name="result[].priceinfo",description="")
	 * @ApiSuccessParam(name="result[].buynumber",description="")
	 * @ApiSuccessParam(name="result[].pid",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new SupplyProductRelateModel();

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/SupplyProductRelate/delete")
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
		$model = new SupplyProductRelateModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

