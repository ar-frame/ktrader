layui.use(['form','layer','table','laytpl'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laytpl = layui.laytpl,
        table = layui.table;

    //需求列表
    var tableIns = table.render({
        elem: '#requirementList',
        url : JSON_API + "requirementList",
        cellMinWidth : 95,
        page : true,
        height : "full-125",
        limits : [10,15,20,25],
        limit : 20,
        id : "userListTable",
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'name', title: '需求名称', minWidth:100, align:"center"},
            {field: 'des', title: '需求描述', minWidth:200, align:'center'},
            {field: 'budget', title: '目标金额', minWidth:150, align:'center'},
            {field: 'contactname', title: '联系人', minWidth:150, align:'center'},
            {field: 'contact', title: '联系方式', minWidth:150, align:'center'},
            // {field: 'status', title: '用户状态',  align:'center',templet:function(d){
            //     return d.status == "1" ? "正常使用" : "限制使用";
            // }},
            // {field: 'isAdmin', title: '是否管理员',  align:'center',templet:function(d){
            //     return d.isAdmin == "1" ? "管理员" : "普通用户";
            // }},
            {title: '操作', minWidth:175, templet:'#requirementListBar',fixed:"right",align:"center"}
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

    //添加用户
    function addUser(edit){
        var index = layui.layer.open({
            title : "添加用户",
            type : 2,
            content : SERVER_PATH + "user/userAdd",
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                if(edit){
                    body.find(".id").val(edit.id);
                    body.find(".username").val(edit.username);  //登录名
                    body.find(".nickname").val(edit.nickname);
                    body.find(".realName").val(edit.realName);
                    body.find(".userEmail").val(edit.userEmail);  //邮箱
                    body.find(".userPhone").val(edit.userPhone);
                    body.find(".status").val(edit.status);    //用户状态
                    body.find(".myself").text(edit.myself);    //用户简介
                    form.render();
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回用户列表', '.layui-layer-setwin .layui-layer-close', {
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
    $(".addNews_btn").click(function(){
        addUser();
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
    })

    //列表操作
    table.on('tool(requirementList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;

        if(layEvent === 'turn'){ //编辑
            var description = "";  
            for (var i in data) {  
                description += i + " = " + data[i] + "\n";  
            }  
            alert(description); exit; 
            
            addRequirement(description);
        }
        // }else if(layEvent === 'usable'){ //启用禁用
        //     var _this = $(this),
        //         usableText = "是否确定禁用此用户？",
        //         btnText = "已禁用";
        //     if(_this.text()=="已禁用"){
        //         usableText = "是否确定启用此用户？",
        //         btnText = "已启用";
        //     }
        //     layer.confirm(usableText,{
        //         icon: 3,
        //         title:'系统提示',
        //         cancel : function(index){
        //             layer.close(index);
        //         }
        //     },function(index){
        //         _this.text(btnText);
        //         layer.close(index);
        //     },function(index){
        //         layer.close(index);
        //     });
        // }else if(layEvent === 'del'){ //删除
        //     layer.confirm('确定删除此用户？',{icon:3, title:'提示信息'},function(index){
        //         // $.get("删除文章接口",{
        //         //     newsId : data.newsId  //将需要删除的newsId作为参数传入
        //         // },function(data){
        //             tableIns.reload();
        //             layer.close(index);
        //         // })
        //     });
        // }
    });

})
