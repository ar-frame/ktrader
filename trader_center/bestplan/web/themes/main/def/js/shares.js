
window.onload=function(){
        $('.top_img').click(function(){
            window.location.href="{{\ar\core\url('shares')}}";
        })
        $(".topRightWang").click(function () {
            window.location.href="{{\ar\core\url('home')}}";
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

        // $(".mainTopLeft>div").hover(function () {
        //     $(this).css("background","#EEF0FF")
        //     // $(this).children("div:first-child").css("color","#FFFFFF")
        //     // $(this).children("div:last-child").children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/jiantou22.png")
        // },function () {
        //     $(this).css("background","#FFFFFF")
        //     // $(this).children("div:first-child").css("color","#525265")
        //     // $(this).children("div:last-child").children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/gjiantou.png")
        // })
        $(".mainTopLeft>div").click(function () {
            $(this).css("background","#005AFF")
            $(this).children("div:first-child").css("color","#FFFFFF")
            $(this).children("div:last-child").children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/jiantou22.png")
            $(this).siblings().css("background","#FFFFFF")
            $(this).siblings().children("div:first-child").css("color","#525265")
            $(this).siblings().children("div:last-child").children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/gjiantou.png")
        })

        $(".mainTopLeft>div").mousemove(function () {
            if( $(this).children("div:last-child").children("img").attr("src")=="/trader_center/bestplan/web/themes/main/def/images/jiantou22.png"){
                $(this).css("background","#005AFF")
                $(this).children("div:first-child").css("color","#FFFFFF")
            }else{
                $(this).css("background","#EEF0FF")
            }
        })
        $(".mainTopLeft>div").mouseout(function(){
            if( $(this).children("div:last-child").children("img").attr("src")=="/trader_center/bestplan/web/themes/main/def/images/jiantou22.png"){
                $(this).css("background","#005AFF")
                $(this).children("div:first-child").css("color","#FFFFFF")
            }else{
                $(this).css("background","#FFFFFF")
            }
        })


        // 搜索
        $(".mainTopRight>div").click(function () {
            var hy=$(".find").val();
            console.log(hy);
            if(hy != ''){
                $(".ts").show();
            }else {
                $(".ts").hide();
            }

        })
        // 关闭搜索
        $(".find").click(function () {
            $(".close").show();
        })
        $(".find").mouseout(function () {
            var hy=$(".find").val();
            if(hy.length != "" ){
                $(".close").show()
            }
        })
        $(".find").mouseleave(function () {
            var hy=$(".find").val();
            if(hy.length == "" ){
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
            $(".close").hide();
            $(".ts").hide();
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

        $(".mainContentLeft>ul").hover(function () {
            $(this).children().children("div:first-child").css("background","#005AFF")
        },function () {
            $(this).children().children("div:first-child").css("background","#525265")
        })

        $(".mainShuJuClick>a").hover(function () {
            $(this).css('color',"#005AFF",'background',"#EEF0FF")
            $(this).children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/right22.png")
            $(this).siblings().css('color',"#525265",'background',"#F8F9FF")
            $(this).siblings().children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/right11.png")
        },function () {
            $(this).css('color',"#525265",'background',"#F8F9FF")
            $(this).children("img").attr("src","/trader_center/bestplan/web/themes/main/def/images/right11.png")
        })
        $(".history").click(function () {
            window.open("{{\ar\core\url('history')}}");
        })
        $(".mainContentLeft>ul").on("click","li",function () {
            // window.location.href="{{\ar\core\url('reportDetails')}}.attr(\"target\", \"_blank\")";
            window.open("{{\ar\core\url('reportDetails')}}");
        })
        //鼠标移入的时候显示滚动条，移出的时候隐藏混动条
        $(".mainContentLeftOverF").hover(function(){
            $(".mainContentLeftOverF").css("overflow-y","auto");
        },function(){
            $(".mainContentLeftOverF").css("overflow-y","hidden")
        });
        // 回到顶部
        $(".backTop").hover(function () {
            $(this).css("background","#EEF0FF")
        },function () {
            $(this).css("background","#FFFFFF")
        })
        $(".backTop").click(function () {
                $(".mainContentLeftOverF").animate({
                    scrollTop: 0
                }, 400);
        })















    }