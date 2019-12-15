import React from "react";
import {Clock, BarChart2, File, FileText, Layers, PlusCircle, ShoppingCart, Users} from "react-feather";
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
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <File className="feather"/>
                                    Orders
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <ShoppingCart className="feather"/>
                                    Products
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <Users className="feather"/>
                                    Customers
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <BarChart2 className="feather"/>
                                    Reports
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <Layers className="feather"/>
                                    Integrations
                                    </a>
                                    </li>
                                    </ul>

                                    <h6 className="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                    <span>Saved reports</span>
                                    <a className="d-flex align-items-center text-muted" href="#">
                                    <PlusCircle className="feather"/>
                                    </a>
                                    </h6>
                                    <ul className="nav flex-column mb-2">
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <FileText className="feather"/>
                                    Current month
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <FileText className="feather"/>
                                    Last quarter
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <FileText className="feather"/>
                                    Social engagement
                                    </a>
                                    </li>
                                    <li className="nav-item">
                                    <a className="nav-link" href="#">
                                    <FileText className="feather"/>
                                    Year-end sale
                                    </a>
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
