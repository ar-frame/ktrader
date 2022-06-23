layui.use(['form','layer'],function(){
    var form = layui.form
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery;

    form.on("submit(manageCols)",function(data){
        //弹出loading
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        // 实际使用时的提交信息
         $.post(JSON_API + 'manageCols',{
             id : $(".id").val(),
             tablename : $(".tablename").val(),  // 数据表名
             colname : $(".colname").val(),  // 字段名
             explain : $(".explain").val(),  // 字段说明
             isshow : $(".isshow").val(),  // 是否显示，默认1显示，0不显示
             isedit : $(".isedit").val(),  // 是否可编辑，默认1可编辑，0不可编辑
             ordernum : $(".ordernum").val(),  // 排序值，值越大，显示在越前面
         },function(res){
             top.layer.close(index);
             if (res.success === '1') {
                 top.layer.msg("字段编辑成功！");
                 setTimeout(function(){
                     top.layer.close(index);
                     top.layer.msg("字段编辑成功！");
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

    //格式化时间
    function filterTime(val){
        if(val < 10){
            return "0" + val;
        }else{
            return val;
        }
    }
    //定时发布
    var time = new Date();
    var submitTime = time.getFullYear()+'-'+filterTime(time.getMonth()+1)+'-'+filterTime(time.getDate())+' '+filterTime(time.getHours())+':'+filterTime(time.getMinutes())+':'+filterTime(time.getSeconds());

})