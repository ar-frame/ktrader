import React from 'react';
import './WithDrawal.css';

export default class WithDrawal extends React.Component{
	constructor(props){
		super(props);
	}
	render(){
		return (
			<div className="container3">
				<div className="transfer">
					<p>转账、提现</p>
				</div>

				<p className="transfer_ins">•  转账需要获取对方收款码或二维码</p>
				<p className="transfer_ins2">•  提现需要预先添加真实的银行账户,可以将CDY按当前比例兑换为人名币</p>

				<img src={require('../../images/top.png')}/>
			</div>
		)
	}
}