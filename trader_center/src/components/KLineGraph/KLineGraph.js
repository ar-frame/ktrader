import React from 'react';
import './KlineGraph.css';
import $ from 'jquery';
// import data from '../../k.json';
import echarts from 'echarts/lib/echarts'
//导入折线图
import 'echarts/lib/chart/line';  //折线图是line,饼图改为pie,柱形图改为bar
import 'echarts/lib/component/tooltip';
import 'echarts/lib/component/title';
import 'echarts/lib/component/legend';
import 'echarts/lib/component/markPoint';
import ReactEcharts from 'echarts-for-react';

export default class KLineGraph extends React.Component{
	constructor(props){
		super(props);
    this.state={
      data:[],
    }
	}
  componentWillMount(){
    var thiz=this;
    var index=1;
    var type=thiz.browserRedirect();
    if(type=="phone"){
      $('body').css('transform','rotate(90deg)');
    }
    if(this.props.history.location.index){
      console.log("-----------KLineGraph----",this.props.history.location.index);
      index=this.props.history.location.index;
    }
    if(index==1){
       var ws = new WebSocket("ws://192.168.101.177:12315");
    }
    if(index==2){
       var ws = new WebSocket("ws://192.168.101.177:12316");
    }
    if(index==3){
       var ws = new WebSocket("ws://192.168.101.177:12317");
    }
     // 假设服务端ip为127.0.0.1
     
      ws.onopen = function() {
          console.log("Connection success");
          // 发送登录信息
          // ws.send('{"code": "login"}');
          // 发送获取数据信息
          ws.send('{"code": "get_list"}');

          // 发送获取总览数据信息
          // ws.send('{"code": "get_summary"}');

          // ws.close()
      };
      ws.onmessage = function(e) {

        // console.log("Connection recv msg:" + e.data);
        var data=JSON.parse(e.data);
      
        thiz.setState({
          data:data.data,
        })  
      };
      ws.onclose = function(e) {
          console.log("Connection closed.");
      };
      ws.onerror = function (event) {
          console.log("Connection onerror.");
      };
  }

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

  getOption=()=>{
    var get_list=this.state.data;

    var price=[];
    var sellCode=[];
    var buyCode=[];
    var timedate=[];
    var level=[];
    for(var i=0;i<get_list.length;i++){
      // if(i==12){
      //   break;
      // }
      price.push(get_list[i].price);
      timedate.push(get_list[i].timedate);
      level.push(get_list[i].level);
      if(get_list[i].type=='sell'){
        sellCode.push(get_list[i].code)
      }else{
        sellCode.push('')
      }

      if(get_list[i].type=='buy'){
        buyCode.push(get_list[i].code)
      }else{
        buyCode.push('')
      }
    }
    let min=price[0];
    var curMin;

    for(var i=0;i<price.length;i++){

      if(parseInt(min)>parseInt(price[i])){

        min=price[i]
      }
    } 


       curMin=Math.floor(min);


    let option={
      tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross',
            crossStyle: {
                color: '#999'
            }
        }
    },
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'cross'
        },
        showContent:true,
        formatter:function(param){
          // console.log("-------------value----------------",param)
          if(param[1].data==""){
            return param[0].seriesName + ": "  + param[0].data  + "" + "</br>"+
                     param[2].seriesName+": " + param[2].data+"</br>"+param[3].seriesName+": " + param[3].data+"</br>"+"时间:"+param[0].axisValue
          }
          if(param[2].data==""){
            return param[0].seriesName + ": "  + param[0].data  + "" + "</br>"+
                     param[1].seriesName+": " + param[1].data+"</br>"+param[3].seriesName+": " + param[3].data+"</br>"+"时间:"+param[0].axisValue
          }
        },
        // position: function (point, params, dom, rect, size) {
        //   // 固定在顶部
        //   return [point[0], '10%'];
        // }
    },
    toolbox: {
        // feature: {
        //     dataView: {show: true, readOnly: false},
        //     magicType: {show: true, type: ['line', 'bar']},
        //     restore: {show: true},
        //     saveAsImage: {show: true}
        // }
    },
    legend: {
        data:[]
    },
    xAxis: [
        {
            type: 'category',
            // data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            data:timedate,
            axisPointer: {
                type: 'shadow'
            }
        }
    ],
    yAxis: [
        {
            type: 'value',
            name: '能级值',
            axisLabel:{
                formatter: function (value, index) {
                if (value >= 10000 ) {
                  value = value / 10000 + "万";
                }
                return value;
              }
            }
        },
        {
            type: 'value',
            name: '价格',
            min: curMin,
            // max: 25,
            // interval: 5,
            // axisLabel: {
            //     formatter: '{value} °C'
            // }
        },
    ],
    series: [
          {
            name:'价格',
            type:'line',
            yAxisIndex: 1,
            // data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
            data:price,
            color:'blue'
        },
        {
            name:'能级值',
            type:'bar',
            // data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
            data:buyCode,
            color:'green',
            // barWidth:2
        },
        {
            name:'能级值',
            type:'bar',
            // data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
            data:sellCode,
            color:'red',
            // barWidth:2
        },
         {
            name:'等级',
            type:'bar',
            // data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
            data:level,
            color:'white',
        },
    ]
  }
    return option;
  }
	render(){
    
		return (
			<div className="container7">
        <div className="abc">
          <div style={{width:'10px',height:'10px',backgroundColor:'blue'}}></div>
          <p>价格走势图</p>
          <div style={{width:'10px',height:'10px',backgroundColor:'green'}}></div>
          <div style={{width:'10px',height:'10px',backgroundColor:'red',marginLeft:'5px'}}></div>
          <p>能级走势图</p>
        </div>
				<ReactEcharts option={this.getOption()} theme="Imooc"  style={{height:'400px',width:document.documentElement.clientHeight}}/>
			</div>	
		)
	}
}