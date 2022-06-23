import React from 'react';
import './Home.css';
import change from '../../images/icon.png';
import { BrowserRouter, Route } from 'react-router-dom';
import BaseComponent from '../BaseComponent/BaseComponent';
let Timer;
let Timer1;

export default class Home extends BaseComponent{
	constructor(props){
		super(props);
		this.state={
			get_list:[
			
			],//数据信息
			index:1,
			get_summary:{},//总览数据信息
			agreeTip:{},//交易提示
			currentTime:"",//系统当前时间
			can_use_dayoff:'',//系统使用时间
			tipTime:'',//更新于多久
		}
	};
	componentWillMount(){
		let thiz=this
		var storage=window.localStorage;

		//验证用户
		// this.getAuthUser(function(ret){
		// 	// alert("-----home-ret-----"+JSON.stringify(ret))
		// 	if(ret&&!ret.check_result){
		// 		thiz.props.history.push({pathname:'/'})
		// 	}
		// })


		if(this.props.history.location.index){
			console.log("---------------",this.props.history.location.index);
			var index=this.props.history.location.index;
			this.setState({
				index:index
			})
		}
	}
	//请求数据
	getData=(index)=>{
		let thiz=this;
		if(index==1){
		 // 假设服务端ip为127.0.0.1
			var ws = new WebSocket("ws://192.168.101.177:12315");
	        ws.onopen = function() {
	            console.log("Connection success");
	            // 发送登录信息
	            ws.send('{"code": "login"}');
	            // 发送获取数据信息
	            ws.send('{"code": "get_list","currency":"100"}');

	            // 发送获取总览数据信息
	            ws.send('{"code": "get_summary","currency":"100"}');

	            // ws.close()
	        };
	        ws.onmessage = function(e) {

	            // console.log("Connection recv msg:" + e.data);
	            console.log("----------------原来的数据长度-------",thiz.state.get_list.length);
	           	var data=JSON.parse(e.data);

	           	if(data.code=="get_list"){
	           		var index=data.data.length-1
	           		thiz.setState({
	           			get_list:data.data,
	           			agreeTip:data.data[index]
	           		})
	          
	           	}
	           	if(data.code=="get_summary"){
	           		var newTime=thiz.getDate();
	           		thiz.setState({
	           			get_summary:data.data,
	           			tipTime:newTime
	           		})
	           	}
	        };
	        ws.onclose = function(e) {
	            console.log("Connection closed.");
	        };
	        ws.onerror = function (event) {
	            console.log("Connection onerror.");
	        };
	    }  
	    if(index==2){
	    	var ws = new WebSocket("ws://192.168.101.177:12316");
	        ws.onopen = function() {
	            console.log("Connection success");
	            // 发送登录信息
	            ws.send('{"code": "login"}');
	            // 发送获取数据信息
	            ws.send('{"code": "get_list","currency":"100"}');

	            // 发送获取总览数据信息
	            ws.send('{"code": "get_summary","currency":"100"}');

	            // ws.close()
	        };
	        ws.onmessage = function(e) {

	            // console.log("Connection recv msg:" + e.data);
	            console.log("----------------原来的数据长度-------",thiz.state.get_list.length);
	           	var data=JSON.parse(e.data);

	           	if(data.code=="get_list"){
	           		var index=data.data.length-1
	           		thiz.setState({
	           			get_list:data.data,
	           			agreeTip:data.data[index]
	           		})
	           	
	           	}
	           	if(data.code=="get_summary"){
	           		var newTime=thiz.getDate();
	           		thiz.setState({
	           			get_summary:data.data,
	           			tipTime:newTime
	           		})
	           	}
	        };
	        ws.onclose = function(e) {
	            console.log("Connection closed.");
	        };
	        ws.onerror = function (event) {
	            console.log("Connection onerror.");
	        };
	    } 
	    if(index==3){
	    	var ws = new WebSocket("ws://192.168.101.177:12317");
	        ws.onopen = function() {
	            console.log("Connection success");
	            // 发送登录信息
	            ws.send('{"code": "login"}');
	            // 发送获取数据信息
	            ws.send('{"code": "get_list","currency":"100"}');

	            // 发送获取总览数据信息
	            ws.send('{"code": "get_summary","currency":"100"}');

	            // ws.close()
	        };
	        ws.onmessage = function(e) {

	            // console.log("Connection recv msg:" + e.data);
	            console.log("----------------原来的数据长度-------",thiz.state.get_list.length);
	           	var data=JSON.parse(e.data);

	           	if(data.code=="get_list"){
	           		var index=data.data.length-1
	           		thiz.setState({
	           			get_list:data.data,
	           			agreeTip:data.data[index]
	           		})
	           		
	           	}
	           	if(data.code=="get_summary"){
	           		var newTime=thiz.getDate();
	           		thiz.setState({
	           			get_summary:data.data,
	           			tipTime:newTime
	           		})
	           	}
	        };
	        ws.onclose = function(e) {
	            console.log("Connection closed.");
	        };
	        ws.onerror = function (event) {
	            console.log("Connection onerror.");
	        };
	    } 
	}
	componentDidMount(){
		let thiz=this;
		var index=thiz.state.index
		var date=this.getDate();
		
		this.setState({currentTime:date})
		this.getData(index);
		Timer=setInterval(function(){
			thiz.getData(index);
		},5000)
		Timer1=setInterval(function(){
			var newDate=thiz.getDate();
			thiz.setState({currentTime:newDate})
		},1000)
	}
	componentWillUnmount(){
		console.log("------------componentWillUnmount-----")
		clearInterval(Timer);
		clearInterval(Timer1)
	}
	//获取当前时间
	getDate=()=>{
		var date=new Date();
		var year=date.getFullYear();
		var month=date.getMonth()+1;
		if(month<10){
			month="0"+month
		}

		var day=date.getDate();
		if(day<10){
			day="0"+day
		}
		var hour=date.getHours();
		if(hour<10){
			hour="0"+hour
		}
		var minute=date.getMinutes();
		if(minute<10){
			minute="0"+minute
		}
		var second=date.getSeconds();
		if(second<10){
			second="0"+second
		}

		var curDate=year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
		return curDate;
	}
	//更多提示
	moretip=()=>{
		var index=this.state.index;
		this.props.history.push({pathname:'moretips',index:index})
	}
	//编辑设置
	goEdit=()=>{
		this.props.history.push({pathname:'loadsetting',state:"aaa"})
	}
	//k线图
	goKLine=()=>{
		var index=this.state.index;
		this.props.history.push({pathname:'klinegraph',index:index})
	}
	//软件信息
	goSoftWareInfo=()=>{
		this.props.history.push({pathname:'softwareinfo'})
	}
	//切换品种
	goChangeVarieties=()=>{
		var index=this.state.index;
		this.props.history.push({pathname:'changevarieties',index:index})
	}
	render(){
		return (
		    <div className="container5">
		      <div className="header1">
		      	<div className="top" onClick={this.goChangeVarieties}>
		      		<p className="name">{this.state.index==1?"ETH-USDT":(this.state.index==2?"EOS-USDT":"BTC-USDT")}</p>
		      		<img className="img" src={change}/>	
		      		<p className="sys-time">系统时间: {this.state.currentTime}</p>
		      	</div>
		      	<div className="ins6">
		      		<p className="ins-txt_1">时间</p>
		      		<p className="ins-txt">方向</p>
		      		<p className="ins-txt">价格</p>
		      		<p className="ins-txt">级别</p>
		      		<p className="ins-txt">金额</p>
		      	</div>
		      </div>
			  	<div className="scroll">
			  		{
			  			this.state.get_list.map((item,index)=>{
			  				return (
			  					<div className="item7" key={index}>
			  						<div className="item_1">
			  							<p className="item_1_p">{item.timedate}</p>
			  						</div>
			  						<div className="item_11">
			  							<p className="direction7" style={{color:item.type=="sell"?'green':'red'}}>{item.type=="sell"?"卖出":"买入"}</p>
			  							<img className="direction_img" src={item.type=="sell"?require('../../images/S.png'):require('../../images/B.png')} style={{display:item.level>0?'flex':'none'}}/>
			  						</div>
			  						<div className="item_11">
			  							<p className="profit">{item.price}</p>
			  						</div>
			  						<div className="item_11">
			  							<p className="varieties">{item.level}级</p>
			  						</div>
			  						<div className="item_11">
			  							<p className="price">{item.currency}</p>
			  						</div>
			  					</div>
			  				)
			  			})
			  		}
			  	</div>

		  		<div className="placeholder"></div>
		  		<div className="k_line_graph">
		  			<p>更新于: {this.state.tipTime}</p>
		  			<h1 onClick={this.goKLine}>K线图</h1>
		  			<img src={require('../../images/right.png')}/>
		  		</div>

		  		<div className="biggest">
		  			<div className="biggest_one">
		  				<p className="biggest_one_p">{this.state.get_summary.unit}</p>
		  				<p className="biggest_two_p">单元金额</p>
		  			</div>
		  			<div className="biggest_one">
		  				<p className="biggest_one_p">{this.state.get_summary.transferRate}</p>
		  				<p className="biggest_two_p">转化率</p>
		  			</div>
		  			<div className="biggest_one">
		  				<p className="biggest_one_p">{this.state.get_summary.profit}</p>
		  				<p className="biggest_two_p">总体盈利</p>
		  			</div>
		  			<div className="biggest_one">
		  				<p className="biggest_one_p">{this.state.get_summary.cprice}</p>
		  				<p className="biggest_two_p">当前价格</p>
		  			</div>
		  		</div>

		  		<div className="total">
		  			<div className="total_1">
		  				<p className="total_1p">总单数</p>
		  				<p className="total_2p">{this.state.get_summary.orderCount}</p>
		  			</div>
		  			<div className="total_1">
		  				<p className="total_3p">多单</p>
		  				<p className="total_4p">{this.state.get_summary.orderBuyCount}</p>
		  			</div>
		  			<div className="total_1">
		  				<p className="total_5p">空单</p>
		  				<p className="total_6p">{this.state.get_summary.orderSellCount}</p>
		  			</div>
		  		</div>

		  		<div className="dir">
		  			<p className="dir_1p">方向</p>
		  			<p className="dir_2p">{this.state.get_summary.summary}</p>
		  		</div>

		  		<div className="placeholder"></div>

		  		<div className="tip">
		  			<p className="tip_p">交易提示</p>
		  			<p className="tip_2p" onClick={this.moretip}>更多</p>
		  			<img src={require('../../images/yeright.png')} onClick={this.moretip}/>
		  		</div>
		  		<div className="tip_ins">
		  			<p className="tip_ins_1p">{this.state.agreeTip.timedate}</p>
		  			<p className="tip_ins_2p">{this.state.agreeTip.price}</p>
		  			<p className="tip_ins_3p">{this.state.agreeTip.level}级</p>
		  			<p className="tip_ins_4p" style={{color:this.state.agreeTip.type=="sell"?'green':'red'}}>{this.state.agreeTip.type=="sell"?"卖出":"买入"}</p>
		  		</div>

		  		<div className="placeholder"></div>

		  		<div className="short_set">
		  			<p className="short_set_p">做空设置</p>
		  			<p className="short_set_2p" onClick={this.goEdit}>载入</p>
		  			<img src={require('../../images/bright.png')}/>
		  		</div>
		  		<div className="short_set_ins">
		  			<p className="short_set_ins_1p">300.00元</p>
		  			<p className="short_set_ins_2p">2级</p>
		  		</div>
		  		<div className="short_set_ins">
		  			<p className="short_set_ins_1p">±30点</p>
		  			<p className="short_set_ins_2p">±50%</p>
		  		</div>

		  		<div className="placeholder"></div>

		  		<div className="software_information">
		  			<div className="software_information_ins" onClick={this.goSoftWareInfo}>
		  				<p>软件信息</p>
		  			</div>
		  		</div>

		    </div>
  		);
	}
};