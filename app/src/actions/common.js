import {API, DISPLAY_TODO, REMOVE_MESSAGE} from "./types";
import moment from 'moment';
import {TODO_LIST} from "../reducers/init";

export const apiTodo = () => ({
    type: API,
    payload: {
        url: 'rest/todo/by-date',
        method: "GET",
        label: TODO_LIST,
        data: {
            start: moment().subtract(100, 'years').format('YYYY-MM-DD'),
            end: moment().add(3, 'months').format('YYYY-MM-DD')
        }
    }
});

export const removeMessage = id => ({
    type: REMOVE_MESSAGE,
    payload: {
        id
    }
});
