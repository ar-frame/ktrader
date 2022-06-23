layui.use(['form','layer','laydate','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        laytpl = layui.laytpl,
        table = layui.table;

    //添加验证规则
    form.verify({
        newPwd : function(value, item){
            if(value.length < 6){
                return "密码长度不能小于6位";
            }
        },
        confirmPwd : function(value, item){
            if($("#newPwd").val() != $("#new2Pwd").val()){
                return "两次输入密码不一致，请重新输入！";
            }
        }
    });

    //修改密码
    form.on("submit(changePwd)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});

        $.post(JSON_API + 'changeUserPwd',{
            uid : $("#uid").val(),
            oldPwd : $("#oldPwd").val(),
            newPwd : $("#newPwd").val(),
            new2Pwd : $("#new2Pwd").val()
        },function(res){
            top.layer.close(index);
            if (res.success === '1') {
                setTimeout(function(){
                    layer.close(index);
                    layer.msg(res.ret_msg);
                    $(".pwd").val('');
                },2000);
            } else {
                top.layer.msg(res.error_msg);
            }
            return;
        }, 'json');
        return false;
    });

    // 添加用户组
    $(".addNewRole").click(function(){
        var rolename = $(".rolename").val();
        if(rolename.length<1){
            return "必填项不能为空！";
        } else {
            var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
            // 实际使用时的提交信息
            $.post(JSON_API + 'addRole',{
                name : rolename
            },function(res){
                top.layer.close(index);
                if (res.success === '1') {
                    top.layer.msg("添加成功！");
                    setTimeout(function(){
                        top.layer.close(index);
                        top.layer.msg("添加成功！");
                        // layer.closeAll("iframe");
                        //刷新父页面
                        // parent.location.reload();
                    },500);
                } else {
                    top.layer.msg(res.error_msg);
                }
                return;
            }, 'json')
        }

    });

    //控制表格编辑时文本的位置【跟随渲染时的位置】
    $("body").on("click",".layui-table-body.layui-table-main tbody tr td",function(){
        $(this).find(".layui-table-edit").addClass("layui-"+$(this).attr("align"));
    });

})