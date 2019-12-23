import React from "react";
import {Clock} from "react-feather";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from "react-router-dom";

import Todo from "./components/Todo";
import Toast from "./components/Message/Toast"

function App() {
    return (
        <Router>
            <div className="App">
                <nav className="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
                    <div className="navbar-brand col-sm-3 col-md-2 mr-0">
                        CleaningCRM
                    </div>
                    <ul className="navbar-nav px-3">
                        <li className="nav-item text-nowrap">
                            <span className="nav-link">Sign out</span>
                        </li>
                    </ul>
                </nav>
                <div className="container-fluid">
                    <div className="row">
                        <nav className="col-md-2 d-none d-md-block bg-light sidebar">
                            <div className="sidebar-sticky">
                                <ul className="nav flex-column">
                                    <li className="nav-item">
                                        <Link to='/todo' className="nav-link active" href="#">
                                            <Clock className="feather"/>
                                            Todo list <span className="sr-only">(current)</span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <main key="one" role="main" className="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                            <Toast />
                            <Switch>
                                <Route path="/todo">
                                    <Todo/>
                                </Route>
                            </Switch>
                        </main>
                    </div>
                </div>
            </div>
        </Router>


    );
}

export default App;
