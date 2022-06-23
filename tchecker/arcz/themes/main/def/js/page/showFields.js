layui.use(['form','layer','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laytpl = layui.laytpl,
        table = layui.table;

    // 数据表列表
    var tableIns = table.render({
        elem: '#tableCols',
        url : JSON_API + "tableCols",
        cellMinWidth : 95,
        page : true,
        height : "full-125",
        limits : [10,15,20,25],
        limit : 20,
        id : "userListTable",
        cols : [[
            {field: 'colname', title: '字段名称', align:"center"},
            {field: 'explain', title: '字段说明', align:"center"},
            {field: 'isshow', title: '是否显示', align:'center',templet:function(d){
                return d.isshow == "1" ? "显示" : "不显示";
            }},
            {field: 'isedit', title: '是否可编辑', align:'center',templet:function(d){
                return d.isedit == "1" ? "可编辑" : "不可编辑";
            }},
            {field: 'ordernum', title: '排序', align:'center'},
            {title: '操作', templet:'#tableColsBar',fixed:"right",align:"center"}           
        ]]
    });

    //搜索【此功能需要后台配合，所以暂时没有动态效果演示】layui-btn layui-btn-xs layui-btn-warm
    $(".search_btn").on("click",function(){
        if($(".searchVal").val() != ''){
            table.reload("newsListTable",{
                page: {
                    curr: 1 //重新从第 1 页开始
                },
                where: {
                    key: $(".searchVal").val()  //搜索的关键字
                }
            })
        }else{
            layer.msg("请输入搜索的内容");
        }
    });

    
    $(".addCol_btn").click(function(){
        manageCols();
    })

    //批量删除
    $(".delAll_btn").click(function(){
        var checkStatus = table.checkStatus('userListTable'),
            data = checkStatus.data,
            newsId = [];
        if(data.length > 0) {
            for (var i in data) {
                newsId.push(data[i].newsId);
            }
            layer.confirm('确定删除选中的用户？', {icon: 3, title: '提示信息'}, function (index) {
                // $.get("删除文章接口",{
                //     newsId : newsId  //将需要删除的newsId作为参数传入
                // },function(data){
                tableIns.reload();
                layer.close(index);
                // })
            })
        }else{
            layer.msg("请选择需要删除的用户");
        }
    });


    //列表操作 
    table.on('tool(tableCols)', function(obj){
        var layEvent = obj.event,
            data = obj.data;
        if (layEvent === 'editCols') {
            manageCols(data);
        };
    });

    // 显示数据表字段
    function manageCols(data){
        var index = layui.layer.open({
            title : "管理字段",//"管理 "+data.tablename+" 表的字段",
            type : 2,
            content : SERVER_PATH + "SystemSetting/manageCols",
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                if(data){
                    body.find(".id").val(data.id);
                    body.find(".tablename").val(data.tablename);  // 数据表名
                    body.find(".colname").val(data.colname);  // 字段名
                    body.find(".explain").val(data.explain);  // 字段说明
                    body.find(".isshow").val(data.isshow);  // 是否显示，默认1显示，0不显示
                    body.find(".isedit").val(data.isedit);  // 是否可编辑，默认1可编辑，0不可编辑
                    body.find(".ordernum").val(data.ordernum);  // 排序值，值越大，显示在越前面
                    form.render();
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回数据表列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
        //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
        $(window).on("resize",function(){
            layui.layer.full(index);
        })
    }


})
