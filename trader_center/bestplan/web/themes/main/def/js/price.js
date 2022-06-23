(function(){
		window.onload=function(){


			$('#price_top_right_div_one1').mousemove(function(){
	    		$('#price_top_right_div_one1').css('border-top-color','blue')
	    		$('#price_top_right_div_one1 p').css('color','blue')
	    	}) 
	    	$('#price_top_right_div_one1').mouseout(function(){
	    		$('#price_top_right_div_one1').css('border-top-color','transparent')
	    		$('#price_top_right_div_one1 p').css('color','#000000')
	    	}) 

	    	$('#price_top_right_div_two1').mousemove(function(){
	    		$('#price_top_right_div_two1').css('border-top-color','blue')
	    		$('#price_top_right_div_two1 p').css('color','blue')
	    	}) 
	  

	    	$('#price_top_right_div_three1').mousemove(function(){
	    		$('#price_top_right_div_three1').css('border-top-color','blue')
	    		$('#price_top_right_div_three1 p').css('color','blue')
	    	}) 
	    	$('#price_top_right_div_three1').mouseout(function(){
	    		$('#price_top_right_div_three1').css('border-top-color','transparent')
	    		$('#price_top_right_div_three1 p').css('color','#000000')
	    	})

	    	$('#price_top_right_div_four1').mousemove(function(){
	    		$('#price_top_right_div_four1').css('border-top-color','blue')
	    		$('#price_top_right_div_four1 p').css('color','blue')
	    	}) 
	    	$('#price_top_right_div_four1').mouseout(function(){
	    		$('#price_top_right_div_four1').css('border-top-color','transparent')
	    		$('#price_top_right_div_four1 p').css('color','#000000')
	    	})

			$('#price_top_right_div_five1').mousemove(function(){
				$('#price_top_right_div_five1').css('border-top-color','blue')
				$('#price_top_right_div_five1 p').css('color','blue')
			})
			$('#price_top_right_div_five1').mouseout(function(){
				$('#price_top_right_div_five1').css('border-top-color','transparent')
				$('#price_top_right_div_five1 p').css('color','#000000')
			})

	    	$('#contactkefu_one').mousemove(function(){
	    		$('#contactkefu_one').css('background-color','#2975ff')
	    	})
	    	$('#contactkefu_one').mouseout(function(){
	    		$('#contactkefu_one').css('background-color','#005AFF')
	    	})

	    	$('#contactkefu_two').mousemove(function(){
	    		$('#contactkefu_two').css('background-color','#2975ff')
	    	})
	    	$('#contactkefu_two').mouseout(function(){
	    		$('#contactkefu_two').css('background-color','#005AFF')
	    	})

	    	$('#qq').mousemove(function(){
	    		$('.contact_left').css('display','flex')
	    		$('#qq').attr('src','{{C.PATH.PUBLIC}}images/qq1.png')
	    	})
	    	$('#qq').mouseout(function(){
	    		$('.contact_left').css('display','none')
	    		$('#qq').attr('src','{{C.PATH.PUBLIC}}images/qq.png')
	    	})
	    	$('#wx').mousemove(function(){
	    		$('.contact_left').css('display','flex')
	    		$('#wx').attr('src','{{C.PATH.PUBLIC}}images/wx.png')
	    	})
	    	$('#wx').mouseout(function(){
	    		$('.contact_left').css('display','none')
	    		$('#wx').attr('src','{{C.PATH.PUBLIC}}images/wx-1.png')
	    	})
	    	$('#kefu').mousemove(function(){
	    		$('.contact_left').css('display','none')
	    		$('.kefu_phone').css('display','flex');
	    		$('#kefu').attr('src','{{C.PATH.PUBLIC}}images/kefu1.png')
	    	})
	    	$('#kefu').mouseout(function(){
	    		$('#kefu').attr('src','{{C.PATH.PUBLIC}}images/kefu.png')
	    		$('.kefu_phone').css('display','none')
	    	})


	    	//点击事件
	    	$('#backToTop').click(function(){
	    		$('html, body').animate({  
				 	 scrollTop: $(".price").offset().top  
				}, 1000);
	    	})
	    	$('#top_img').click(function(){
	    		window.location.href="{{\ar\core\url('home')}}";
	    	})
	    	$('#contactkefu_one').click(function(){
	    		$('.contact_left').css('display','flex')
	    		// alert("请扫描右侧微信客服二维码,获得一对一专业服务")
	    		$('.kefu_modal_1').css('display','flex');
	    		setTiemout(function(){
	    			$('.kefu_modal_1').css('display','none');
	    		},3000)
	    	})
	    	$('#contactkefu_two').click(function(){
	    		$('.contact_left').css('display','flex')
	    		// alert("请扫描右侧微信客服二维码,获得一对一专业服务")
	    		$('.kefu_modal').css('display','flex');
	    		setTiemout(function(){
	    			$('.kefu_modal').css('display','none');
	    		},3000)
	    	})

	    	$('#price_top_right_div_one').click(function(){
	    		window.location.href='{{\ar\core\url('home')}}';
	    	})
	    	$('#price_top_right_div_three').click(function(){
	    		window.location.href='{{\ar\core\url('readhelp')}}';
	    	})
	    	$('#price_top_right_div_four').click(function(){
	    		window.location.href='{{\ar\core\url('download')}}';
	    	})
			$('#price_top_right_div_five').click(function(){
				window.location.href='{{\ar\core\url('shares')}}';
			})
	}	
})()