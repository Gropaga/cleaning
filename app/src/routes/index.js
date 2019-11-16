import React from 'react';
import { Route, Switch } from 'react-router';
import Home from '../components/Home/index';
import NoMatch from '../components/NoMatch/index';
import MainNav from '../components/MainNav/index';
import {_lRev, _p} from "../lib/i18n";

export default (history) => {
    return <div className="container">
        <MainNav history={history} />
        <Switch>
            <Route exact path='Calendar' component={Home}/>
            <Route component={NoMatch}/>
        </Switch>
    </div>
};
