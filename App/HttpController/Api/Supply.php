<?php

namespace App\HttpController\Api;

use App\Model\SupplyModel;
use App\Model\ContactorModel;
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
 * Supply
 * Class Supply
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Supply")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Supply extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Supply/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="name",lengthMax="100",required="")
	 * @Param(name="contactor",lengthMax="10",required="")
	 * @Param(name="phone",lengthMax="11",required="")
	 * @Param(name="address",lengthMax="150",required="")
	 * @Param(name="remark",lengthMax="200",required="")
	 * @Param(name="info",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'name'=>$param['name'],
		    'contactor'=>$param['contactor'],
		    'phone'=>$param['phone'],
		    'address'=>$param['address'],
		    'remark'=>$param['remark'],
		    'info'=>$param['info'],
		    'createtime'=>time(),
		    'status'=>1,
		];
		$model = new SupplyModel($data);
		$sid = $model->save();

		$con_phones = $param['conphone'];
		$con_names = $param['conname'];

		$datas = $this->request()->getRequestParam();
		$con_names = $datas['conname'];
		$con_phones = $datas['conphone'];
		$size = count($con_phones);
		if ($sid) {
			$conmodel = new ContactorModel();
				for ($i=0; $i < $size; $i++) { 
					
					$conmodel->addData($con_names[$i],$con_phones[$i],time());
				}

		}


		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Supply/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",required="")
	 * @Param(name="name",lengthMax="100",optional="")
	 * @Param(name="contactor",lengthMax="10",optional="")
	 * @Param(name="phone",lengthMax="11",optional="")
	 * @Param(name="address",lengthMax="150",optional="")
	 * @Param(name="remark",lengthMax="200",optional="")
	 * @Param(name="info",optional="")
	 * @Param(name="createtime",lengthMax="15",optional="")
	 * @Param(name="status",lengthMax="1",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new SupplyModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['name']=$param['name'] ?? $info->name;
		$updateData['contactor']=$param['contactor'] ?? $info->contactor;
		$updateData['phone']=$param['phone'] ?? $info->phone;
		$updateData['address']=$param['address'] ?? $info->address;
		$updateData['remark']=$param['remark'] ?? $info->remark;
		$updateData['info']=$param['info'] ?? $info->info;
		$updateData['createtime']=$param['createtime'] ?? $info->createtime;
		$updateData['status']=$param['status'] ?? $info->status;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Supply/getOne")
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
	 * @ApiSuccessParam(name="result.contactor",description="")
	 * @ApiSuccessParam(name="result.phone",description="")
	 * @ApiSuccessParam(name="result.address",description="")
	 * @ApiSuccessParam(name="result.remark",description="")
	 * @ApiSuccessParam(name="result.info",description="")
	 * @ApiSuccessParam(name="result.createtime",description="")
	 * @ApiSuccessParam(name="result.status",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new SupplyModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Supply/getList")
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
	 * @ApiSuccessParam(name="result[].contactor",description="")
	 * @ApiSuccessParam(name="result[].phone",description="")
	 * @ApiSuccessParam(name="result[].address",description="")
	 * @ApiSuccessParam(name="result[].remark",description="")
	 * @ApiSuccessParam(name="result[].info",description="")
	 * @ApiSuccessParam(name="result[].createtime",description="")
	 * @ApiSuccessParam(name="result[].status",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new SupplyModel();

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Supply/delete")
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
		$model = new SupplyModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}
