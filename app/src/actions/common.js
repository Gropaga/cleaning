import {API} from "./api";
import moment from 'moment';
import {TODO_LIST} from "../reducers/init";

export const REMOVE_MESSAGE = 'REMOVE_MESSAGE';
export const SUCCESS_TODO = 'SUCCESS_TODO';

export const apiTodo = (
    start = moment().subtract(1, 'month').format('YYYY-MM-DD'),
    end = moment().add(1, 'month').format('YYYY-MM-DD')
) => {
    return {
        type: API,
        payload: {
            url: 'rest/todo/by-date',
            method: "GET",
            label: TODO_LIST,
            data: {start, end},
            onSuccess: successTodo
        }
    }
};

export const successTodo = data => ({
    type: SUCCESS_TODO,
    payload: {
        data
    }
});

export const removeMessage = id => ({
    type: REMOVE_MESSAGE,
    payload: {
        id
    }
});
