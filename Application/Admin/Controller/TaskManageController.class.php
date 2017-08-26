<?php

namespace Admin\Controller;

/**
 * 后台任务管理控制器
 */
class TaskManageController extends AdminController {

    public $type = ['加急检查','送住院','送血'];

    /**
     * 任务管理
     */
    public function index(){
        $name = I('no');
        $map['no'] =  array('like', '%'.(string)$name.'%');
        $list   = $this->lists('TaskManage', $map);
        int_to_string($list);

        foreach($list as $key => $v){
            $list[$key]['depart'] = M('Depart')->where(['id'=>$v['depart']])->getField('name');
            $list[$key]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $list[$key]['type'] = $menus = M('Task')->where(['id'=>$v['type']])->getField('name');

            $start_depart = M('DepartInfo')->where(['id'=>['in',$v['start_position']]])->getField('name',true);
            $start_depart = implode(',',$start_depart);
            $list[$key]['start_position'] = $start_depart;
            $end_depart = M('DepartInfo')->where(['id'=>['in',$v['end_position']]])->getField('name',true);
            $end_depart = implode(',',$end_depart);
            $list[$key]['end_position'] = $end_depart;

            $list[$key]['scheduled'] = date('Y-m-d H:i:s',$v['scheduled']);
            $list[$key]['uid'] = M('UcenterMember')->where(['id'=>$v['uid']])->getField('username');
        }
        $this->assign('_list', $list);

        $this->meta_title = '任务列表';
        $this->display();
    }

    /**
     * 编辑分类
     */
    public function edit($id = 0){
        $Dept = D('TaskManage');

        if(IS_POST){ //提交表单
            if(false !== $Dept->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Dept->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('TaskManage')->field(true)->find($id);

            /* 获取数据 */
            $menus = M('Task')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus,'name');
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);

            $dept = M('Dept')->field(true)->select();
            $dept = D('Common/Tree')->toFormatTree($dept, 'name');
            $dept = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $dept);
            $this->assign('dept', $dept);

            //科室具体信息
            $departInfo = M('DepartInfo')->field(true)->where(['pid'=>0])->select();
            $this->assign('depart_info', $departInfo);

            $start_depart = M('DepartInfo')->where(['id'=>['in',$info['start_position']]])->getField('name',true);
            $start_depart = implode(',',$start_depart);
            $this->assign('start_depart', $start_depart);

            $end_depart = M('DepartInfo')->where(['id'=>['in',$info['end_position']]])->getField('name',true);
            $end_depart = implode(',',$end_depart);
            $this->assign('end_depart', $end_depart);

            if(false === $info){
                $this->error('获取任务类型有误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑任务类型';
            $this->display();
        }
    }

    /**
     * 新增分类
     */
    public function add(){
        $model = D('TaskManage');
        if(IS_POST){ //提交表单
            $data = $model->create();
            if($data){
                if(false !== $model->add()){
                    $this->success('新增成功！', U('index'));
                } else {
                    $error = $model->getError();
                    $this->error(empty($error) ? '未知错误！' : $error);
                }
            }
        } else {
            /* 获取数据 */
            $menus = M('Task')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus,'name');
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);

            $dept = M('Dept')->field(true)->select();
            $dept = D('Common/Tree')->toFormatTree($dept, 'name');
            $dept = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $dept);
            $this->assign('dept', $dept);

            //科室具体信息
            $departInfo = M('DepartInfo')->field(true)->where(['pid'=>0])->select();
            $this->assign('depart_info', $departInfo);

            $this->meta_title = '新增任务类型';
            $this->display('edit');
        }
    }

    /**
     * 删除
     */
    public function remove(){
        $id = I('id');
        if(empty($id)){
            $this->error('参数错误!');
        }

        //删除该信息
        $res = M('TaskManage')->delete($id);
        if($res !== false){
            //记录行为
            action_log('update_task_manage', 'task_manage', $id, UID);
            $this->success('删除任务成功！');
        }else{
            $this->error('删除任务失败！');
        }
    }

    public function ajax(){
        $id = I('id');
        $deptId = $this->dept($id);
        $uidArr = M('UcenterInfo')->where(['dept'=>['in',$deptId]])->getField('uid',true);
        $user = M('Ucenter_member')->where(['id'=>['in',$uidArr]])->select();
        $this->ajaxReturn($user);
    }

    public function dept($id,$merge = true){
        $id = explode(",",$id);
        $find = M('Dept')->where(['pid'=>['in',$id]])->getField('id',true);
        foreach($find as $v){
            $tmp = $this->dept($v,false);
            if($tmp){
                $find = array_merge($find,$tmp);
            }
        }
        if($merge) {
            if($find){
                $find = array_merge($id,$find);
            }
        }
        return $find;
    }

    public function iframe($id='',$n=''){
        //科室具体信息
        $departInfo = M('DepartInfo')->field(true)->where(['pid'=>0])->select();
        $this->assign('depart_info', $departInfo);
        $this->assign('arr_id', $id);
        $this->assign('n', $n);
        $this->display();
    }
}
