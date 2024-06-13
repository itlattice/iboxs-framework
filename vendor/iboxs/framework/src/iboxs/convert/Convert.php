<?php
namespace iboxs\convert;

use iboxs\facade\View;

trait Convert{
    protected function fetch($template='',$vars=[],$code=200,$filter=null){
        return view($template,$vars,$code,$filter);
    }

    protected function assign($key,$value=null){
        return View::assign($key,$value);
    }

    public function json($code=0,$msg='操作成功',$data=[],$other=[],$state=200){
        $result=[
            'code'=>$code
        ];
        $result['msg']=$msg;
        $result['data']=$data;
        foreach($other as $k=>$v){
            $result[$k]=$v;
        }
        return json($result,$state);
    }

    public function success($result,$msg='操作成功'){
        return $this->json(0,$msg,$result);
    }

    public function error($msg,$code=-403.1,$other=[],$data=[]){
        return $this->json($code,$msg,$data,$other);
    }
    
    public function layJson($data,$map=null){
        $count=$data->count();
        $limit=request()->post('limit',25);
        $page=request()->post('page',1);
        $page=intval($page);
        $limit=intval($limit);
        $list=$data->page($page,$limit)->select();
        if($map!=null){
            $list=$list->map($map);
        }
        $maxPage=ceil($count/$limit);
        return $this->json(0,'获取成功',$list,['count'=>$count,'limit'=>$limit,'page'=>$page,'maxPage'=>$maxPage]);
    }

    protected function jsFetch($vars=[],$code=200,$filter=null){
        $controller=$this->request->controller(true);
        $action=$this->request->action(true);
        $tmp=app_path()."/view/{$controller}/{$action}.js";
        return $this->fetch($tmp,$vars,$code,$filter)->header([
            'Content-Type'=>'application/javascript; charset=utf-8'
        ]);
    }
}