import React from 'react';
import {FilePlus} from "react-feather";

export default function({display}) {
    return (
        <div className="alert alert-success" role="alert" hidden={! display}>
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
                    <textarea className="form-control" id="exampleFormControlTextarea1" rows="5" defaultValue="" />
                </div>
                <button type="button" className="btn btn-primary btn-sm"><FilePlus height='15' width='15'/> Add Todo</button>
            </form>
        </div>
    )
}
