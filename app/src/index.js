import './style/custom.scss';
import { applyMiddleware, compose, createStore } from 'redux'
import apiMiddleware from './middleware/api'
import thunk from 'redux-thunk';
import { createBrowserHistory } from 'history'
import { routerMiddleware, connectRouter } from 'connected-react-router'
import { Provider } from 'react-redux'
import React from 'react'
import ReactDOM from 'react-dom'
import App from './App'
import * as serviceWorker from './serviceWorker';
import rootReducer from './reducers'

const history = createBrowserHistory();

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(
    connectRouter(history)(rootReducer),
    composeEnhancer(
        applyMiddleware(
            // consoleLogger,
            apiMiddleware,
            thunk,
            routerMiddleware(history),
        ),
    ),
);

ReactDOM.render(
    <Provider store={store}>
        <App history={history} />
    </Provider>,
    document.getElementById('root')
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
