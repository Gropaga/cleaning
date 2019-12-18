import React, {useState} from 'react';
import {Plus, X} from "react-feather";
import NewTodo from "./NewTodo";

export default function Period() {
    const [isNewTodoVisible, setIsNewTodoVisible] = useState(false);
    return (
        <div>
            <div
                className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-1">
                <h1 className="h2">Today</h1>
                <div className="btn-toolbar mb-2 mb-md-0">
                    <div className="btn-group mr-2" hidden={isNewTodoVisible}>
                        <button className="btn btn-sm btn-outline-secondary" onClick={() => setIsNewTodoVisible(true)}>
                            <Plus height='15' width='15'/>New todo
                        </button>
                    </div>
                    <div className="btn-group mr-2" hidden={!isNewTodoVisible}>
                        <button className="btn btn-sm btn-outline-danger" onClick={() => setIsNewTodoVisible(false)}>
                            <X height='15' width='15'/>Hide
                        </button>
                    </div>
                </div>
            </div>

            <NewTodo display={isNewTodoVisible}/>

            <div className="border-bottom" />
        </div>
    )
}
