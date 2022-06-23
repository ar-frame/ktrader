import React from 'react';
import './MoreTips.css';

export default class MoreTips extends React.Component{
	constructor(props){
		super(props);
		this.state={
			data:[],
			index:'',
		}
	}
	componentWillMount(){
		var index=1;
		if(this.props.history.location.index){
			console.log("-----------MoreTips----",this.props.history.location.index);
			index=this.props.history.location.index;
			this.setState({
				index:index
			})
		}
		var thiz=this;
		this.getData(index);
	}
	//筛选大于0级的数据
	screening=(data)=>{
		var newData=[];
		for(var i=0;i<data.length;i++){
			if(data[i].level!='0')
			{
				newData.push(data[i])
			}
		}
		console.log("----------------newData-----------------",newData);
		this.setState({
			data:newData
		})
	}

	getData=(index)=>{
		let thiz=this;
		if(index==1){
			var ws = new WebSocket("ws://192.168.101.177:12315");
		}
		if(index==2){
			var ws = new WebSocket("ws://192.168.101.177:12316");
		}
		if(index==3){
			var ws = new WebSocket("ws://192.168.101.177:12317");
		}
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

                console.log("Connection recv msg:" + e.data);
               	var data=JSON.parse(e.data);
            	thiz.screening(data.data);
            };
            ws.onclose = function(e) {
                console.log("Connection closed.");
            };
            ws.onerror = function (event) {
                console.log("Connection onerror.");
            };
	}
	//返回上一个界面
	goBack=()=>{
		this.props.history.goBack();
	}
	render(){
		return(
			<div className="container1">
				<div className="top_title">
					<img src={require('../../images/back.png')} onClick={this.goBack}/>
					<p>更多提示</p>
				</div>
				<div className="ins">
					<div><p className="ins_1p">时间</p></div>
					<div><p>价格</p></div>
					<div><p>方向</p></div>
					<div><p>级别</p></div>
					<div><p className="ins_5p">品种</p></div>
				</div>
				{
					this.state.data.map((item,index)=>{
						return (
							<div className="data" key={index}>
								
								<div>
									<p className="data_2p">{item.timedate}</p>
								</div>

								<div>
									<p className="data_1p">{item.price}</p>
								</div>

								<div>
									<p className="data_3P" style={{color:item.type=="sell"?'red':'green'}}>{item.type=="sell"?"卖出":"买入"}</p>
								</div>

								<div>
									<p className="data_4p">{item.level}</p>
								</div>

								<div>
									<p className="data_5p">{item.pair}</p>
								</div>
							</div>	
						)
					})
				}
			</div>
		)
	}
}