$(document).ready(function () {
    $(".topRightWang").click(function () {
        window.location.href="{{\ar\core\url('home')}}";
    })
    $('.top_img').click(function(){
        window.location.href="{{\ar\core\url('shares')}}";
    })

    $(".topRightWang").hover(function () {
        $(this).css("background","#EEF0FF");
    },function () {
        $(this).css("background","#F8F9FF")
    })
    $(".topRightMore").hover(function () {
        $(this).css("background","#EEF0FF");
    },function () {
        $(this).css("background","#F8F9FF")
    })
    // 关闭搜索
    $(".findHis").click(function () {
        $(".close").show();
    })
    $(".findHis").mouseout(function () {
        var findHis=$(".findHis").val();
        if(findHis.length != "" ){
            $(".close").show()
        }
    })
    $(".findHis").mouseleave(function () {
        var findHis=$(".findHis").val();
        if(findHis.length == "" ){
            $(".close").hide()
        }
    })
    $(".close").hover(function () {
        $(this).attr("src","/trader_center/bestplan/web/themes/main/def/images/sanchu.png")
    },function () {
        $(this).attr("src","/trader_center/bestplan/web/themes/main/def/images/shanchu.png")
    })
    $(".close").click(function () {
        $("input[name='text']").val("").focus();
        $(".close").hide()
    })



    $(".PhoneApp").mousemove(function(){
        $(this).children("p").next().show();
        $(this).children("p").css("background","#F8F9FF");
    })
    $(".PhoneApp").mouseout(function(){
        $(this).children("p").next().hide();
        $(this).children("p").css("background","#FFFFFF");
    })
    $(".wei").mousemove(function(){
        $(this).children().next().show();
        $(this).children("p:first-child").css("background","#F8F9FF");
    })
    $(".wei").mouseout(function(){
        $(this).children().next().hide();
        $(this).children("p:first-child").css("background","#FFFFFF");
    })
    $(".phone").mousemove(function(){
        $(this).children().next().show();
        $(this).children("p:first-child").css("background","#F8F9FF");
    })
    $(".phone").mouseout(function(){
        $(this).children().next().hide();
        $(this).children("p:first-child").css("background","#FFFFFF");
    })
    $(".shengMing").mousemove(function(){
        $("#vr").show();
        $(this).css("background","#F8F9FF");
    })
    $(".shengMing").mouseout(function(){
        $("#vr").hide();
        $(this).css("background","#FFFFFF");
    })
    // 回到顶部
    $(".backTop").hover(function () {
        $(this).css("background","#EEF0FF")
    },function () {
        $(this).css("background","#FFFFFF")
    })
    $(".backTop").click(function(){
        $(".historyCon").animate({
            scrollTop:0
        },400)
    })
    //鼠标移入的时候显示滚动条，移出的时候隐藏混动条
    $(".historyCon").hover(function(){
        $(".historyCon").css("overflow-y","auto");
    },function(){
        $(".historyCon").css("overflow-y","hidden")
    });
})