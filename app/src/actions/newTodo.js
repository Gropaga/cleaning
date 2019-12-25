import {API} from "./api";
import moment from "moment";

export const NEW_TODO = "NEW_TODO";
export const UPDATE_TODO = "UPDATE_TODO";

export const ADD_NEW_TODO = 'ADD_NEW_TODO';
export const SHOW_NEW_TODO = 'SHOW_NEW_TODO';
export const SHOW_EDIT_TODO = 'SHOW_EDIT_TODO';
export const HIDE_NEW_TODO = 'HIDE_NEW_TODO';
export const TITLE_CHANGE_NEW_TODO = 'TITLE_CHANGE_NEW_TODO';
export const DESCRIPTION_CHANGE_NEW_TODO = 'DESCRIPTION_CHANGE_NEW_TODO';
export const INTERVAL_CHANGE_NEW_TODO = 'INTERVAL_CHANGE_NEW_TODO';
export const COMPLETED_CHANGE_NEW_TODO = 'COMPLETED_CHANGE_NEW_TODO';

export const showNewTodo = (start, end) => {
    if (start.getTime() === end.getTime()) {
        end = moment(start).add(1, 'hour').toDate();
    }

    return {
        type: SHOW_NEW_TODO,
        payload: {
            show: true,
            start,
            end,
        }
    }
};

export const showEditTodo = id => {
    return {
        type: SHOW_EDIT_TODO,
        payload: id,
    }
};

export const addNewTodo = ({interval, title, description}, {id}) => {
    return {
        type: ADD_NEW_TODO,
        payload: {
            id,
            interval: {
                start: moment(interval.start).toDate(),
                end: moment(interval.end).toDate()
            },
            title,
            description,
            completed: false
        }
    }
};

export const hideNewTodo = () => {
    return {
        type: HIDE_NEW_TODO,
        payload: {
            show: false
        }
    }
};

export const saveNewTodo = (request) => {
    if (typeof request.id === 'undefined') {
        return {
            type: API,
            payload: {
                url: 'rest/todo/create',
                method: "POST",
                label: NEW_TODO,
                request,
                onSuccess: addNewTodo
            }
        }
    }

    const { title, description, interval, completed } = request;

    return {
        type: API,
        payload: {
            url: 'rest/todo/update/' + request.id,
            method: "PATCH",
            label: UPDATE_TODO,
            request: {
                title,
                description,
                interval,
                completed
            },
            onSuccess: addNewTodo
        }
    }
};

export const newTodoCompletedChange = completed => {
    return {
        type: COMPLETED_CHANGE_NEW_TODO,
        payload: completed
    }
};

export const newTodoTitleChange = title => {
    return {
        type: TITLE_CHANGE_NEW_TODO,
        payload: title
    }
};

export const newTodoDescriptionChange = description => {
    return {
        type: DESCRIPTION_CHANGE_NEW_TODO,
        payload: description
    }
};

export const newTodoIntervalChange = interval => {
    return {
        type: INTERVAL_CHANGE_NEW_TODO,
        payload: interval
    }
};
