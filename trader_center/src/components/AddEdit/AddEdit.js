import React from 'react';
import './AddEdit.css';

export default class AddEdit extends React.Component{
	constructor(props){
		super(props)
	}
	render(){
		return(
			<div className="container2">
				<div className="header_title">
					<img className="header_title_img1" src={require('../../images/blright.png')}/>
					<p>新增编辑</p>
					<img className="header_title_img2" src={require('../../images/wenhao.png')}/>
				</div>
				<div className="set_name">
					<p className="set_name_1p">设置名称</p>
					<input placeholder="请输入设置名称"/>
				</div>
				<div className="unit_amount">
					<p className="set_name_1p">单元金额</p>
					<div className="unit_amount_input_area">
						<input placeholder="20"/>
					</div>
					<p className="yuan">元</p>
				</div>
				<div className="unit_amount">
					<p className="set_name_1p">参数1</p>
					<p className="zhengfu">±</p>
					<div className="unit_amount_input_area">
						<input placeholder="20"/>
					</div>
					<p className="yuan">点</p>
				</div>
				<div className="unit_amount">
					<p className="set_name_1p">参数2</p>
					<p className="zhengfu">±</p>
					<div className="unit_amount_input_area">
						<input placeholder="20"/>
					</div>
					<p className="yuan">%</p>
				</div>
				<div className="unit_amount1">
					<p className="set_name_1p">通知等级</p>
					<div className="unit_amount_input_area">
						<input placeholder="0-9"/>
					</div>
					<p className="yuan">级</p>
				</div>

				<div className="bottom_btn">
					<div className="cancel">
						<p className="cancel_p">取消</p>
					</div>
					<div className="sure">
						<p className="sure_p">确认</p>
					</div>
				</div>
			</div>
		)
	}
}