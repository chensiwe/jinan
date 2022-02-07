<?php

namespace App\HttpController\Api;

use App\Model\CallbookModel;
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
 * Callbook
 * Class Callbook
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Callbook")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Callbook extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Callbook/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 */
	public function add()
	{
		$datas = $this->request()->getRequestParam();
		$param = $datas['data'];
		$data = [
		    'name'=>$param['name'],
		    'address'=>$param['address'],
		    'type'=>$param['type'],
		    'contact'=>$param['contact'],
		    'phone'=>$param['phone'],
		    'ramark'=>$param['ramark'],
		    'info'=>$param['info'],
		    'addtime'=>time(),
		];
		$model = new CallbookModel($data);
		$id = $model->save();

		\App\Libs\Util::savefiles($datas['files'],intval($id),3);


		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	public function update()
	{
		$param = $this->request()->getRequestParam();
		$files = $param['files'];
		$param = $param['data'];
		$model = new CallbookModel();
		$info = $model->get(['id' => intval($param['id'])]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['name']=$param['name'] ?? $info->name;
		$updateData['address']=$param['address'] ?? $info->address;
		$updateData['type']=$param['type'] ?? $info->type;
		$updateData['contact']=$param['contact'] ?? $info->contact;
		$updateData['phone']=$param['phone'] ?? $info->phone;
		$updateData['ramark']=$param['ramark'] ?? $info->ramark;
		$updateData['info']=$param['info'] ?? $info->info;
		$updateData['addtime']=$param['addtime'] ?? $info->addtime;
		$info->update($updateData);

		var_dump($files);
		\App\Libs\Util::savefiles($files,intval($param['id']),3);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Callbook/getOne")
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
	 * @ApiSuccessParam(name="result.name",description="")
	 * @ApiSuccessParam(name="result.address",description="")
	 * @ApiSuccessParam(name="result.type",description="")
	 * @ApiSuccessParam(name="result.contact",description="")
	 * @ApiSuccessParam(name="result.phone",description="")
	 * @ApiSuccessParam(name="result.ramark",description="")
	 * @ApiSuccessParam(name="result.info",description="")
	 * @ApiSuccessParam(name="result.addtime",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CallbookModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Callbook/getList")
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
	 * @ApiSuccessParam(name="result[].address",description="")
	 * @ApiSuccessParam(name="result[].type",description="")
	 * @ApiSuccessParam(name="result[].contact",description="")
	 * @ApiSuccessParam(name="result[].phone",description="")
	 * @ApiSuccessParam(name="result[].ramark",description="")
	 * @ApiSuccessParam(name="result[].info",description="")
	 * @ApiSuccessParam(name="result[].addtime",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 10);
		$model = new CallbookModel();
		$datas = $this->request()->getRequestParam();
		 if (isset($datas['type']) && $datas['type']  != '1'){
            $model->where(['type'=>$datas['type']]);
        }

        if (isset($datas['name'])){

             $model->where('name', "%{$datas['name']}%", 'like')->where('address', "%{$datas['name']}%", 'like', 'OR')->where('contact', "%{$datas['name']}%", 'like', 'OR')->where('phone', "%{$datas['name']}%", 'like', 'OR')->where('ramark', "%{$datas['name']}%", 'like', 'OR')->where('info', "%{$datas['name']}%", 'like', 'OR');
        }

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Callbook/delete")
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
		$model = new CallbookModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

