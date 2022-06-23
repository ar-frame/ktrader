var form, $,areaData;
layui.config({
    base : JS_BASE
}).extend({
    "address" : "address"
})
layui.use(['form','layer','upload','laydate',"address"],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        upload = layui.upload,
        laydate = layui.laydate,
        address = layui.address;

    //上传头像
    upload.render({
        url: JSON_API + "userface",
        elem:'.userFaceBtn',
        ext: 'jpg|png|gif',
        area: ['500', '500px'],
        before: function(input){
            loading = layer.load(2, {
                shade: [0.2,'#000']
            });
        },
        done: function(res){
            layer.close(loading);
            var userface = res.data.data.src;
            $('input[name=img]').val(userface);
            // img.src = ""+userface;
            $('#userFace').attr('src',userface);
        }
    });

    //提交个人资料
    form.on("submit(changeUser)",function(data){
        //弹出loading
        var index = layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        // 实际使用时的提交信息
        $.post(JSON_API + 'changeUser',{
            id : $(".userid").val(),
            realname : $(".realName").val(),
            admin_face : $(".userFace").val(),
            tel : $(".userPhone").val(),
            email : $(".userEmail").val(),
            admin_content : $(".myself").val()
        },function(res){
            top.layer.close(index);
            if (res.success === '1') {
                top.layer.msg("提交成功！");
                setTimeout(function(){
                    top.layer.close(index);
                    top.layer.msg("提交成功！");
                    // layer.closeAll("iframe");
                    //刷新父页面
                    // parent.location.reload();
                },500);
            } else {
                top.layer.msg(res.error_msg);
            }
            return;
        }, 'json')

        return false;
    });

    //修改密码
    form.on("submit(changePwd)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            layer.close(index);
            layer.msg("密码修改成功！");
            $(".pwd").val('');
        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    })
})
