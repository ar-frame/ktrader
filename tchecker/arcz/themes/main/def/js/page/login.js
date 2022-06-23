layui.use(['form','layer','jquery'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer
        $ = layui.jquery;

    //登录按钮
    form.on("submit(login)",function(data){
        // console.log(data.field);
        $.post(SERVER_PATH + 'Login/loginApi', data.field, data => {
            console.log(data)
            if (data.success == '1') {
              $(this).text("登录中...").attr("disabled","disabled").addClass("layui-disabled");
              setTimeout(function(){
                  window.location.href = SERVER_PATH;
              },1000);
            } else {
                layer.msg(data.error_msg);
            }
        }, 'json')

        return false;
    })

    //表单输入效果
    $(".loginBody .input-item").click(function(e){
        e.stopPropagation();
        $(this).addClass("layui-input-focus").find(".layui-input").focus();
    })
    $(".loginBody .layui-form-item .layui-input").focus(function(){
        $(this).parent().addClass("layui-input-focus");
    })
    $(".loginBody .layui-form-item .layui-input").blur(function(){
        $(this).parent().removeClass("layui-input-focus");
        if($(this).val() != ''){
            $(this).parent().addClass("layui-input-active");
        }else{
            $(this).parent().removeClass("layui-input-active");
        }
    })
})
