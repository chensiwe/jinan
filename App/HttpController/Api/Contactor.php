<?php

namespace App\HttpController\Api;

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
 * Contactor
 * Class Contactor
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Contactor")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Contactor extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Api/Contactor/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="name",lengthMax="20",required="")
	 * @Param(name="items",lengthMax="150",required="")
	 * @Param(name="phone",lengthMax="12",required="")
	 * @Param(name="addtime",lengthMax="16",required="")
	 * @Param(name="supplyid",lengthMax="11",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'name'=>$param['name'],
		    'items'=>$param['items'],
		    'phone'=>$param['phone'],
		    'addtime'=>$param['addtime'],
		    'supplyid'=>$param['supplyid'],
		];
		$model = new ContactorModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Contactor/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="name",lengthMax="20",optional="")
	 * @Param(name="items",lengthMax="150",optional="")
	 * @Param(name="phone",lengthMax="12",optional="")
	 * @Param(name="addtime",lengthMax="16",optional="")
	 * @Param(name="supplyid",lengthMax="11",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new ContactorModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['name']=$param['name'] ?? $info->name;
		$updateData['items']=$param['items'] ?? $info->items;
		$updateData['phone']=$param['phone'] ?? $info->phone;
		$updateData['addtime']=$param['addtime'] ?? $info->addtime;
		$updateData['supplyid']=$param['supplyid'] ?? $info->supplyid;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Contactor/getOne")
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
	 * @ApiSuccessParam(name="result.items",description="")
	 * @ApiSuccessParam(name="result.phone",description="")
	 * @ApiSuccessParam(name="result.addtime",description="")
	 * @ApiSuccessParam(name="result.supplyid",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new ContactorModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	public function getOneBySupplyid()
	{
		$param =  $this->request()->getRequestParam();

		$model = new ContactorModel();
		$info = $model->all(['supplyid' => intval($param['suid'])]);
		
		for ($i=0; $i < count($info); $i++) { 

			$items = explode(",",$info[$i]['items']);
		 	$arr = null;



if (count($items) >=1 && !empty($items[0])) {

for ($j=0; $j < count($items); $j++) { 
		 		var_dump($items[$j]);		 		
		 		$arr[] = \App\Model\ProductModel::create()->where(['id'=>intval($items[$j])])->get();
				
}


		    
$info[$i]['itemsarr'] = $arr;
		  
}else{

	$info[$i]['itemsarr'] = [];
}

  

		}
	
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	
	public function getList()
	{
		$param = $this->request()->getRequestParam();
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['limit'] ?? 10);
		$model = new ContactorModel();

		if ($param['supplyid']) {
			$model = $model->where(['supplyid'=>$param['supplyid']]);
		}

		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Contactor/delete")
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
		$model = new ContactorModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

