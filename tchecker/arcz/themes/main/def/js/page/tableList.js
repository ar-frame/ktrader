layui.use(['form','layer','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laytpl = layui.laytpl,
        table = layui.table;
    
    var db = "";

    // 数据表列表
    var tableIns = table.render({
        elem: '#tableList',
        url : JSON_API + "tableList",
        cellMinWidth : 95,
        id : "userListTable",
        where: {"db": db},
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'name', title: '表名', minWidth:100, align:"center"},
            {field: 'ismodel', title: '是否存在模型', minWidth:200, align:'center',templet:function(d){
                if(d.ismodel == "1"){
                    return "存在";
                }else if(d.ismodel == "0"){
                    return "不存在";
                }
            }},
            {field: 'ismodel', title: '操作', align:'center', minWidth:175, templet:function(d){
                return d.ismodel == "0" ? '<a class="layui-btn layui-btn-xs" lay-event="createModel">生成模型</a>' : '<a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="viewField" >管理模型</a>';
            }}
            
        ]]
    });

    form.on('select(changedb)', function(data){
        // console.log(data);
        db = data.value;
        // alert(db)
        if (db) {
            tableIns.reload({where: {"db": db}});
        }
    });

    //列表操作 
    table.on('tool(tableList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;

        // 生成模型
        if (layEvent === 'createModel') {
            layer.confirm('确定创建模型？',{icon:3, title:'提示信息'},function(index){
                var modelName = data.name;
                  $.post(JSON_API + 'changeModel',{
                      modelname : modelName
                  },function(data){
                      layer.alert(data.ret_msg);
                      // tableIns.reload();
                      layer.close(index);
                      tableIns.reload();
                  }, 'json')
             });
        // 管理模型
        }else if (layEvent === 'viewField') {
            var tableName = data.name;
                $.post(JSON_API + 'viewField',{
                    tableName : tableName
                },function(data){
                    // 显示数据表字段
                    showFields(data);
                    layer.close(index);
                    tableIns.reload();
                }, 'json')
           
        }
    });

    // 显示数据表字段
    function showFields(data){
      var index = layui.layer.open({
            title : "显示 "+data['data']['tablename']+" 表的字段",
            type : 2,
            content : SERVER_PATH + "systemSetting/showFields/tname/" + data.data.tablename,
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                setTimeout(function(){
                    layui.layer.tips('点击此处返回数据表列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        });
        layui.layer.full(index);
        //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
        $(window).on("resize",function(){
            layui.layer.full(index);
        })
    }


})
