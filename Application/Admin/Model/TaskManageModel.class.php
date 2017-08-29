<?php

namespace Admin\Model;
use Think\Model;

/**
 * 任务模型
 */
class TaskManageModel extends Model{

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('scheduled', NOW_TIME, self::MODEL_BOTH),
        array('depart', 'get_dept', self::MODEL_INSERT,'callback'),
        array('no', 'get_no', self::MODEL_INSERT,'callback'),
    );

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

    public function get_no(){
        $no = $this->max('no');
        return 'T'.sprintf("%06d", intval(substr($no,1,6))+1);
    }

    public function get_dept(){
        $auth = session('user_auth');
        $menber = M('UcenterInfo')->where(['uid'=>$auth['uid']])->find();
        return $menber['dept'];
    }
}
