import React from 'react';
import './ChangeVarieties.css';
import BaseComponent from '../BaseComponent/BaseComponent';

export default class ChangeVarieties extends BaseComponent{
	constructor(props){
		super(props);
		this.state={
			data:[{name:"ETH-USDT",isSelected:true},{name:"EOS-USDT",isSelected:false},{name:"BTC-USDT",isSelected:false}],
			index:1
		}
	}

	componentWillMount(){
		if(this.props.history.location.index){
			console.log("---------------",this.props.history.location.index);
			var index=this.props.history.location.index;
			var data=this.state.data
			for(var i=0;i<data.length;i++){
				if(i==index-1){
					data[i].isSelected=true;
				}else{
					data[i].isSelected=false
				}
			}
			this.setState({
				index:index,
				data:data
			})
		}
	}

	onClick=(item,index)=>{
		var thiz=this;
		var newData=thiz.state.data;
		for(var i=0;i<newData.length;i++){
			if(index==i){
				newData[i].isSelected=true
			}else{
				newData[i].isSelected=false
			}
		}

		thiz.setState({
			data:newData,
			index:index+1
		})
	}
	//确定按钮
	ensure=()=>{
		var index=this.state.index
		this.props.history.push({pathname:'home',index:index})
	}
	render(){
		return(
			<div className="container9">
				<div className="title">
					<img src={require('../../images/blright.png')} onClick={this.goBack}/>
					<p>切换品种</p>
				</div>
				{
					this.state.data.map((item,index)=>{
						return (
							<div className="item" key={index} onClick={this.onClick.bind(this,item,index)}>
								<p>{item.name}</p>
								<div className="dots">
									<img className="dots_img" src={item.isSelected?require('../../images/selected.png'):require('../../images/circle.png')}/>
								</div>	
							</div>
						)
					})
				}
				<div className="btn">
					<div className="change_cancel" onClick={this.goBack}>
						<p className="btn_p">取消</p>
					</div>
					<div className="change_ensure" onClick={this.ensure}>
						<p className="btn_p" style={{color:"white"}}>确定</p>
					</div>		
				</div>	
			</div>
		)
	}
}