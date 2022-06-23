var cacheStr = window.sessionStorage.getItem("cache"),
    oneLoginStr = window.sessionStorage.getItem("oneLogin");
layui.use(['form','jquery',"layer"],function() {
    var form = layui.form,
        $ = layui.jquery,
        layer = parent.layer === undefined ? layui.layer : top.layer;

    //判断是否web端打开
    if(!/http(s*):\/\//.test(location.href)){
        layer.alert("请先将项目部署到 localhost 下再进行访问【建议通过tomcat、webstorm、hb等方式运行，不建议通过iis方式运行】，否则部分数据将无法显示");
    }else{    //判断是否处于锁屏状态【如果关闭以后则未关闭浏览器之前不再显示】
        if(window.sessionStorage.getItem("lockcms") != "true" && window.sessionStorage.getItem("showNotice") != "true"){
            // showNotice();
        }
    }

    //公告层
    function showNotice(){
        layer.open({
            type: 2,
            title: "系统公告",
            skin: 'layui-layer-rim',
            area: ['600px', '400px'],
            content: SERVER_PATH + "index/notice",
            success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.css('text-align', 'center');
                btn.on("click",function(){
                    tipsShow();
                });
            },
            cancel: function(index, layero){
                tipsShow();
            }
        });
    }
    function tipsShow(){
        window.sessionStorage.setItem("showNotice","true");
        if($(window).width() > 432){  //如果页面宽度不足以显示顶部“系统公告”按钮，则不提示
            layer.tips('系统公告躲在了这里', '#userInfo', {
                tips: 3,
                time : 1000
            });
        }
    }
    $(".showNotice").on("click",function(){
        showNotice();
    })

    //退出
    $(".signOut").click(function(){
        window.sessionStorage.removeItem("menu");
        menu = [];
        window.sessionStorage.removeItem("curmenu");
    });

    //判断是否修改过系统基本设置，去显示底部版权信息
    if(window.sessionStorage.getItem("systemParameter")){
        systemParameter = JSON.parse(window.sessionStorage.getItem("systemParameter"));
        $(".footer p span").text(systemParameter.powerby);
    }

    //更换皮肤
    function skins(){
        var skin = window.sessionStorage.getItem("skin");
        if(skin){  //如果更换过皮肤
            if(window.sessionStorage.getItem("skinValue") != "自定义"){
                $("body").addClass(window.sessionStorage.getItem("skin"));
            }else{
                $(".layui-layout-admin .layui-header").css("background-color",skin.split(',')[0]);
                $(".layui-bg-black").css("background-color",skin.split(',')[1]);
                $(".hideMenu").css("background-color",skin.split(',')[2]);
            }
        }
    }
    skins();
    $(".changeSkin").click(function(){
        layer.open({
            title : "更换皮肤",
            area : ["310px","280px"],
            type : "1",
            content : '<div class="skins_box">'+
                            '<form class="layui-form">'+
                                '<div class="layui-form-item">'+
                                    '<input type="radio" name="skin" value="默认" title="默认" lay-filter="default" checked="">'+
                                    '<input type="radio" name="skin" value="橙色" title="橙色" lay-filter="orange">'+
                                    '<input type="radio" name="skin" value="蓝色" title="蓝色" lay-filter="blue">'+
                                    '<input type="radio" name="skin" value="自定义" title="自定义" lay-filter="custom">'+
                                    '<div class="skinCustom">'+
                                        '<input type="text" class="layui-input topColor" name="topSkin" placeholder="顶部颜色" />'+
                                        '<input type="text" class="layui-input leftColor" name="leftSkin" placeholder="左侧颜色" />'+
                                        '<input type="text" class="layui-input menuColor" name="btnSkin" placeholder="顶部菜单按钮" />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="layui-form-item skinBtn">'+
                                    '<a href="javascript:;" class="layui-btn layui-btn-sm layui-btn-normal" lay-submit="" lay-filter="changeSkin">确定更换</a>'+
                                    '<a href="javascript:;" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit="" lay-filter="noChangeSkin">朕再想想</a>'+
                                '</div>'+
                            '</form>'+
                        '</div>',
            success : function(index, layero){
                var skin = window.sessionStorage.getItem("skin");
                if(window.sessionStorage.getItem("skinValue")){
                    $(".skins_box input[value="+window.sessionStorage.getItem("skinValue")+"]").attr("checked","checked");
                };
                if($(".skins_box input[value=自定义]").attr("checked")){
                    $(".skinCustom").css("visibility","inherit");
                    $(".topColor").val(skin.split(',')[0]);
                    $(".leftColor").val(skin.split(',')[1]);
                    $(".menuColor").val(skin.split(',')[2]);
                };
                form.render();
                $(".skins_box").removeClass("layui-hide");
                $(".skins_box .layui-form-radio").on("click",function(){
                    var skinColor;
                    if($(this).find("div").text() == "橙色"){
                        skinColor = "orange";
                    }else if($(this).find("div").text() == "蓝色"){
                        skinColor = "blue";
                    }else if($(this).find("div").text() == "默认"){
                        skinColor = "";
                    }
                    if($(this).find("div").text() != "自定义"){
                        $(".topColor,.leftColor,.menuColor").val('');
                        $("body").removeAttr("class").addClass("main_body "+skinColor+"");
                        $(".skinCustom").removeAttr("style");
                        $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                    }else{
                        $(".skinCustom").css("visibility","inherit");
                    }
                })
                var skinStr,skinColor;
                $(".topColor").blur(function(){
                    $(".layui-layout-admin .layui-header").css("background-color",$(this).val()+" !important");
                })
                $(".leftColor").blur(function(){
                    $(".layui-bg-black").css("background-color",$(this).val()+" !important");
                })
                $(".menuColor").blur(function(){
                    $(".hideMenu").css("background-color",$(this).val()+" !important");
                })

                form.on("submit(changeSkin)",function(data){
                    if(data.field.skin != "自定义"){
                        if(data.field.skin == "橙色"){
                            skinColor = "orange";
                        }else if(data.field.skin == "蓝色"){
                            skinColor = "blue";
                        }else if(data.field.skin == "默认"){
                            skinColor = "";
                        }
                        window.sessionStorage.setItem("skin",skinColor);
                    }else{
                        skinStr = $(".topColor").val()+','+$(".leftColor").val()+','+$(".menuColor").val();
                        window.sessionStorage.setItem("skin",skinStr);
                        $("body").removeAttr("class").addClass("main_body");
                    }
                    window.sessionStorage.setItem("skinValue",data.field.skin);
                    layer.closeAll("page");
                });
                form.on("submit(noChangeSkin)",function(){
                    $("body").removeAttr("class").addClass("main_body "+window.sessionStorage.getItem("skin")+"");
                    $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                    skins();
                    layer.closeAll("page");
                });
            },
            cancel : function(){
                $("body").removeAttr("class").addClass("main_body "+window.sessionStorage.getItem("skin")+"");
                $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                skins();
            }
        })
    })

})