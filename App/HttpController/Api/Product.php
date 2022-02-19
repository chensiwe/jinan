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
	
	public function add()
	{
		$datas = $this->request()->getRequestParam();


		$param = $datas['data'];

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
		    'ordernum'=>0,
		    'aliasname'=>$param['aliasname'],
		    'sameitem'=>$param['sameitem'],
		    'createtime'=>time()
		];
		$model = new ProductModel($data);
		$proid = $model->save();




		$subs = $datas['subox'];
		if (count($subs) > 0) {
		
			foreach ($subs as $key => $value) {
				if ($value['time']) {
					
				
    	$contact = \App\Model\ContactorModel::create()->get(intval($value['contactname']));

    	
    	if ($contact['items'] == "") {
			$items = [];
		}else{
			$items = explode(",", $contact['items']);
		}

   
    	$items[] = $param['name'];
    	var_dump($items);

    	//update product info to contactor
    	\App\Model\ContactorModel::create()->update(['items'=>implode(",",array_unique($items))],['id'=>$contact['id']]);




    	var_dump($contact);
			$data = [
		    'supplyid'=>$value['supplyname'],
		    'supplyname'=>(\App\Model\SupplyModel::create()->get(intval($value['supplyname'])))['name'],
		    'contactorname'=>$contact['name'],
		    'contactphone'=>$contact['phone'],
		    'supplytype'=>$value['supplytype'],
		    'createtime'=>strtotime($value['time']),
		    'price'=>$value['price'],
		    'address'=>$value['address'],
		    'priceinfo'=>$value['priceinfo'],
		    'buynumber'=>$value['numbers'],
		    'pid'=>$proid,
		];
		$modelss = new \App\Model\SupplyProductRelateModel($data);
		$modelss->save();
}


			}
		}





		\App\Libs\Util::savefiles($datas['files'],intval($proid),2);



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


	
	public function getOne()
	{
		$param = $this->request()->getRequestParam();
		$model = new ProductModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}


	public function getList()
	{
		$param =  $this->request()->getRequestParam();
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['limit'] ?? 10);
		$model = new ProductModel();
		$datas = $this->request()->getRequestParam();
		 if (isset($datas['name']) && $datas['name'] != ""){
            $model->where('name', "%{$datas['name']}%", 'like')->where('cas', "%{$datas['name']}%", 'like', 'OR')->where('chemical', "%{$datas['name']}%", 'like', 'OR')->where('brand', "%{$datas['name']}%", 'like', 'OR')->where('pack', "%{$datas['name']}%", 'like', 'OR')->where('market', "%{$datas['name']}%", 'like', 'OR')->where('properties', "%{$datas['name']}%", 'like', 'OR')->where('usefor', "%{$datas['name']}%", 'like', 'OR')->where('sameitem', "%{$datas['name']}%", 'like', 'OR')->where('content', "%{$datas['name']}%", 'like', 'OR')->where('aliasname', "%{$datas['name']}%", 'like', 'OR')->where('remark', "%{$datas['name']}%", 'like', 'OR');
		 }

        if (isset($datas['cate']) && $datas['cate'] != '1'){
            $model->where(['cate'=>$datas['cate']]);
        }


		$data = $model->getList($page, $pageSize);

		for ($i=0; $i < count($data['list']); $i++) { 
			$data['list'][$i]['cate'] =(\App\Model\ProductcateModel::create()->get($data['list'][$i]['cate']))['name'];
		}
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



public function edit()
	{
		$datas = $this->request()->getRequestParam();

		var_dump($datas);
		$param = $datas['data'];

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
		    'aliasname'=>$param['aliasname'],
		    'sameitem'=>$param['sameitem'],
		    'createtime'=>time(),
		];
		$model = new ProductModel();
		$proid = ProductModel::create()->update($data,['id'=>intval($datas['id'])]);


		$subs = $datas['subox'];
		if (count($subs) > 0) {
			\App\Model\SupplyProductRelateModel::create()->where(['pid'=>intval($datas['id']),])->destroy();

			foreach ($subs as $key => $value) {
				if ($value['time']) {
							
    	$contact = \App\Model\ContactorModel::create()->get(intval($value['contactname']));

		if ($contact['items'] == "") {
			$items = [];
		}else{
			$items = explode(",", $contact['items']);
		}

   
    	$items[] = $param['name'];
    	var_dump($items);

    	//update product info to contactor
    	\App\Model\ContactorModel::create()->update(['items'=>implode(",",array_unique($items))],['id'=>$contact['id']]);

			$data = [
		    'supplyid'=>$value['supplyname'],
		    'supplyname'=>(\App\Model\SupplyModel::create()->get(intval($value['supplyname'])))['name'],
		    'contactorname'=>$contact['name'],
		    'contactphone'=>$contact['phone'],
		    'supplytype'=>$value['supplytype'],
		    'createtime'=>strtotime($value['time']),
		    'price'=>$value['price'],
		    'address'=>$value['address'],
		    'priceinfo'=>$value['priceinfo'],
		    'buynumber'=>$value['numbers'],
		    'pid'=>intval($datas['id']),
		];
		$modelss = new \App\Model\SupplyProductRelateModel($data);


// 				if (array_key_exists("id", $value)) {

// \App\Model\SupplyProductRelateModel::create()->update($data,['id'=>intval($value['id'])]);

						
// 		}else{
					



		$modelss->save();

	}


			}
		}


		\App\Libs\Util::savefiles($datas['files'],intval($datas['id']),2);

		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}










public function exportCsv(){


		$model = new ProductModel();

		$datas = $this->request()->getRequestParam();
		 if (isset($datas['cate']) && $datas['cate']  != '1'){
            $model->where(['cate'=>$datas['cate']]);
        }

       if (isset($datas['name'])){

             $model->where('name', "%{$datas['name']}%", 'like');
        }


		$all = $model->all();

    foreach($all as $k=>$v){
        $arrData[] = [
           
            'name' => $v['name'],
            "cas"=>$v['cas'],
            'chemical'=>$v['chemical'],
            'brand'=>$v['brand'],
            'pack'=>$v['pack'],
            'market'=>$v['market']

        ];
    }
    // $title = [['名称', '地址','类型','联系人','电话','信息'],];
    $arrData = array_merge($arrData);
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    // 设置单元格格式 可以省略

    $spreadsheet->getActiveSheet()->fromArray($arrData);
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
    $writer->setPreCalculateFormulas(false);
    //这里可以写绝对路径，其他框架到这步就结束了
    $writer->save('/easyswoole/test.xlsx');
    //关闭连接，销毁变量
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
    //生成文件后，使用response输出
    $this->response()->write(file_get_contents('/easyswoole/test.xlsx'));
    $this->response()->withHeader('Content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $this->response()->withHeader('Content-Disposition', 'attachment;filename="test.csv"');
    $this->response()->withHeader('Cache-Control','max-age=0');
    $this->response()->end();
    return false;
	}






}

