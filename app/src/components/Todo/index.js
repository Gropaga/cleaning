import React from 'react';
import { useSelector } from 'react-redux'
import Period from "./Period";
import LargeSpinner from "../Common/LargeSpinner";
import {apiTodo} from "../../actions/common";
import {FETCH_TODO} from "../../actions/types";
import FetchData from "../../hooks/fetchData";
import {TODO_LIST} from "../../reducers/init";


function Todo() {
    const todoList = useSelector(state => state[TODO_LIST]);
    FetchData(TODO_LIST, FETCH_TODO, apiTodo);

    return todoList ? <Period/> : <LargeSpinner/>
}

export default Todo;
