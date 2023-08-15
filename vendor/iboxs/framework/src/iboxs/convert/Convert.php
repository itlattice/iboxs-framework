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
        return $this->json(0,'获取成功',$list,['count'=>$count]);
    }
}