import React from 'react';
import './SoftwareInfo.css';
import BaseComponent from '../BaseComponent/BaseComponent';
import $ from  'jquery';

export default class SoftwareInfo extends BaseComponent{
	constructor(props){
		super(props);
		this.state={
			can_use_dayoff:'',//剩余使用天数
			service_call:'',//服务电话
			service_info:'',//服务消息
			version_name:'',//版本信息
		}
	}
	componentWillMount(){
		let thiz=this;
		$('html,body').animate({scrollTop:0},100);//回到顶端
		this.getAuthUser(function(ret){
			console.log("-----softq-ret-----",ret)
			if(ret&&!ret.check_result){
				thiz.props.history.push({pathname:'/'})
			}else{
				var can_use_dayoff=ret.can_use_dayoff;
				var service_call=ret.service_call;
				var service_info=ret.service_info;
				var version_name=ret.version_name
				thiz.setState({
					can_use_dayoff:can_use_dayoff,
					service_info:service_info,
					service_call:service_call,
					version_name:version_name
				})
			}
		})
	}
	//获取激活码信息
	getMessage=()=>{
		var storage=window.localStorage;
		var code=document.getElementById("soft_input").value;
		var uid=storage.getItem("uid");
		$.ajax({
			url:"http://tchecker.coopcoder.com/Checker/authUser",
			data:{  
		        "mac":uid,
      			"lastRegisterCode":code,
      			"uid":uid,
      			"pm":uid
		    },
		    type:'post',  
		    dataType:'json', 
		    success:function(res){
		    	console.log("---------res-------",res);
		    	if(res&&res.check_result){
		       		alert("使用时间:"+res.can_use_dayoff+"天"+"\n"+"客服电话:"+res.service_call+"\n"+"服务信息:"+res.service_info+'\n'+"版本信息:"+res.version_name)
		       	}else{
		       		alert(res.err_msg)
		       	}
		    },
		    error:function(err){

		    }  
		})
	}

	render(){
		return(
			<div className="container1" ref="top">
				<div className="back" onClick={this.goBack}>
					<img src={require('../../images/back1.png')}/>
				</div>

				<div className="shangshangce">
					<img src={require('../../images/shangshangce.png')}/>
					<div className="shangshangce_name">
						<text className="shangshangce_name_p">上上策</text>
						<text className="shangshangce_name_2p">the best plan</text>
					</div>
				</div>

				<div className="bottom">
					<div className="update_log">
						<p>更新日志</p>
						<img src={require('../../images/cright.png')}/>
					</div>
					<p className="bottom_1p">{this.state.can_use_dayoff?this.state.can_use_dayoff:'0'}</p>
					<p className="bottom_2p">可使用剩余天数</p>
					<div className="code">
						<input placeholder="激活码" id="soft_input"/>
						<p onClick={this.getMessage}>确认</p>
					</div>
					<p className="kefu">客服电话：{this.state.service_call}</p>
					<p className="info">{this.state.service_info}</p>
					<p className="info">版本信息:  {this.state.version_name}</p>
					<p style={{fontSize:'12px'}}>本版本为试用版本，请前往<a href="http://www.who24h.com/" style={{fontSize:'20px',color:'blue',textDecoration:'none'}}>上上策官网 </a> 下载App体验完整功能。</p>
				</div>
			</div>
		)
	}
}