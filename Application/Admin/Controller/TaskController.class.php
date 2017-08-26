<?php

namespace Admin\Controller;

/**
 * 后台任务配置控制器
 */
class TaskController extends AdminController {

    /**
     * 任务管理
     */
    public function index(){
        $name = I('name');
        $map['nickname'] =  array('like', '%'.(string)$name.'%');
        $map['pid'] = 0;
        $list   = $this->lists('Task', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '任务类型';
        $this->display();
    }

    public function taskType($id){
        $name = I('name');
        $map['nickname'] =  array('like', '%'.(string)$name.'%');
        $map['pid'] = $id;
        $list   = $this->lists('Task', $map);
        foreach($list as $key => $v){
            $list[$key]['pid'] = M('Task')->where(['id'=>$v['pid']])->getField('name');
        }
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '任务类型';
        $this->display();
    }


    /**
     * 编辑分类
     */
    public function edit($id = 0){
        $Dept = D('Task');

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
            $info = M('Task')->field(true)->find($id);

            //任务
            $menus = M('Task')->field(true)->select();
            $menus = D('Common/Tree')->toFormatTree($menus,'name');
            $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
            $this->assign('Menus', $menus);
            //部门
            $dept = M('Dept')->field(true)->select();
            $dept = D('Common/Tree')->toFormatTree($dept, 'name');
            $dept = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $dept);
            $this->assign('dept', $dept);

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
        $model = D('Task');
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

        //判断下面有没有子分类，有则不允许删除
        $child = M('Task')->where(array('pid'=>$id))->field('id')->select();
        if(!empty($child)){
            $this->error('请先删除该分类下的子分类');
        }

        //删除该信息
        $res = M('Task')->delete($id);
        if($res !== false){
            //记录行为
            action_log('update_dept', 'Task', $id, UID);
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }

    public function editConfig($id){
        $Dept = D('Task');

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
            $info = M('Task')->field(true)->find($id);

            //部门
            $dept = M('Dept')->field(true)->select();
            $dept = D('Common/Tree')->toFormatTree($dept, 'name');
            $dept = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $dept);
            $this->assign('dept', $dept);
            //科室
            $depart = M('Depart')->field(true)->where(['pid'=>0])->select();
            $depart = array_merge(array(0=>array('id'=>0,'name'=>'顶级菜单')), $depart);
            $this->assign('depart', $depart);

            if(false === $info){
                $this->error('获取任务配置有误');
            }
            $this->assign('info', $info);

            //科室具体信息
            $departInfo = M('DepartInfo')->field(true)->where(['pid'=>0])->select();
            $this->assign('depart_info', $departInfo);

            $select_depart = M('DepartInfo')->where(['id'=>['in',$info['position']]])->getField('name',true);
            $str_depart = implode(',',$select_depart);
            $this->assign('str_depart', $str_depart);

            $this->meta_title = '编辑任务配置';
            $this->display();
        }
    }

    public function iframe($id){
        //科室具体信息
        $departInfo = M('DepartInfo')->field(true)->where(['pid'=>0])->select();
        $this->assign('depart_info', $departInfo);
        $this->assign('arr_id', $id);
        $this->display();
    }
}
