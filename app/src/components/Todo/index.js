import React from 'react';
import { useSelector, useDispatch } from 'react-redux'
import Period from "./Period";
import LargeSpinner from "../Common/LargeSpinner";
import {apiTodo} from "../../actions/common";
import FetchData from "../../hooks/fetchData";
import {TODO_LIST} from "../../reducers/init";
import {FETCH_ERROR} from "../../reducers/api";
import { RefreshCw } from "react-feather"

function Todo() {
    const todoList = useSelector(state => state[TODO_LIST]);
    const fetchingState = useSelector(state => state.fetching);
    const dispatch = useDispatch();
    FetchData(TODO_LIST, apiTodo);

    if (fetchingState[TODO_LIST] !== 'undefined'
        && fetchingState[TODO_LIST] === FETCH_ERROR
    ) {
        return <button type="button" className="btn btn-light" onClick={() => dispatch(apiTodo())}>
            <RefreshCw /> Reload
        </button>
    }

    if (typeof todoList === 'boolean' && todoList === false) {
        return <LargeSpinner/>
    }

    return <Period/>
}

export default Todo;
