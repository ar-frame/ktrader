layui.use(['form','layer','layedit','laydate','upload'],function(){
    var form = layui.form
        layer = parent.layer === undefined ? layui.layer : top.layer,
        laypage = layui.laypage,
        upload = layui.upload,
        layedit = layui.layedit,
        laydate = layui.laydate,
        $ = layui.jquery;

    //格式化时间
    function filterTime(val){
        if(val < 10){
            return "0" + val;
        }else{
            return val;
        }
    }

    form.on("submit(addMenu)",function(data){
        //弹出loading
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        // 实际使用时的提交信息
        $.post(JSON_API + 'addMenu',{
            id : $(".id").val(),
            title : $(".title").val(),
            href : $(".href").val(),
            icon : $(".icon").val(),
            cate : $('.cate select').val(),
            fid : $('.fid select').val()
        },function(res){
          top.layer.close(index);
          if (res.success === '1') {
            top.layer.msg("菜单添加成功！");
            setTimeout(function(){
                top.layer.close(index);
                top.layer.msg("菜单添加成功！");
                layer.closeAll("iframe");
                //刷新父页面
                parent.location.reload();
            },500);
          } else {
            top.layer.msg(res.error_msg);
          }
          return;
        }, 'json')

        return false;
    });

    //$("#f1").hide();
    //$("#f2").hide();
    //form.on('select(cateMenu)', function(data){
    //    var cateNum = data.value;
    //    if(cateNum == 1){
    //        $("#f1").hide();
    //        $("#f2").hide();
    //    } else if(cateNum == 2){
    //        $("#f2").hide();
    //        $("#f1").show();
    //    } else if(cateNum == 3){
    //        $("#f1").hide();
    //        $("#f2").show();
    //    }
    //
    //});




})

