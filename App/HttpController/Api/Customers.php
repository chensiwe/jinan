<?php

namespace App\HttpController\Api;

use App\Model\CustomersModel;
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
 * Customers
 * Class Customers
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Api.Customers")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class Customers extends AnnotationController
{
	
	public function add()
	{
		$param = $this->request()->getRequestParam();
		
		$data = [
		    'name'=>$param['name'],
		    'address'=>$param['address'],
		    'type'=>$param['type'],
		    'contact'=>$param['contact'],
		    'phone'=>$param['phone'],
		    'think'=>$param['think'],
		    'fromwhere'=>$param['fromwhere'],
		    'remark'=>$param['remark'],
		    'info'=>$param['info'],
		    'addtime'=>time(),
		];
		$model = new CustomersModel($data);


		$addid = $model->save();
		$items = $param['item'];
		$price = $param['price'];
		$times  = $param['times'];
		$numbers = $param['numbers'];

$priceitemmodel = new \App\Model\CustomerItemPriceModel();
		for ($i=0; $i < count($items); $i++) { 


			$item = \App\Model\ProductModel::create()->get($items[$i]);
			
$priceitemmodel->addData($item['id'], $item['name'],$numbers[$i], $price[$i], strtotime($times[$i]),$addid);
		

		}

		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Api/Customers/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="name",lengthMax="30",optional="")
	 * @Param(name="address",lengthMax="100",optional="")
	 * @Param(name="type",lengthMax="20",optional="")
	 * @Param(name="contact",lengthMax="10",optional="")
	 * @Param(name="phone",lengthMax="13",optional="")
	 * @Param(name="think",lengthMax="10",optional="",defaultValue="很高")
	 * @Param(name="fromwhere",lengthMax="25",optional="")
	 * @Param(name="remark",lengthMax="300",optional="")
	 * @Param(name="info",lengthMax="200",optional="")
	 * @Param(name="addtime",lengthMax="17",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CustomersModel();
		$info = $model->get(['id' => $param['id']]);
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
		$updateData['think']=$param['think'] ?? $info->think;
		$updateData['fromwhere']=$param['fromwhere'] ?? $info->fromwhere;
		$updateData['remark']=$param['remark'] ?? $info->remark;
		$updateData['info']=$param['info'] ?? $info->info;
		$updateData['addtime']=$param['addtime'] ?? $info->addtime;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Api/Customers/getOne")
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
	 * @ApiSuccessParam(name="result.think",description="")
	 * @ApiSuccessParam(name="result.fromwhere",description="")
	 * @ApiSuccessParam(name="result.remark",description="")
	 * @ApiSuccessParam(name="result.info",description="")
	 * @ApiSuccessParam(name="result.addtime",description="")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new CustomersModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	/**
	 * @Api(name="getList",path="/Api/Customers/getList")
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
	 * @ApiSuccessParam(name="result[].think",description="")
	 * @ApiSuccessParam(name="result[].fromwhere",description="")
	 * @ApiSuccessParam(name="result[].remark",description="")
	 * @ApiSuccessParam(name="result[].info",description="")
	 * @ApiSuccessParam(name="result[].addtime",description="")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new CustomersModel();
		$datas = $this->request()->getRequestParam();
		 if (isset($datas['type']) && $datas['type']  != '1'){
            $model->where(['type'=>$datas['type']]);
        }


 if (isset($datas['fromwhere']) && $datas['fromwhere']  != '1'){
            $model->where(['fromwhere'=>$datas['fromwhere']]);
        }

         if (isset($datas['think']) && $datas['think']  != '1'){
            $model->where(['think'=>$datas['think']]);
        }

        if (isset($datas['name'])){

             $model->where('name', "%{$datas['name']}%", 'like');
        }
		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Api/Customers/delete")
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
		$model = new CustomersModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		    return false;
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}
