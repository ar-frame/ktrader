layui.use(['form','layer','laydate','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        laytpl = layui.laytpl,
        table = layui.table;

    //菜单列表
    var tableIns = table.render({
        elem: '#menuList',
        url : JSON_API + 'navsList',
        cellMinWidth : 95,
        id : "menuListTable",
        cols : [[
            {field: 'id', title: 'ID', width:60, align:"center"},
            {field: 'title', title: '菜单标题', width:250},
            {field: 'href', title: '链接', align:'center'},
            {field: 'cate', title: '分类',  align:'center',templet:function(d){
                if(d.cate == "1"){
                    return "一级菜单";
                }else if(d.cate == "2"){
                    return "二级菜单";
                }else if(d.cate == "3"){
                    return "三级菜单";
                }
            }},
            {field: 'fmenu', title: '父级菜单',  align:'center'},
            {field: 'num', title: '排序值', align:'center', width:120},
            {title: '操作', width:170, templet:'#menuListBar',fixed:"right",align:"center" , templet:function(d){
                return d.issystem == "0" ? '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a> <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>' :
                    '<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>';
            }}
        ]]
    });


    //搜索【此功能需要后台配合，所以暂时没有动态效果演示】
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

    // 添加菜单页面
    function addMenu(edit){
        var index = layui.layer.open({
            title : "菜单内容",
            type : 2,
            content : SERVER_PATH + "systemSetting/menuAdd",
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                console.log(edit);
                if(edit){
                    body.find(".id").val(edit.id);
                    body.find(".title").val(edit.title.replace(/&nbsp;/gi,''));
                    body.find(".icon").val(edit.icon);
                    body.find(".href").val(edit.href);
                    body.find(".num").val(edit.num);
                    body.find(".cate select").val(edit.cate);
                    body.find(".fid select").val(edit.fid);
                    if(edit.cate == 1){
                        body.find(".nav_no select").val(edit.fid);
                    } else if(edit.cate == 2){
                        body.find(".nav_top select").val(edit.fid);
                    } else if(edit.cate == 3){
                        body.find(".nav_sec select").val(edit.fid);
                    }
                    form.render();
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
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
    $(".addMenu_btn").click(function(){
        addMenu();
    });

    //列表操作
    table.on('tool(menuList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;

        if(layEvent === 'edit'){ //编辑
            addMenu(data);
        } else if(layEvent === 'del'){ //删除
            layer.confirm('确定删除菜单？',{icon:3, title:'提示信息'},function(index){
                $.post(JSON_API + 'delMenu', {
                    id : data.id  //将需要删除的id作为参数传入
                },function(data){
                     if (data.success == '1') {
                         tableIns.reload();
                         layer.close(index);
                         layer.msg(data.ret_msg);
                     } else {
                         top.layer.msg(data.error_msg);
                     }

                }, 'json')
            });
        } else if(layEvent === 'look'){ //预览
            layer.alert("此功能需要前台展示，实际开发中传入对应的必要参数进行文章内容页面访问")
        }
    });

})
