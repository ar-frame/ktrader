(function(){
	window.onload=function (){
		$('#update_top_right_div_one').click(function(){
	    		window.location.href="/";
	    })
    	$('#update_top_right_div_two').click(function(){
    		window.location.href="./price.html";
    	})
    	$('#update_top_right_div_three').click(function(){
    		window.location.href="./readhelp.html";
    	})
        $('#top_img').click(function(){
            window.location.href="/";
        })

        $('#update_top_right_div_one1').mousemove(function(){
                $('#update_top_right_div_one1').css('border-top-color','blue')
                $('#update_top_right_div_one1 p').css('color','blue')
            }) 
        $('#update_top_right_div_one1').mouseout(function(){
            $('#update_top_right_div_one1').css('border-top-color','transparent')
            $('#update_top_right_div_one1 p').css('color','#000000')
        }) 

        $('#update_top_right_div_two1').mousemove(function(){
            $('#update_top_right_div_two1').css('border-top-color','blue')
            $('#update_top_right_div_two1 p').css('color','blue')
        }) 
        $('#update_top_right_div_two1').mouseout(function(){
            $('#update_top_right_div_one1').css('border-top-color','transparent')
            $('#update_top_right_div_one1 p').css('color','#000000')
        }) 
  

        $('#update_top_right_div_three1').mousemove(function(){
            $('#update_top_right_div_three1').css('border-top-color','blue')
            $('#update_top_right_div_three1 p').css('color','blue')
        }) 
        $('#update_top_right_div_three1').mouseout(function(){
            $('#update_top_right_div_three1').css('border-top-color','transparent')
            $('#update_top_right_div_three1 p').css('color','#000000')
        })

        $('#update_top_right_div_four1').mousemove(function(){
            $('#update_top_right_div_four1').css('border-top-color','blue')
            $('#update_top_right_div_four1 p').css('color','blue')
        }) 
        $('#update_top_right_div_four1').mouseout(function(){
            $('#update_top_right_div_four1').css('border-top-color','blue')
            $('#update_top_right_div_four1 p').css('color','blue')
        })

        $('#backToTop').click(function(){
            $('html, body').animate({  
                 scrollTop: $(".update_log").offset().top  
            }, 1000);
        })

        $('#wx').mousemove(function(){
                $('.contact_left').css('display','flex')
                $('#wx').attr('src','./images/wx.png')
        })
        $('#wx').mouseout(function(){
                $('.contact_left').css('display','none')
                $('#wx').attr('src','./images/wx-1.png')
        })
        $('#kefu').mousemove(function(){
                $('.contact_left').css('display','none')
                $('.kefu_phone').css('display','flex');
                $('#kefu').attr('src','./images/kefu1.png')
        })
        $('#kefu').mouseout(function(){
                $('#kefu').attr('src','./images/kefu.png')
                $('.kefu_phone').css('display','none')
        })
	}
})()