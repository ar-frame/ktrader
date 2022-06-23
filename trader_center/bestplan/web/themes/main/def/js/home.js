(function(){
		 function placeholderPic(){
			  var desW=1920; 
			  var w = document.documentElement.clientWidth;
			  var n=w/desW;
			  document.documentElement.style.fontSize=n*300+'px';
		}
		//判断手机端还是PC端
		function browserRedirect() {
            var sUserAgent = navigator.userAgent.toLowerCase();
            var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
            var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
            var bIsMidp = sUserAgent.match(/midp/i) == "midp";
            var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
            var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
            var bIsAndroid = sUserAgent.match(/android/i) == "android";
            var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
            var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";

            if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
                return 'phone';
            } else {
                return 'pc'
            }
        }

	
	    $(window).on('resize', function() {
	    	var newType=browserRedirect()
	    	if(newType=='pc'){
	        	var winW = $(window).width();
	        	$('.banner').width($(window).width());
	        	$('.container').width($(window).width());
				$('.banner').height($(window).height());
				$('.container').height($(window).height());
				// console.log("------------浏览器高-------",$(window).height());
		        placeholderPic();
		    }
    	});
	    window.onload=function(){
		    	//监听滚轮向上还是向下
		    	placeholderPic();//控制浏览器字体大小
		    	var type=browserRedirect();//判断是手机端还是电脑端
		    	$('html, body').animate({  
				 	 scrollTop: $(".header").offset().top  
				},100);//防止刷新页面时出现的bug
		    	var isScroll=false;
		    	var index=0;//
	    		$('.banner').show();
				$('.price').hide();
				$('.success_cases').hide();
				
				
				//判断鼠标滚轮方向
			// 	if(type=="pc"){
			// 		$(document).on("mousewheel DOMMouseScroll", function (e) {
			//         var delta = (e.originalEvent.wheelDelta && (e.originalEvent.wheelDelta > 0 ? 1 : -1)) ||  // chrome & ie
			//                 (e.originalEvent.detail && (e.originalEvent.detail > 0 ? -1 : 1));              // firefox
			//                 console.log("-------------isScroll----------",isScroll);
			//                 $('.contact_left').css('display','none')
			//                 if(isScroll){
			//                 	return
			//                 };
			//         if (delta > 0) {
			//             // 向上滚
			            
			//             if(index==1){
		 //            		$('html, body').animate({  
			// 				 	 scrollTop: $(".header").offset().top  
			// 				}, 1000);
		 //           			console.log("wheelup",index);
		 //           			$('.dots_one').css('background-color','#005AFF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			index--;
		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           			console.log("-------------NewIsScroll--------",isScroll);
			//             	return
			//             }
			        
			//            if(index==2){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".ai_smart").offset().top  
			// 				}, 1000);
			// 				console.log("wheelup",index);
			// 				index--;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#005AFF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdown=NewaipicArr.length;
		 //           			settime();
		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           				console.log("-------------NewIsScroll--------",isScroll);
			// 				return;
			//            }
			//            if(index==3){
			// 	           	$('html, body').animate({  
			// 					 scrollTop: $(".big_data_model").offset().top  
			// 				}, 1000); 
			// 				console.log("wheelup",index); 
			// 				index--;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#005AFF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdownMin=minArr.length;
	  //      					setMin()

		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           				console.log("-------------NewIsScroll--------",isScroll);
			//            		return ;
			//            }
			           
			      
			//         } else if (delta < 0) {
			//             // 向下滚
			            
			//             if(index==2){
			//             	$('html, body').animate({  
			// 					 scrollTop: $(".advanced_technology").offset().top  
			// 				}, 1000); 
			// 				 console.log("wheeldown",index);
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#005AFF')
		 //           			index++;
		 //           			countdownRed=redArr.length;
		 //           			setRedImg()
	  //      					setGreenImg()
	  //      					isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           				console.log("-------------NewIsScroll--------",isScroll);
			//             	return;
			//             }
			//            if(index==1){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".big_data_model").offset().top  
			// 				}, 1000);
			// 				 console.log("wheeldown",index);
			// 				 index++;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#005AFF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdownMin=minArr.length;
	  //      					setMin()

		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           				console.log("-------------NewIsScroll--------",isScroll);
			// 				return ;
			//            }
			//            if(index==0){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".ai_smart").offset().top  
			// 				}, 1000);
			// 				 console.log("wheeldown",index);
			// 				 index++;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#005AFF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdown=NewaipicArr.length;
		 //           			settime();
		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           			},1000)
		 //           			console.log("-------------NewIsScroll--------",isScroll);
			// 				return ;
			//            }
			           
			          
			            
			//         }
	  //   		});
			// }

   //  		var p=0,t=0;  

   //  		if(type=="phone"){
			// 	$(window).scroll(function(e) {
			// 		console.log("--------开始滚动------")
			// 	    p = $(this).scrollTop();
			// 	    if(isScroll){
	  //               	return
	  //               };
			// 	    if (t < p) {
			// 	      //向下滚
			// 	       if(index==2){
			//             	$('html, body').animate({  
			// 					 scrollTop: $(".advanced_technology").offset().top  
			// 				}, 1000); 
			// 				 console.log("wheeldown",index);
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#005AFF')
		 //           			// index++;
		 //           // 			countdownRed=redArr.length;
		 //           // 			setRedImg()
	  //      					// setGreenImg()
	  //      					isScroll=true;
	  //      					console.log("--------滚动中--------");
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           				index++;
		 //           			},1000)
		           			
			//             	return;
			//             }
			//            if(index==1){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".big_data_model").offset().top  
			// 				}, 1000);
			// 				 console.log("wheeldown",index);
			// 				 // index++;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#005AFF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           // 			countdownMin=minArr.length;
	  //      					// setMin()
	  //      					console.log("--------滚动中--------");
		 //           			isScroll=true;
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           					index++;
		 //           			},1000)
		           				
			// 				return ;
			//            }
			//            if(index==0){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".ai_smart").offset().top  
			// 				}, 1000);
			// 				 console.log("wheeldown",index);
			// 				 // index++;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#005AFF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdown=NewaipicArr.length;
		 //           			settime();
		 //           			isScroll=true;
		 //           			console.log("--------滚动中--------");
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           					index++;
		 //           			},1000)
		           		
			// 				return ;
			//            }
			// 	    } else if(t>p) {
			// 	      //向上滚
			            
			//             if(index==1){
		 //            		$('html, body').animate({  
			// 				 	 scrollTop: $(".header").offset().top  
			// 				}, 1000);
		 //           			console.log("wheelup",index);
		 //           			$('.dots_one').css('background-color','#005AFF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			index--;
		 //           			isScroll=true;
		 //           			console.log("--------滚动中--------");
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           			},1000)
		 //           			console.log("-------------NewIsScroll--------",isScroll);
			//             	return
			//             }
			        
			//            if(index==2){
			//            		$('html, body').animate({  
			// 					  scrollTop: $(".ai_smart").offset().top  
			// 				}, 1000);
			// 				console.log("wheelup",index);
			// 				index--;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#005AFF')
		 //           			$('.dots_three').css('background-color','#ADC7FF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           			countdown=NewaipicArr.length;
		 //           			settime();
		 //           			isScroll=true;
		 //           			console.log("--------滚动中--------");
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           			},1000)
		           				
			// 				return;
			//            }
			//            if(index==3){
			// 	           	$('html, body').animate({  
			// 					 scrollTop: $(".big_data_model").offset().top  
			// 				}, 1000); 
			// 				console.log("wheelup",index); 
			// 				index--;
			// 				$('.dots_one').css('background-color','#ADC7FF')
		 //           			$('.dots_two').css('background-color','#ADC7FF')
		 //           			$('.dots_three').css('background-color','#005AFF')
		 //           			$('.dots_four').css('background-color','#ADC7FF')
		 //           // 			countdownMin=minArr.length;
	  //      					// setMin()

		 //           			isScroll=true;
		 //           			console.log("--------滚动中--------");
		 //           			setTimeout(function(){
		 //           				isScroll=false;
		 //           				console.log("------停止滚动------")
		 //           			},1000)
		           				
			//            		return ;
			//         	}
			// 	    }  
			// 	    setTimeout(function() {
			// 	      t = p;
			// 	    }, 1100);
			// 	 });
			// }

		
	    	//顶部导航栏监听鼠标划入

	    	$('#top_right_div_one1').mousemove(function(){
	    		$('#top_right_div_one1').css('border-top-color','blue')
	    		$('#top_right_div_one1 p').css('color','blue')
	    	}) 

	    	$('#top_right_div_two1').mousemove(function(){
	    		$('#top_right_div_two1').css('border-top-color','blue')
	    		$('#top_right_div_two1 p').css('color','blue')
	    	}) 
	    	$('#top_right_div_two1').mouseout(function(){
	    		$('#top_right_div_two1').css('border-top-color','transparent')
	    		$('#top_right_div_two1 p').css('color','#000000')
	    	})

	    	$('#top_right_div_three1').mousemove(function(){
	    		$('#top_right_div_three1').css('border-top-color','blue')
	    		$('#top_right_div_three1 p').css('color','blue')
	    	}) 
	    	$('#top_right_div_three1').mouseout(function(){
	    		$('#top_right_div_three1').css('border-top-color','transparent')
	    		$('#top_right_div_three1 p').css('color','#000000')
	    	})

	    	$('#top_right_div_four1').mousemove(function(){
	    		$('#top_right_div_four1').css('border-top-color','blue')
	    		$('#top_right_div_four1 p').css('color','blue')
	    	}) 
	    	$('#top_right_div_four1').mouseout(function(){
	    		$('#top_right_div_four1').css('border-top-color','transparent')
	    		$('#top_right_div_four1 p').css('color','#000000')
	    	})

			$('#top_right_div_five1').mousemove(function(){
                $('#top_right_div_five1').css('border-top-color','blue')
                $('#top_right_div_five1 p').css('color','blue')
            })
            $('#top_right_div_five1').mouseout(function(){
                $('#top_right_div_five1').css('border-top-color','transparent')
                $('#top_right_div_five1 p').css('color','#000000')
            })

	    	$('.kefu').mousemove(function(){
	    		$('.kefu').css('background-color','#2975ff')
	    	})
	    	$('.kefu').mouseout(function(){
	    		$('.kefu').css('background-color','#005AFF')
	    	})


	    	$('#footer_1p').mousemove(function(){
	    		$('#footer_1p').css('color','#8383A0')
	    	})
	    	$('#footer_1p').mouseout(function(){
	    		$('#footer_1p').css('color','white')
	    	})
	    	$('#footer_2p').mousemove(function(){
	    		$('#footer_2p').css('color','#8383A0')
	    	})
	    	$('#footer_2p').mouseout(function(){
	    		$('#footer_3p').css('color','white')
	    	})
	    	$('#footer_3p').mousemove(function(){
	    		$('#footer_3p').css('color','#8383A0')
	    	})
	    	$('#footer_3p').mouseout(function(){
	    		$('#footer_3p').css('color','white')
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
	    		$('.contact').css('z-index','100000000000')
	    		$('#wx').attr('src','{{C.PATH.PUBLIC}}images/wx.png')
	    	})
	    	$('#wx').mouseout(function(){
	    		$('.contact_left').css('display','none')
	    		$('.contact').css('z-index','1000000')
	    		$('#wx').attr('src','{{C.PATH.PUBLIC}}images/wx-1.png')
	    	})
	    	$('#kefu').mousemove(function(){
	    		$('.kefu_phone').css('display','flex')
	    		$('.contact').css('z-index','100000000000')
	    		$('#kefu').attr('src','{{C.PATH.PUBLIC}}images/kefu1.png')
	    		$('.contact_left').css('display','none')
	    	})
	    	$('#kefu').mouseout(function(){
	    		$('.kefu_phone').css('display','none')
	    		$('.contact').css('z-index','1000000')
	    		$('#kefu').attr('src','{{C.PATH.PUBLIC}}images/kefu.png')
	    	})

	    	//点击事件
	    	$('#backToTop').click(function(){
	    		$('html, body').animate({  
				 	 scrollTop: $(".header").offset().top  
				}, 1000);
	    	})
	    	$('.kefu').click(function(){
	    		$('.contact_left').css('display','flex')
	    		$('.contact').css('z-index','100000000000')
	    		$('.kefu_modal').css('display','flex')
	    		setTimeout(function(){
	    			$('.kefu_modal').css('display','none')
	    		},3000)
	    		// alert("请扫描右侧微信客服二维码,获得一对一专业服务")
	    	})
	    	
	    	$('#top_right_div_two').click(function(){
	    		window.location.href='{{\ar\core\url('price')}}';
	    	})
    	 	$('#top_right_div_three').click(function(){
	    		window.location.href="{{\ar\core\url('readhelp')}}";
	    	})
	    	$('#top_right_div_four').click(function(){
	    		window.location.href="{{\ar\core\url('download')}}";
	    	})
			$('#top_right_div_five').click(function(){
				window.location.href="{{\ar\core\url('shares')}}";
			})
	 

	    	//小圆点导航点击事件
	    	$('#top_img').click(function(){
	    		window.location.href="{{\ar\core\url('home')}}";
	    	})
	    	$('.dots_one').click(function(){
	    		index=0;
	    		$('html, body').animate({  
						 	 scrollTop: $(".header").offset().top  
						}, 1000);
       			$('.dots_one').css('background-color','#005AFF')
       			$('.dots_two').css('background-color','#ADC7FF')
       			$('.dots_three').css('background-color','#ADC7FF')
       			$('.dots_four').css('background-color','#ADC7FF')
	    	})
	    	$('.dots_two').click(function(event){
	    		index=1;
	    		$('html, body').animate({
							  scrollTop: $(".ai_smart").offset().top
						}, 1000);
				$('.dots_one').css('background-color','#ADC7FF')
       			$('.dots_two').css('background-color','#005AFF')
       			$('.dots_three').css('background-color','#ADC7FF')
       			$('.dots_four').css('background-color','#ADC7FF')
       			countdown=NewaipicArr.length;
       			settime();
	    	})
	    	$('.dots_three').click(function(){
	    		index=2;
		   		$('html, body').animate({  
					  scrollTop: $(".big_data_model").offset().top  
				}, 1000);
				$('.dots_one').css('background-color','#ADC7FF')
       			$('.dots_two').css('background-color','#ADC7FF')
       			$('.dots_three').css('background-color','#005AFF')
       			$('.dots_four').css('background-color','#ADC7FF')
       			if(type=='pc'){
       				countdownMin=minArr.length;
       				setMin()
       			}	
       			
	    	})
	    	$('.dots_four').click(function(){
	    		index=3;
	    		$('html, body').animate({  
							 scrollTop: $(".advanced_technology").offset().top  
						}, 1000); 
				$('.dots_one').css('background-color','#ADC7FF')
       			$('.dots_two').css('background-color','#ADC7FF')
       			$('.dots_three').css('background-color','#ADC7FF')
       			$('.dots_four').css('background-color','#005AFF')
       			if(type=='pc'){
	       			countdownRed=redArr.length;
	       			setRedImg()
	       			setGreenImg()
	       		}
	    	})

	    	if(type=="pc"){
	    		$('#header_bottom').height($(window).height()*0.92);
	        	$('.container').height($(window).height()).width($(window).width());
	        	$('.banner').height($(window).height()).width($(window).width());
        		setInterval(function(){
					countdown=NewaipicArr.length;
		           	settime();
		           	countdownRed=redArr.length;
		           	setRedImg()
	       			setGreenImg()
	       			countdownMin=minArr.length;
       				setMin()
				},5000)
	    	}
	    
        	
 			

 			//ai动画
 			var NewaipicArr=['{{C.PATH.PUBLIC}}images/ai_29.png','{{C.PATH.PUBLIC}}images/ai_28.png','{{C.PATH.PUBLIC}}images/ai_27.png','{{C.PATH.PUBLIC}}images/ai_26.png','{{C.PATH.PUBLIC}}images/ai_25.png','{{C.PATH.PUBLIC}}images/ai_24.png','{{C.PATH.PUBLIC}}images/ai_23.png','{{C.PATH.PUBLIC}}images/ai_22.png','{{C.PATH.PUBLIC}}images/ai_21.png','{{C.PATH.PUBLIC}}images/ai_20.png','{{C.PATH.PUBLIC}}images/ai_19.png','{{C.PATH.PUBLIC}}images/ai_18.png','{{C.PATH.PUBLIC}}images/ai_17.png','{{C.PATH.PUBLIC}}images/ai_16.png','{{C.PATH.PUBLIC}}images/ai_15.png','{{C.PATH.PUBLIC}}images/ai_14.png','{{C.PATH.PUBLIC}}images/ai_13.png','{{C.PATH.PUBLIC}}images/ai_12.png','{{C.PATH.PUBLIC}}images/ai_11.png','{{C.PATH.PUBLIC}}images/ai_10.png','{{C.PATH.PUBLIC}}images/ai_9.png','{{C.PATH.PUBLIC}}images/ai_8.png','{{C.PATH.PUBLIC}}images/ai_7.png','{{C.PATH.PUBLIC}}images/ai_6.png','{{C.PATH.PUBLIC}}images/ai_5.png','{{C.PATH.PUBLIC}}images/ai_4.png','{{C.PATH.PUBLIC}}images/ai_3.png','{{C.PATH.PUBLIC}}images/ai_2.png','{{C.PATH.PUBLIC}}images/ai_1.png'];

 			var redArr=['{{C.PATH.PUBLIC}}images/red1_00029.png','{{C.PATH.PUBLIC}}images/red1_00028.png','{{C.PATH.PUBLIC}}images/red1_00027.png','{{C.PATH.PUBLIC}}images/red1_00026.png','{{C.PATH.PUBLIC}}images/red1_00025.png','{{C.PATH.PUBLIC}}images/red1_00024.png','{{C.PATH.PUBLIC}}images/red1_00023.png','{{C.PATH.PUBLIC}}images/red1_00022.png','{{C.PATH.PUBLIC}}images/red1_00021.png','{{C.PATH.PUBLIC}}images/red1_00020.png','{{C.PATH.PUBLIC}}images/red1_00019.png','{{C.PATH.PUBLIC}}images/red1_00018.png','{{C.PATH.PUBLIC}}images/red1_00028.png','{{C.PATH.PUBLIC}}images/red1_00028.png','{{C.PATH.PUBLIC}}images/red1_00017.png','{{C.PATH.PUBLIC}}images/red1_00016.png','{{C.PATH.PUBLIC}}images/red1_00015.png','{{C.PATH.PUBLIC}}images/red1_00014.png','{{C.PATH.PUBLIC}}images/red1_00013.png','{{C.PATH.PUBLIC}}images/red1_00012.png','{{C.PATH.PUBLIC}}images/red1_00011.png','{{C.PATH.PUBLIC}}images/red1_00010.png','{{C.PATH.PUBLIC}}images/red1_00009.png','{{C.PATH.PUBLIC}}images/red1_00008.png','{{C.PATH.PUBLIC}}images/red1_00007.png','{{C.PATH.PUBLIC}}images/red1_00006.png','{{C.PATH.PUBLIC}}images/red1_00005.png','{{C.PATH.PUBLIC}}images/red1_00004.png','{{C.PATH.PUBLIC}}images/red1_00003.png','{{C.PATH.PUBLIC}}images/red1_00002.png','{{C.PATH.PUBLIC}}images/red1_00001.png','{{C.PATH.PUBLIC}}images/red1_00000.png']

 			var greenArr=['{{C.PATH.PUBLIC}}images/green2_00029.png','{{C.PATH.PUBLIC}}images/green2_00028.png','{{C.PATH.PUBLIC}}images/green2_00027.png','{{C.PATH.PUBLIC}}images/green2_00026.png','{{C.PATH.PUBLIC}}images/green2_00025.png','{{C.PATH.PUBLIC}}images/green2_00024.png','{{C.PATH.PUBLIC}}images/green2_00023.png','{{C.PATH.PUBLIC}}images/green2_00022.png','{{C.PATH.PUBLIC}}images/green2_00021.png','{{C.PATH.PUBLIC}}images/green2_00020.png','{{C.PATH.PUBLIC}}images/green2_00019.png','{{C.PATH.PUBLIC}}images/green2_00018.png','{{C.PATH.PUBLIC}}images/green2_00028.png','{{C.PATH.PUBLIC}}images/green2_00028.png','{{C.PATH.PUBLIC}}images/green2_00017.png','{{C.PATH.PUBLIC}}images/green2_00016.png','{{C.PATH.PUBLIC}}images/green2_00015.png','{{C.PATH.PUBLIC}}images/green2_00014.png','{{C.PATH.PUBLIC}}images/green2_00013.png','{{C.PATH.PUBLIC}}images/green2_00012.png','{{C.PATH.PUBLIC}}images/green2_00011.png','{{C.PATH.PUBLIC}}images/green2_00010.png','{{C.PATH.PUBLIC}}images/green2_00009.png','{{C.PATH.PUBLIC}}images/green2_00008.png','{{C.PATH.PUBLIC}}images/green2_00007.png','{{C.PATH.PUBLIC}}images/green2_00006.png','{{C.PATH.PUBLIC}}images/green2_00005.png','{{C.PATH.PUBLIC}}images/green2_00004.png','{{C.PATH.PUBLIC}}images/green2_00003.png','{{C.PATH.PUBLIC}}images/green2_00002.png','{{C.PATH.PUBLIC}}images/green2_00001.png','{{C.PATH.PUBLIC}}images/green2_00000.png']
	 		
	 		var	minArr=['{{C.PATH.PUBLIC}}images/1_00044-min.png','{{C.PATH.PUBLIC}}images/1_00043-min.png','{{C.PATH.PUBLIC}}images/1_00042-min.png','{{C.PATH.PUBLIC}}images/1_00041-min.png','{{C.PATH.PUBLIC}}images/1_00040-min.png','{{C.PATH.PUBLIC}}images/1_00039-min.png','{{C.PATH.PUBLIC}}images/1_00038-min.png','{{C.PATH.PUBLIC}}images/1_00037-min.png','{{C.PATH.PUBLIC}}images/1_00036-min.png','{{C.PATH.PUBLIC}}images/1_00035-min.png','{{C.PATH.PUBLIC}}images/1_00034-min.png','{{C.PATH.PUBLIC}}images/1_00033-min.png','{{C.PATH.PUBLIC}}images/1_00032-min.png','{{C.PATH.PUBLIC}}images/1_00031-min.png','{{C.PATH.PUBLIC}}images/1_00030-min.png','{{C.PATH.PUBLIC}}images/1_00029-min.png','{{C.PATH.PUBLIC}}images/1_00028-min.png','{{C.PATH.PUBLIC}}images/1_00027-min.png','{{C.PATH.PUBLIC}}images/1_00026-min.png','{{C.PATH.PUBLIC}}images/1_00025-min.png','{{C.PATH.PUBLIC}}images/1_00024-min.png','{{C.PATH.PUBLIC}}images/1_00023-min.png','{{C.PATH.PUBLIC}}images/1_00022-min.png','{{C.PATH.PUBLIC}}images/1_00021-min.png','{{C.PATH.PUBLIC}}images/1_00019-min.png','{{C.PATH.PUBLIC}}images/1_00018-min.png','{{C.PATH.PUBLIC}}images/1_00017-min.png','{{C.PATH.PUBLIC}}images/1_00016-min.png','{{C.PATH.PUBLIC}}images/1_00015-min.png','{{C.PATH.PUBLIC}}images/1_00014-min.png','{{C.PATH.PUBLIC}}images/1_00013-min.png','{{C.PATH.PUBLIC}}images/1_00012-min.png','{{C.PATH.PUBLIC}}images/1_00011-min.png','{{C.PATH.PUBLIC}}images/1_00010-min.png','{{C.PATH.PUBLIC}}images/1_00009-min.png','{{C.PATH.PUBLIC}}images/1_00008-min.png','{{C.PATH.PUBLIC}}images/1_00007-min.png','{{C.PATH.PUBLIC}}images/1_00006-min.png','{{C.PATH.PUBLIC}}images/1_00005-min.png','{{C.PATH.PUBLIC}}images/1_00004-min.png','{{C.PATH.PUBLIC}}images/1_00003-min.png','{{C.PATH.PUBLIC}}images/1_00002-min.png','{{C.PATH.PUBLIC}}images/1_00001-min.png','{{C.PATH.PUBLIC}}images/1_00000-min.png']

	 		if(type=="phone"){
	    		$('#header_bottom').height($(window).width()*0.92);
	        	$('.container').height($(window).width()*2/3).width($(window).width());
	        	$('.banner').height($(window).width()*2/3).width($(window).width());
	        	$('.ai_img').attr('src',NewaipicArr[0]);
	    	}
	           var countdown=NewaipicArr.length;
	           var countdownRed=redArr.length;
	           var countdownMin=minArr.length;
	           
			   function settime() {
			        if (countdown == 0) {
			           $('.ai_img').attr('src',NewaipicArr[0]);
			            
			        } else {
			            $('.ai_img').attr('src',NewaipicArr[countdown]);
			            countdown--;
			            setTimeout(function() {
			                settime()
			            },100)
			        }
	       		}

			   function setMin() {
			        if (countdownMin == 0) {
			           $('.min').attr('src',minArr[0]);
			            
			        } else {
			            $('.min').attr('src',minArr[countdownMin]);
			            countdownMin--;
			            setTimeout(function() {
			                setMin()
			            },100)
			        }
	       		}
	       		function setRedImg() {
			        if (countdownRed == 0) {
			           $('.red_img').attr('src',redArr[0]);
			            // console.log("-----------",redArr[0])
			        } else {
			            $('.red_img').attr('src',redArr[countdownRed]);
			            
			            countdownRed--;
			            setTimeout(function() {
			                setRedImg()
			            },1000)
			        }
	       		}
	       		function setGreenImg() {
			        if (countdownRed == 0) {
			           $('.green_img').attr('src',greenArr[0]);
			            
			        } else {
			            $('.green_img').attr('src',greenArr[countdownRed]);
			            countdownRed--;
			            setTimeout(function() {
			                setGreenImg()
			            },1000)
			        }
	       		}	
        }
})()	