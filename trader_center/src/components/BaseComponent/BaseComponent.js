import React from 'react';
import $ from  'jquery';
export default class BaseComponent extends React.Component{
	constructor(props){
		super(props)
	}
	//验证用户
	getAuthUser=(callback)=>{
		let thiz=this;
		var storage=window.localStorage;
  		var code=storage.getItem("code");
  		var uid=storage.getItem("uid");
  		console.log("------Base_code------",code)
  		console.log("------Base_uid------",uid)
		if(uid){
			$.ajax( {  
		      url:'http://tchecker.coopcoder.com/Checker/authUser', 
		      data:{  
		        "mac":uid,
				"lastRegisterCode":"RSJEACVFTMRMJHUC",
				"uid":uid,
				"pm":uid
		    	},  
		    type:'post',  
		    dataType:'json',  
		    success:function(data) {  

	       		if(callback){
	       			callback(data)
	       		}
		    },  
		    error : function(err) {  
		        console.log("-----------验证err-----",err)
		    }  
		 });

  		}else{
  			thiz.props.history.push({pathname:'/'})
  		}
	}

	//返回上一个界面
	goBack=()=>{
		this.props.history.goBack();
	}
}