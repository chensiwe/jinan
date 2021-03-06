<?php

namespace App\HttpController\Api;

use App\Model\SupplyModel;
use App\Model\ContactorModel;
use App\Model\ItemContactorModel;
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
	


public function add()
	{
		$datas = $this->request()->getRequestParam();
		$param = $datas['data'];
		$data = [
		    'name'=>$param['name'],
		    'address'=>$param['address'],
		    'remark'=>$param['remark'],
		    'info'=>$param['info'],
		    'type'=>$param['type'],
		    'createtime'=>time(),
		    'status'=>1,
		    'donemunber'=>$param['donemunber'],
		];
		$exist = SupplyModel::create()->get(['name'=>$param['name']]);
			if ($exist) {
				$this->writeJson(200, '已存在', "error");
				return false;
			}

		try{
			//open tracition...
			\EasySwoole\ORM\DbManager::getInstance()->startTransaction();


    		$model = new SupplyModel($data);
		    $supplyid = $model->save();
	  	   $conmodel = new ContactorModel();
var_dump($datas);
		$lxrs = $datas['lxrarr'];



		if (count($lxrs)>0) {
			$conmodel = new ContactorModel();

				foreach ($lxrs as $key => $value) {

					if (array_key_exists("phone", $value) && $value['phone'] != "") {
							var_dump($value);
							if ($value['items']) {
								$items  = implode(",",$value['items']);
							}else{
								$items = "";
							}

						
					$contacrid = $conmodel->addData($value['name'],$items,$value['phone'],time(),$supplyid);
					
				}
			}

		}


		
		\App\Libs\Util::savefiles($datas['files'],$supplyid,1);
 \EasySwoole\ORM\DbManager::getInstance()->commit();
 $this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
		


		}catch(\Throwable  $e){
        // 回滚事务
        \EasySwoole\ORM\DbManager::getInstance()->rollback();
        var_dump($e->getMessage());
        $this->writeJson(200,['code'=>500,'msg'=>'数据库异常']);
    }

		
		


	}














	public function edit()
	{
		$datas = $this->request()->getRequestParam();

		$param = $datas['data'];

		if ($param['supplyid'] <1) {
			$this->writeJson(Status::CODE_OK,'exist', "error");
		}

		$data = [
		    'name'=>$param['name'],
		    'contactor'=>$param['contactor'],
		    'phone'=>$param['phone'],
		    'address'=>$param['address'],
		    'remark'=>$param['remark'],
		    'info'=>$param['info'],
		    'type'=>$param['type'],
		    'createtime'=>time(),
		    'status'=>1,
		    'donemunber'=>$param['donemunber'],
		];



		$exist = SupplyModel::create()->get(['name'=>$param['name'],'id'=>[$param['supplyid'],'!=']]);
		if ($exist) {
			$this->writeJson(200, '已存在', "error");
			return false;
		}

		$model = new SupplyModel($data);
	    $model->update($data,['id'=>intval($param['supplyid'])]);

		$conmodel = new ContactorModel();

		$lxrs = $datas['lxrarr'];

var_dump($lxrs);
		if (count($lxrs)>0) {
			ContactorModel::Create()->where(['supplyid'=>$param['supplyid']])->destroy();
			$conmodel = new ContactorModel();
var_dump($param['supplyid']);
				foreach ($lxrs as $key => $value) {

					if (array_key_exists("phone", $value) && $value['phone'] != "") {
							var_dump($value);
							if ($value['items']) {
								$items  = implode(",",$value['items']);
							}else{
								$items = "";
							}
					
					$conmodel->addData($value['name'],$items,$value['phone'],time(),intval($param['supplyid']));
				}
					
				}
			}

		


		\App\Libs\Util::savefiles($datas['file'],intval($param['supplyid']),1);

		$this->writeJson(Status::CODE_OK, $model->toArray(), "update成功");
	}





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
		$updateData['type']=$param['type'] ?? $info->type;
		$updateData['createtime']=$param['createtime'] ?? $info->createtime;
		$updateData['status']=$param['status'] ?? $info->status;
		$updateData['donemunber']=$param['donemunber'] ?? $info->donemunber;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	
	public function getOne()
	{
		$param =  $this->request()->getRequestParam();
		$model = new SupplyModel();
		$info = $model->get(['id' => $param['id']]);
		$this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
	}





	public function getList()
	{
		$param =  $this->request()->getRequestParam();
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['limit'] ?? 10);

		$model = new SupplyModel();

		$datas = $this->request()->getRequestParam();
		if (isset($datas['type']) && $datas['type']  != '1'){
            $model->where(['type'=>$datas['type']]);
        

        }

        if (isset($datas['name']) && $datas['name'] != ""){

             $model->where('name', "%{$datas['name']}%", 'like')->where('contactor', "%{$datas['name']}%", 'like', 'OR')->where('phone', "%{$datas['name']}%", 'like', 'OR')->where('address', "%{$datas['name']}%", 'like', 'OR')->where('remark', "%{$datas['name']}%", 'like', 'OR')->where('info', "%{$datas['name']}%", 'like', 'OR');
        
        }


		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}





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







	public function exportCsv(){


		$model = new SupplyModel();

		$datas = $this->request()->getRequestParam();
		 if (isset($datas['type']) && $datas['type']  != '1'){
            $model->where(['type'=>$datas['type']]);
        }

       if (isset($datas['name'])){

             $model->where('name', "%{$datas['name']}%", 'like');
        }


		$all = $model->all();

    foreach($all as $k=>$v){
        $arrData[] = [
           
            'name' => $v['customer'],
            "address"=>$v['address'],
            'type'=>$v['type'],
            'contactor'=>$v['contactor'],
            'phone'=>$v['phone'],
            'info'=>$v['info']

        ];
    }
    $title = [['名称', '地址','类型','联系人','电话','信息'],];
    $arrData = array_merge($title, $arrData);
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

