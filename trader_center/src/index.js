import React from 'react';
import ReactDOM from 'react-dom';
// import { createStore } from 'redux';
// import reducer from './components/reducer/rootReducer';
// import {Provider} from 'react-redux';
import {HashRouter, BrowserRouter,Route,Redirect,Switch,Link,NavLink} from 'react-router-dom';
import './index.css';
// import App from './App';
import Home from './components/Home/Home';
import MoreTips from './components/MoreTips/MoreTips';
import SoftwareInfo from './components/SoftwareInfo/SoftwareInfo';
import ChangeVarieties from './components/ChangeVarieties/ChangeVarieties';
import LoadSetting from './components/LoadSetting/LoadSetting';
import AddEdit from './components/AddEdit/AddEdit';
import WithDrawal from './components/WithDrawal/WithDrawal';
import KLineGraph from './components/KLineGraph/KLineGraph';
import Start from './components/Start/Start';
import * as serviceWorker from './serviceWorker';
const Rt=()=>(
        <BrowserRouter>
                	<Route  exact  path="/"   component={Start}/>
                        <Route  path="/Home"  name="home" component={Home}/>
                        <Route  path="/SoftwareInfo"  name="softwareinfo" component={SoftwareInfo}/>
                        <Route  path="/MoreTips"  name="moretips" component={MoreTips}/>
                        <Route  path="/ChangeVarieties"  name="changevarieties" component={ChangeVarieties}/>
                        <Route  path="/LoadSetting"  name="loadsetting" component={LoadSetting}/>
                        <Route  path="/AddEdit"  name="addedit" component={AddEdit}/>
                        <Route  path="/WithDrawal"  name="withdrawal" component={WithDrawal}/>
                        <Route  path="/KLineGraph"  name="klinegraph" component={KLineGraph}/>
        </BrowserRouter>
)

ReactDOM.render(<Rt />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
