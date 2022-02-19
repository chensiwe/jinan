<?php

namespace App\HttpController\Api;

use App\Model\BankModel;
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


class Upload extends AnnotationController
{

	 function do()
    {
        $request = $this->request();
        $files = $request->getUploadedFiles();
        if(empty($files)){
            $this->writeJson(500,"no files found");
            return false;
        }
 	$file = $request->getUploadedFile('file');
var_dump($file);

$arr = [];
  $filename = $file->getClientFilename();
                $path = '/uploadfiles/'.md5(time()).substr(0,9).mt_rand(111,9999).".".explode('.',$filename)[1];
                $flag = $file->moveTo($path);
                $arr[explode('.',$filename)[0].time()] = $path; 
  //      foreach($files as $file){
    //            $filename = $file->getClientFilename();
      //          $path = '/uploadfiles/'.md5(time()).substr(0,9).".".explode('.',$filename)[1];
        //        $flag = $file->moveTo($path);
          //      $arr[explode('.',$filename)[0].time()] = $path;
       // }
        
            $this->writeJson(200,$arr);
        }

	
}

