import React from 'react';
import {FilePlus, X} from "react-feather";
import {useSelector} from "react-redux";

const NewTodo = function() {
    const {show, start, end} = useSelector(state => state.newTodo);

    return (
        <div className="alert alert-success" role="alert" hidden={! show}>
            <form>
                <div className="form-row">
                    <div className="col pb-2">
                        <label htmlFor="exampleFormControlTextarea1">Title</label>
                        <input type="text" className="form-control" placeholder="Title"/>
                    </div>
                    <div className="col">
                        <label htmlFor="exampleFormControlTextarea1">Date</label>

                        <input type="text" className="form-control" defaultValue={start} placeholder="Date"/>
                    </div>
                </div>
                <div className="form-group">
                    <label htmlFor="exampleFormControlTextarea1">Description</label>
                    <textarea className="form-control" id="exampleFormControlTextarea1" rows="5" defaultValue="" />
                </div>
                <button type="button" className="btn btn-primary btn-sm"><FilePlus height='15' width='15'/> Add Todo</button>
                <button type="button" className="btn btn-danger btn-sm float-right"><X height='15' width='15'/> Cancel</button>
            </form>
        </div>
    )
};

export default NewTodo
