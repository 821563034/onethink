<?php if (!defined('THINK_PATH')) exit();?><div class="code_box code_skin0">
    <div class="form-item">
        <div class="controls">
            <?php if(is_array($depart_info)): $i = 0; $__LIST__ = $depart_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><label class="radio">
                    <input type="checkbox" name="positions" value="<?php echo ($v["id"]); ?>" <?php if(in_array(($v["id"]), is_array($arr_id)?$arr_id:explode(',',$arr_id))): ?>checked<?php endif; ?> ><span><?php echo ($v["name"]); ?></span>
                </label><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>

<div class="layui-layer-btn layui-layer-btn-">
    <input type="hidden" id="n" value="<?php echo ($n); ?>">
    <a class="layui-layer-btn0" id="transmit">确 定</a>
    <a class="layui-layer-btn1" id="closeIframe">返 回</a>
</div>
<!--[if lt IE 9]>
<script type="text/javascript" src="/onethink/Public/static/jquery-1.10.2.min.js"></script>
<![endif]--><!--[if gte IE 9]><!-->
<script type="text/javascript" src="/onethink/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/onethink/Public/Admin/js/jquery.mousewheel.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/onethink/Public/static/layer.js"></script>
<script type="text/javascript">
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    //给父页面传值
    $('#transmit').on('click', function(){
        var n = $('#n').val();
        var id=[];
        var text=[];
        $('input[name="positions"]:checked').each(function(){
            id.push($(this).val());
            text.push($(this).next().text());
        });

        id = id.join(',');
        text = text.join(',');
        if(n == 1){
            parent.$('#start_position_text').val(text);
            parent.$('#start_position').val(id);
        }else{
            parent.$('#end_position_text').val(text);
            parent.$('#end_position').val(id);
        }
        parent.layer.close(index);
    });
    //关闭iframe
    $('#closeIframe').click(function(){
        parent.layer.close(index);
    });
</script>