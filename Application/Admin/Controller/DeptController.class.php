<?php

namespace Admin\Controller;

/**
 * 后台部门管理控制器
 */
class DeptController extends AdminController {

    /**
     * 部门管理列理
     */
    public function index(){
        $tree = D('Dept')->getTree(0,'id,name,sort,pid');
        $this->assign('tree', $tree);
        C('_SYS_GET_DEPT_TREE_', true); //标记系统获取分类树模板
        $this->meta_title = '部门管理';
        $this->display();
    }

    /**
     * 显示分类树，仅支持内部调
     * @param  array $tree 分类树
     */
    public function tree($tree = null){
        C('_SYS_GET_DEPT_TREE_') || $this->_empty();
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    /**
     * 编辑分类
     */
    public function edit($id = null, $pid = 0){
        $Dept = D('Dept');

        if(IS_POST){ //提交表单
            if(false !== $Dept->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Dept->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = '';
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Dept->info($pid, 'id,name');
                if(!($cate)){
                    $this->error('指定的上级分类不存在！');
                }
            }

            /* 获取分类信息 */
            $info = $id ? $Dept->info($id) : '';

            $this->assign('info',$info);
            $this->assign('dept',$cate);
            $this->meta_title = '编辑部门';
            $this->display();
        }
    }

    /**
     * 新增分类
     */
    public function add($pid = 0){
        $Category = D('Dept');

        if(IS_POST){ //提交表单
            if(false !== $Category->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = array();
            if($pid){
                /* 获取上级分类信息 */
                $cate = $Category->info($pid, 'id,name');
                if(!($cate)){
                    $this->error('指定的上级分类不存在！');
                }
            }

            /* 获取分类信息 */
            $this->assign('info',null);
            $this->assign('dept', $cate);
            $this->meta_title = '新增分类';
            $this->display('edit');
        }
    }

    /**
     * 删除一个分类
     */
    public function remove(){
        $cate_id = I('id');
        if(empty($cate_id)){
            $this->error('参数错误!');
        }

        //判断该部门下有没有子分类，有则不允许删除
        $child = M('Dept')->where(array('pid'=>$cate_id))->field('id')->select();
        if(!empty($child)){
            $this->error('请先删除该分类下的子分类');
        }

        //删除该部门信息
        $res = M('Dept')->delete($cate_id);
        if($res !== false){
            //记录行为
            action_log('update_dept', 'dept', $cate_id, UID);
            $this->success('删除分类成功！');
        }else{
            $this->error('删除分类失败！');
        }
    }
}
