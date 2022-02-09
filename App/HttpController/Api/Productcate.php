<?php

namespace App\HttpController\Api;

use App\Model\ProductcateModel;
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
 * Productcate
 * Class Productcate
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Productcate")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Productcate extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Productcate/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="name",lengthMax="15",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'name'=>$param['name'],
		    'createtime'=>time(),
		    'status'=>1,
		];


		if (ProductcateModel::create()->where(['name'=>$param['name']])->get()) {
			$this->writeJson(500, 200, "分类已存在");
			return false;
		}
		$model = new ProductcateModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	public function update()
	{
		$param = $this->request()->getRequestParam();
		$model = new ProductcateModel();
		$info = $model->get(['id' => $param['cateid']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		if (ProductcateModel::create()->where(['name'=>$param['editname']])->get()) {
			$this->writeJson(500, 200, "分类已存在");
			return false;
		}

		$updateData = [];

		$updateData['name']=$param['editname'] ?? $info->name;
		// $updateData['createtime']=$param['createtime'] ?? $info->createtime;
		// $updateData['status']=$param['status'] ?? $info->status;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Productcate/getOne")
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
	 * @ApiSuccessParam(name="result.createtime",description="")
	 * @ApiSuccessParam(name="result.status",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new ProductcateModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}







	public function getmany()
	{
		$param = $this->request()->getRequestParam();
		$model = new ProductcateModel();
		$info = $model->all(['id' => $param['pid']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Productcate/getList")
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
	 * @ApiSuccessParam(name="result[].createtime",description="")
	 * @ApiSuccessParam(name="result[].status",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new ProductcateModel();
		$datas = $this->request()->getRequestParam();
		if (isset($datas['keyword'])){
            $model->where('name', "%{$datas['keyword']}%", 'like');
        }
		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Productcate/delete")
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
		$model = new ProductcateModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

