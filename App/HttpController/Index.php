<?php
/**
 * Created by PhpStorm.
 * Users: Siam
 * Date: 2019/7/2
 * Time: 17:28
 */

namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{

    function index()
    {
        $this->response()->redirect("./index.html");
    }
}
