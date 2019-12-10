import React from 'react';
import {Plus, Trash2, FilePlus, X} from "react-feather";

export default function Period() {
    return ([
            <main key="one" role="main" className="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div
                    className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-1">
                    <h1 className="h2">Today 123</h1>
                    <div className="btn-toolbar mb-2 mb-md-0">
                        <div className="btn-group mr-2">
                            <button className="btn btn-sm btn-outline-secondary"><Plus height='15' width='15'/>New todo
                            </button>
                        </div>
                    </div>
                </div>

                <div className="alert alert-success" role="alert">
                    <form>
                        <div className="form-row">
                            <div className="col pb-2">
                                <label htmlFor="exampleFormControlTextarea1">Title</label>
                                <input type="text" className="form-control" placeholder="Title"/>
                            </div>
                            <div className="col">
                                <label htmlFor="exampleFormControlTextarea1">Date</label>

                                <input type="text" className="form-control" placeholder="Date"/>
                            </div>
                        </div>
                        <div className="form-group">
                            <label htmlFor="exampleFormControlTextarea1">Description</label>
                            <textarea className="form-control" id="exampleFormControlTextarea1" rows="5"> </textarea>
                        </div>
                        <button type="button" className="btn btn-primary btn-sm"><FilePlus height='15' width='15'/> Add Todo</button>
                        <button type="button" className="btn btn-outline-danger btn-sm float-right"><X height='15' width='15' /> Hide</button>
                    </form>
                </div>

                <div className="border-bottom">

                </div>
            </main>
        ]


    )
}
