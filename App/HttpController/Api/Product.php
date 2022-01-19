<?php

namespace App\HttpController\Api;

use App\Model\ProductModel;
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
 * Product
 * Class Product
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Product")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Product extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Product/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="name",lengthMax="50",required="")
	 * @Param(name="cas",lengthMax="50",required="")
	 * @Param(name="chemical",lengthMax="150",required="")
	 * @Param(name="cate",required="")
	 * @Param(name="brand",lengthMax="15",required="")
	 * @Param(name="pack",lengthMax="20",required="")
	 * @Param(name="market",lengthMax="20",required="")
	 * @Param(name="properties",lengthMax="25",required="")
	 * @Param(name="content",lengthMax="20",required="")
	 * @Param(name="usefor",lengthMax="100",required="")
	 * @Param(name="remark",lengthMax="100",required="")
	 * @Param(name="sameitem",lengthMax="150",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'name'=>$param['name'],
		    'cas'=>$param['cas'],
		    'chemical'=>$param['chemical'],
		    'cate'=>$param['cate'],
		    'brand'=>$param['brand'],
		    'pack'=>$param['pack'],
		    'market'=>$param['market'],
		    'properties'=>$param['properties'],
		    'content'=>$param['content'],
		    'usefor'=>$param['usefor'],
		    'remark'=>$param['remark'],
		    'sameitem'=>$param['sameitem'],
		    'createtime'=>time(),
		];
		$model = new ProductModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Product/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",required="")
	 * @Param(name="name",lengthMax="50",optional="")
	 * @Param(name="cas",lengthMax="50",optional="")
	 * @Param(name="chemical",lengthMax="150",optional="")
	 * @Param(name="cate",optional="")
	 * @Param(name="brand",lengthMax="15",optional="")
	 * @Param(name="pack",lengthMax="20",optional="")
	 * @Param(name="market",lengthMax="20",optional="")
	 * @Param(name="properties",lengthMax="25",optional="")
	 * @Param(name="content",lengthMax="20",optional="")
	 * @Param(name="usefor",lengthMax="100",optional="")
	 * @Param(name="remark",lengthMax="100",optional="")
	 * @Param(name="sameitem",lengthMax="150",optional="")
	 * @Param(name="createtime",lengthMax="15",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new ProductModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['name']=$param['name'] ?? $info->name;
		$updateData['cas']=$param['cas'] ?? $info->cas;
		$updateData['chemical']=$param['chemical'] ?? $info->chemical;
		$updateData['cate']=$param['cate'] ?? $info->cate;
		$updateData['brand']=$param['brand'] ?? $info->brand;
		$updateData['pack']=$param['pack'] ?? $info->pack;
		$updateData['market']=$param['market'] ?? $info->market;
		$updateData['properties']=$param['properties'] ?? $info->properties;
		$updateData['content']=$param['content'] ?? $info->content;
		$updateData['usefor']=$param['usefor'] ?? $info->usefor;
		$updateData['remark']=$param['remark'] ?? $info->remark;
		$updateData['sameitem']=$param['sameitem'] ?? $info->sameitem;
		$updateData['createtime']=$param['createtime'] ?? $info->createtime;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Product/getOne")
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
	 * @ApiSuccessParam(name="result.name",description="")
	 * @ApiSuccessParam(name="result.cas",description="")
	 * @ApiSuccessParam(name="result.chemical",description="")
	 * @ApiSuccessParam(name="result.cate",description="")
	 * @ApiSuccessParam(name="result.brand",description="")
	 * @ApiSuccessParam(name="result.pack",description="")
	 * @ApiSuccessParam(name="result.market",description="")
	 * @ApiSuccessParam(name="result.properties",description="")
	 * @ApiSuccessParam(name="result.content",description="")
	 * @ApiSuccessParam(name="result.usefor",description="")
	 * @ApiSuccessParam(name="result.remark",description="")
	 * @ApiSuccessParam(name="result.sameitem",description="")
	 * @ApiSuccessParam(name="result.createtime",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new ProductModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Product/getList")
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
	 * @ApiSuccessParam(name="result[].name",description="")
	 * @ApiSuccessParam(name="result[].cas",description="")
	 * @ApiSuccessParam(name="result[].chemical",description="")
	 * @ApiSuccessParam(name="result[].cate",description="")
	 * @ApiSuccessParam(name="result[].brand",description="")
	 * @ApiSuccessParam(name="result[].pack",description="")
	 * @ApiSuccessParam(name="result[].market",description="")
	 * @ApiSuccessParam(name="result[].properties",description="")
	 * @ApiSuccessParam(name="result[].content",description="")
	 * @ApiSuccessParam(name="result[].usefor",description="")
	 * @ApiSuccessParam(name="result[].remark",description="")
	 * @ApiSuccessParam(name="result[].sameitem",description="")
	 * @ApiSuccessParam(name="result[].createtime",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new ProductModel();
		$datas = $this->request()->getRequestParam();
		 if (isset($datas['keyword'])){
            $model->where('name', "%{$datas['keyword']}%", 'like');
        }

        if (isset($datas['cate'])){
            $model->where(['cate'=>$datas['cate']]);
        }

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Product/delete")
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
		$model = new ProductModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

