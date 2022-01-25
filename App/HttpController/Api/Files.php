<?php

namespace App\HttpController\Api;

use App\Model\FilesModel;
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
 * Files
 * Class Files
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Files")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Files extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Files/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="type",lengthMax="1",required="")
	 * @Param(name="sp_id",lengthMax="11",required="")
	 * @Param(name="filepath",lengthMax="120",required="")
	 * @Param(name="filename",lengthMax="100",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'type'=>$param['type'],
		    'sp_id'=>$param['sp_id'],
		    'filepath'=>$param['filepath'],
		    'filename'=>$param['filename'],
		];
		$model = new FilesModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Files/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="type",lengthMax="1",optional="")
	 * @Param(name="sp_id",lengthMax="11",optional="")
	 * @Param(name="filepath",lengthMax="120",optional="")
	 * @Param(name="filename",lengthMax="100",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new FilesModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['type']=$param['type'] ?? $info->type;
		$updateData['sp_id']=$param['sp_id'] ?? $info->sp_id;
		$updateData['filepath']=$param['filepath'] ?? $info->filepath;
		$updateData['filename']=$param['filename'] ?? $info->filename;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Files/getOne")
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
	 * @ApiSuccessParam(name="result.type",description="")
	 * @ApiSuccessParam(name="result.sp_id",description="")
	 * @ApiSuccessParam(name="result.filepath",description="")
	 * @ApiSuccessParam(name="result.filename",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new FilesModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}

	public function getfiles(){

		$data = $this->request()->getRequestParam();
		$files = \App\Model\FilesModel::create()->all(['type'=>intval($data['type']),'sp_id'=>$data['spid']]);

		$this->writeJson(Status::CODE_OK, $files, "获取数据成功.");
	}

	/**
	 * @Api(name="getList",path="/Api/Files/getList")
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
	 * @ApiSuccessParam(name="result[].type",description="")
	 * @ApiSuccessParam(name="result[].sp_id",description="")
	 * @ApiSuccessParam(name="result[].filepath",description="")
	 * @ApiSuccessParam(name="result[].filename",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new FilesModel();

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Files/delete")
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
		$model = new FilesModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

