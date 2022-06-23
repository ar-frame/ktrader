(function(){
	window.onload=function(){
			var swiper = new Swiper('.swiper-container', {
				direction:"vertical",
				observeParents:true,//修改swiper的父元素时，自动初始化swiper
				observer:true,//修改swiper自己或子元素时，自动初始化swiper 
			      pagination: {
			        el: '.swiper-pagination',
			        clickable: true,
			        renderBullet: function (index, className) {
			          return '<span class="' + className + '">' + (index + 1) + '</span>';
			        },
			      },
			    });

			$('#backToTop').click(function(){
	    		$('html, body').animate({  
				 	 scrollTop: $(".success_cases").offset().top  
				}, 1000);
	    	})
	    	$('#top_img').click(function(){
	    		window.location.href="/";
	    	})

			$('#success_top_right_div_two').click(function(){
	    		window.location.href="./price.html";
	    	})
	    	$('#success_top_right_div_one').click(function(){
	    		window.location.href="/";
	    	})
	    	$('#success_top_right_div_four').click(function(){
	    		window.location.href="./download.html";
	    	})

	    	$('#success_top_right_div_one1').mousemove(function(){
	    		$('#success_top_right_div_one1').css('border-top-color','blue')
	    		$('#success_top_right_div_one1 p').css('color','blue')
	    	}) 
	    	$('#success_top_right_div_one1').mouseout(function(){
	    		$('#success_top_right_div_one1').css('border-top-color','transparent')
	    		$('#success_top_right_div_one1 p').css('color','#000000')
	    	}) 

	    	$('#success_top_right_div_two1').mousemove(function(){
	    		$('#success_top_right_div_two1').css('border-top-color','blue')
	    		$('#success_top_right_div_two1 p').css('color','blue')
	    	})
	    	$('#success_top_right_div_two1').mouseout(function(){
	    		$('#success_top_right_div_two1').css('border-top-color','transparent')
	    		$('#success_top_right_div_two1 p').css('color','#000000')
	    	}) 
	  

	    	$('#success_top_right_div_three1').mousemove(function(){
	    		$('#success_top_right_div_three1').css('border-top-color','blue')
	    		$('#success_top_right_div_three1 p').css('color','blue')
	    	})
	    

	    	$('#success_top_right_div_four1').mousemove(function(){
	    		$('#success_top_right_div_four1').css('border-top-color','blue')
	    		$('#success_top_right_div_four1 p').css('color','blue')
	    	}) 
	    	$('#success_top_right_div_four1').mouseout(function(){
	    		$('#success_top_right_div_four1').css('border-top-color','transparent')
	    		$('#success_top_right_div_four1 p').css('color','#000000')
	    	})

	    	$('#item1').mousemove(function(){
	    		$('#shade1').css('display','flex');
	    	})
	    	$('#item1').mouseout(function(){
	    		$('#shade1').css('display','none');
	    	})

	    	$('#item2').mousemove(function(){
	    		$('#shade2').css('display','flex');
	    		$('.success_middle_area_item_img2').css('z-index','3000000')
	    	})
	    	$('#item2').mouseout(function(){
	    		$('#shade2').css('display','none');
	    		$('.success_middle_area_item_img2').css('z-index','1100000')
	    	}) 

	    	$('#item3').mousemove(function(){
	    		$('#shade3').css('display','flex');
	    	})
	    	$('#item3').mouseout(function(){
	    		$('#shade3').css('display','none');
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

	    	$('#read1').click(function(){
	    		showAppimg()
	    		$('.new_show_img_ins').css('display','flex');
	    		// $('#app').show();
	    		return false
	    	})
	    	$('#read2').click(function(){
	    		showPanicimg();
	    		$('.new_show_img_ins').css('display','flex');
	    		// $('#app').show();
	    		return false
	    	})
	    	$('.success_middle').click(function(e){
	    		
	    		$('.new_show_img_ins').hide();
	    		// $('#app').hide();
	    	})
	    	
	}

function showAppimg(){
		var swiper=document.getElementById("new_show_img_ins");
		var appImg=['./images/instructions_02.jpg','./images/instructions_03.jpg','./images/instructions_04.jpg','./images/instructions_05.jpg','./images/instructions_06.jpg','./images/instructions_07.jpg','./images/instructions_8.jpg'] 
         //创建一个div
		for(var i=0;i<appImg.length;i++){
			// var div = document.createElement('div');
			// div.className = "swiper-slide";
			var img=document.createElement("img");
			img.src=appImg[i];
	 		img.style.width=400+"px";
			// div.appendChild(img)
			swiper.appendChild(img)
		}
	}
function showPanicimg(){
		var swiper=document.getElementById("new_show_img_ins");
		var appImg=['./images/panic_02.jpg','./images/panic_03.jpg','./images/panic_04.jpg','./images/panic_05.jpg'] 
         //创建一个div
		for(var i=0;i<appImg.length;i++){
			// var div = document.createElement('div');
			// div.className = "swiper-slide";
			var img=document.createElement("img");
			img.src=appImg[i];
	 		img.style.width=400+"px";
			// div.appendChild(img)
			swiper.appendChild(img)
		}
	}		
})()