import {API, DISPLAY_TODO, FETCH_TODO, REMOVE_MESSAGE} from "./types";
import moment from 'moment';
import {displayError} from "./api";

export const apiTodo = () => ({
    type: API,
    payload: {
        url: 'http://localhost:8888/rest/todo/by-date',
        method: "GET",
        label: FETCH_TODO,
        data: {
            start: moment().subtract(1, 'days').format('YYYY-MM-DD'),
            end: moment().add(3, 'months').format('YYYY-MM-DD')
        },
        onSuccess: displayTodo,
        onFailure: displayError,
    }
});

export const displayTodo = data => ({
    type: DISPLAY_TODO,
    payload: data,
});

export const removeMessage = id => ({
    type: REMOVE_MESSAGE,
    payload: id
});
