<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/onethink/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/onethink/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/onethink/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/onethink/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <div class="main-title">
        <h2>编辑任务配置管理</h2>
    </div>
    <form action="<?php echo U();?>" method="post" class="form-horizontal">
        <div class="form-item">
            <label class="item-label">科室分类名称<span class="check-tips">（用于后台显示所属科室分类）</span></label>
            <div class="controls">
                <select name="depart">
                    <?php if(is_array($depart)): $i = 0; $__LIST__ = $depart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($menu["id"]); ?>"><?php echo ($menu["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">机构组织<span class="check-tips">（用于后台显示所属机构组织）</span></label>
            <div class="controls">
                <select name="dept">
                    <?php if(is_array($dept)): $i = 0; $__LIST__ = $dept;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dept): $mod = ($i % 2 );++$i;?><option value="<?php echo ($dept["id"]); ?>"><?php echo ($dept["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务发起位置<span class="check-tips">（选择开始位置或目标位置）</span></label>
            <div class="controls">
                <label class="radio"><input type="radio" name="start_position" value="1">开始位置</label>
                <label class="radio"><input type="radio" name="start_position" value="2">目标位置</label>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">位置<span class="check-tips">（开始位置或目标位置）</span></label>
            <div class="controls">
                <input type="text" class="text" id="position_text" value="<?php echo ((isset($str_depart) && ($str_depart !== ""))?($str_depart):'请选择位置'); ?>" onclick="open_iframe();">
                <input type="hidden" class="text" id="position" name="position" value="<?php echo ((isset($info["position"]) && ($info["position"] !== ""))?($info["position"]):'0'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">实时任务天数<span class="check-tips">（用于后台显示实时任务天数）</span></label>
            <div class="controls">
                <input type="text" class="text" name="days" value="<?php echo ((isset($info["days"]) && ($info["days"] !== ""))?($info["days"]):'0'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">完成时限<span class="check-tips">（用于后台显示的完成时限）</span></label>
            <div class="controls">
                <input type="text" class="text" name="time_limit" value="<?php echo ((isset($info["time_limit"]) && ($info["time_limit"] !== ""))?($info["time_limit"]):'0'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">发起任务频率<span class="check-tips">（用于后台显示的发起任务频率）</span></label>
            <div class="controls">
                <input type="text" class="text" name="task_fre" value="<?php echo ((isset($info["task_fre"]) && ($info["task_fre"] !== ""))?($info["task_fre"]):'0'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务权重<span class="check-tips">（用于后台显示的任务权重）</span></label>
            <div class="controls">
                <input type="text" class="text" name="weights" value="<?php echo ((isset($info["weights"]) && ($info["weights"] !== ""))?($info["weights"]):'0'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务调度超时<span class="check-tips">（请填入数字，单位为s，默认为120s）</span></label>
            <div class="controls">
                <input type="text" class="text" name="scheduled_timeout" value="<?php echo ((isset($info["scheduled_timeout"]) && ($info["scheduled_timeout"] !== ""))?($info["scheduled_timeout"]):'120'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务接收超时<span class="check-tips">（请填入数字，单位为s，默认为300s）</span></label>
            <div class="controls">
                <input type="text" class="text" name="receive_timeout" value="<?php echo ((isset($info["receive_timeout"]) && ($info["receive_timeout"] !== ""))?($info["receive_timeout"]):'300'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务完成超时<span class="check-tips">（请填入数字，单位为s，默认为600s）</span></label>
            <div class="controls">
                <input type="text" class="text" name="complete_overtime" value="<?php echo ((isset($info["complete_overtime"]) && ($info["complete_overtime"] !== ""))?($info["complete_overtime"]):'600'); ?>">
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">任务抢单超时<span class="check-tips">（请填入数字，单位为s，默认为120s）</span></label>
            <div class="controls">
                <input type="text" class="text" name="grab_timeout" value="<?php echo ((isset($info["grab_timeout"]) && ($info["grab_timeout"] !== ""))?($info["grab_timeout"]):'120'); ?>">
            </div>
        </div>
        <div class="form-item">
            <input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
            <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
        </div>
    </form>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/onethink", //当前网站地址
            "APP"    : "/onethink/admin.php?s=", //当前项目地址
            "PUBLIC" : "/onethink/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/onethink/Public/static/think.js"></script>
    <script type="text/javascript" src="/onethink/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
    <script type="text/javascript" src="/onethink/Public/static/layer.js"></script>
    <script type="text/javascript">
        Think.setValue("depart", <?php echo ((isset($info["depart"]) && ($info["depart"] !== ""))?($info["depart"]): 0); ?>);
        Think.setValue("dept", <?php echo ((isset($info["dept"]) && ($info["dept"] !== ""))?($info["dept"]): 0); ?>);
        Think.setValue("start_position", <?php echo ((isset($info["start_position"]) && ($info["start_position"] !== ""))?($info["start_position"]): 0); ?>);
        //导航高亮
        highlight_subnav('<?php echo U('index');?>');

        function open_iframe(){
            var arrId = $('#position').val();
            var url = "<?php echo U('iframe?id=');?>";
            var arr = url.split(".");
            url = arr[0]+'.'+arr[1]+'/id/'+arrId+'.html';
            layer.open({
                type: 2,
                area: ['700px', '450px'],
                fixed: false, //不固定
                maxmin: true,
                content: url
            });
        }
    </script>

</body>
</html>