import React from 'react';
import './Start.css';
import $ from  'jquery';
import {HashRouter, BrowserRouter,Route,Redirect,Switch,Link,NavLink} from 'react-router-dom';
import Home from '../Home/Home';
import BaseComponent from '../BaseComponent/BaseComponent';


export default class Start extends BaseComponent{
	constructor(props){
		super(props);
		this.state={

		}
	} 
	componentWillMount(){
		let thiz=this;
  		var storage=window.localStorage;
  		var uid=navigator.userAgent;
		uid = 'WEB_CLIENT_001'
  		storage.setItem("uid",uid);
  		var code=storage.getItem("code");
  		var uid=storage.getItem("uid");

  		console.log("------start-code--------",code);
  		console.log("-------start--uid---------",uid);
  		if(uid){
  			 $.ajax( {  
		      url:'http://192.168.101.177:19005/Checker/authUser', 
		      data:{  
		        "mac":uid,
      			"lastRegisterCode":"ISZJCOQCKSIXWLXK",
      			"uid":uid,
      			"pm":uid
		      },  
		     type:'post',  
		     dataType:'json',  
		     success:function(data) {  
		       console.log("-----start-data------",data);
		       if(data&&data.check_result){
		       	thiz.props.history.push({pathname:'home'})
		       }
		      },  
		      error : function(err) {  
		        console.log("-----------验证err-----",err)
		      }  
		 });

  		}
	}
	componentDidMount(){

	}

	//使用激活码
	start=()=>{
		let thiz=this;
		var storage=window.localStorage;
		var uid=navigator.userAgent;
		uid = 'WEB_CLIENT_001'
		var code=document.getElementById("input").value;
		$.ajax({
			url:"http://192.168.101.177:19005/Checker/registerCodeUser",
			data:{  
		        "mac":uid,
      			"registerCode":"ISZJCOQCKSIXWLXK",
      			"uid":uid,
      			"pm":uid
		    },
		    type:'post',
		    dataType:"json",
		    success:function(data){
		    	console.log("--------data-----------",data)
		    	if(data&&data.ret_code=="1000"){
		    		storage.setItem("code",code);
		    		storage.setItem("uid",uid);
		    		thiz.props.history.push({pathname:'home'})
		    	}else{
		    		if(data&&data.error_msg){
		    			alert(data.error_msg)
		    		}
		    	}
		    },
		    error :function(err){
		    	console.log("-----------err------",err)
		    }
		})
		
	}
	//判断手机端还是PC端
	browserRedirect=()=>{
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

	render(){
		return(
			<div className="container4">
				<div className="welcome_use">
					<p>欢迎使用上上策</p>
				</div>
				<div className="welcome_use_ins">
					<p>使用前请先输入激活码</p>
				</div>
				<div className="code">
					<input placeholder="激活码" id="input"/>
				</div>
				<div className="start_use_btn" onClick={this.start}>
					<p>开始使用</p>
				</div>
				<img src={require('../../images/shangshangce.png')}/>
				<p className="company_name">By成达传网络科技</p>
			</div>
		)
	}
}