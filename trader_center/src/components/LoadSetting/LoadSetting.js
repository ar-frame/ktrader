import React from 'react';
import './LoadSetting.css';

export default class LoadSetting extends React.Component{
	constructor(props){
		super(props);
		this.state={
			data:[1,1],
			showEdit:false
		}
	}
	componentWillMount(){
		console.log("---------------",this.props.history.location.state);
	}
	onclick=()=>{
		this.setState({
			showEdit:true
		})
	}
	//编辑
	edit=()=>{
		this.setState({
			showEdit:false
		})
		this.props.history.push({pathname:'addedit'})
	}
	//删除
	delete=()=>{
		this.setState({
			showEdit:false
		})
	}
	//关闭弹窗
	close=()=>{
		this.setState({
			showEdit:false
		})
	}
	render(){
		return(
			<div className="container1">
				<div className="title1" style={{display:this.state.showEdit?'none':'flex'}}>
					<img className="title_img" src={require('../../images/blright.png')}/>
					<p>编辑设置</p>
					<img className="title_img_plus" src={require('../../images/plus.png')}/>
				</div>

				{
					this.state.data.map((item,index)=>{
						return (
							<div className="item1" style={{display:this.state.showEdit?'none':'flex'}} onClick={this.onclick} key={index}>
								<div className="item1_name">
									<p>做空</p>
								</div>	
								<div className="item1_ins">
									<p className="item1_ins_1p">78946545.00元</p>
									<p className="item1_ins_2p">7级</p>
								</div>
								<div className="item1_ins">
									<p className="item1_ins_1p">±20点</p>
									<p className="item1_ins_2p">±20%</p>
								</div>
								<div className="place"></div>
							</div>
						)
					})
				}

				<div className="modal" style={{display:this.state.showEdit?'flex':'none'}} onClick={this.close}>
					<div className="modal_edit">
						<div className="modal_choose" onClick={this.edit}>
							<p>编辑</p>
						</div>
						<div className="modal_choose" onClick={this.delete}>
							<p>删除</p>
						</div>
					</div>
				</div>
			</div>
		)
	}
}