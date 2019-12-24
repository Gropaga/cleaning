import {API} from "./api";
import moment from "moment";

export const NEW_TODO = "NEW_TODO";

export const ADD_NEW_TODO = 'ADD_NEW_TODO';
export const SHOW_NEW_TODO = 'SHOW_NEW_TODO';
export const HIDE_NEW_TODO = 'HIDE_NEW_TODO';
export const TITLE_CHANGE_NEW_TODO = 'TITLE_CHANGE_NEW_TODO';
export const DESCRIPTION_CHANGE_NEW_TODO = 'DESCRIPTION_CHANGE_NEW_TODO';
export const START_DATE_CHANGE_NEW_TODO = 'START_DATE_CHANGE_NEW_TODO';
export const END_DATE_CHANGE_NEW_TODO = 'START_DATE_CHANGE_NEW_TODO';

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

export const addNewTodo = ({start, end, title, description}, {id}) => {
    return {
        type: ADD_NEW_TODO,
        payload: {
            id,
            start,
            end,
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
    return {
        type: API,
        payload: {
            url: 'rest/todo/create',
            method: "POST",
            label: "NEW_TODO",
            request,
            onSuccess: addNewTodo
        }
    }
};

export const newTodoTitleChange = (title) => {
    return {
        type: TITLE_CHANGE_NEW_TODO,
        payload: title
    }
};

export const newTodoDescriptionChange = (description) => {
    return {
        type: DESCRIPTION_CHANGE_NEW_TODO,
        payload: description
    }
};

export const newTodoStartDateChange = (startDate) => {
    return {
        type: START_DATE_CHANGE_NEW_TODO,
        payload: startDate

    }
};

export const newTodoEndDateChange = (endDate) => {
    return {
        type: END_DATE_CHANGE_NEW_TODO,
        payload: endDate
    }
};
