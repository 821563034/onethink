<?php

namespace Admin\Model;
use Think\Model;

/**
 * 任务模型
 */
class TaskModel extends Model{

    /**
     * 更新分类信息
     * @return boolean 更新状态
     */
    public function update(){
        $data = $this->create();
        if(!$data){ //数据对象创建错误
            return false;
        }

        /* 添加或更新数据 */
        if(empty($data['id'])){
            $res = $this->add();
        }else{
            $res = $this->save();
        }

        //更新分类缓存
        S('sys_dept_list', null);

        //记录行为
        action_log('update_dept', 'dept', $data['id'] ? $data['id'] : $res, UID);

        return $res;
    }
}
