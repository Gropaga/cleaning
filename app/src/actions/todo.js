import {API} from "./api";
import moment from "moment";

export const LABEL_TODO = "LABEL_TODO";

export const ADD_TODO = 'ADD_TODO';
export const SHOW_TODO = 'SHOW_TODO';
export const SHOW_EDIT_TODO = 'SHOW_EDIT_TODO';
export const HIDE_TODO = 'HIDE_TODO';
export const DELETE_TODO_SUCCESS = 'DELETE_TODO_SUCCESS';
export const TITLE_CHANGE_TODO = 'TITLE_CHANGE_TODO';
export const DESCRIPTION_CHANGE_TODO = 'DESCRIPTION_CHANGE_TODO';
export const INTERVAL_CHANGE_TODO = 'INTERVAL_CHANGE_TODO';
export const COMPLETED_CHANGE_TODO = 'COMPLETED_CHANGE_TODO';

export const showTodo = (start, end) => {
    if (start.getTime() === end.getTime()) {
        end = moment(start).add(1, 'hour').toDate();
    }

    return {
        type: SHOW_TODO,
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

export const addTodo = ({start, end, title, description, completed}) => ({id}) => {
    return {
        type: ADD_TODO,
        payload: {
            id,
            interval: {
                start: moment(start).toDate(),
                end: moment(end).toDate()
            },
            title,
            description,
            completed
        }
    }
};

export const hideTodo = () => {
    return {
        type: HIDE_TODO,
        payload: {
            show: false
        }
    }
};

export const deleteTodoSuccess =  deletedId => _ => {
    return {
        type: DELETE_TODO_SUCCESS,
        payload: deletedId
    }
};

export const deleteTodo = deletedId => {
    return {
        type: API,
        payload: {
            url: 'rest/todo/delete/' + deletedId,
            method: "DELETE",
            label: LABEL_TODO,
            onSuccess: deleteTodoSuccess(deletedId)
        }
    }
};

export const saveTodo = request => {

    console.log(request);

    if (typeof request.id === 'undefined') {
        return {
            type: API,
            payload: {
                url: 'rest/todo/create',
                method: "POST",
                label: LABEL_TODO,
                request,
                onSuccess: addTodo(request)
            }
        }
    }

    const { title, description, start, end, completed } = request;

    return {
        type: API,
        payload: {
            url: 'rest/todo/update/' + request.id,
            method: "PATCH",
            label: LABEL_TODO,
            request: {
                title,
                description,
                start,
                end,
                completed
            },
            onSuccess: addTodo(request)
        }
    }
};

export const todoCompletedChange = completed => {
    return {
        type: COMPLETED_CHANGE_TODO,
        payload: completed
    }
};

export const todoTitleChange = title => {
    return {
        type: TITLE_CHANGE_TODO,
        payload: title
    }
};

export const todoDescriptionChange = description => {
    return {
        type: DESCRIPTION_CHANGE_TODO,
        payload: description
    }
};

export const todoIntervalChange = interval => {
    return {
        type: INTERVAL_CHANGE_TODO,
        payload: interval
    }
};
