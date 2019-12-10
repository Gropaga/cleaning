import React from 'react';
import { Route, Switch } from 'react-router';
import Todo from '../components/Todo'

export default (history) => {
    return <div className="container">
        <MainNav history={history} />
        <Switch>
            <Route exact path='todo' component={Todo}/>
            <Route component={NoMatch}/>
        </Switch>
    </div>
};
