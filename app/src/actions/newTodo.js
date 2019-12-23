import {API} from "./api";

export const SHOW_NEW_TODO = 'SHOW_NEW_TODO';
export const HIDE_NEW_TODO = 'HIDE_NEW_TODO';
export const TITLE_CHANGE_NEW_TODO = 'TITLE_CHANGE_NEW_TODO';
export const DESCRIPTION_CHANGE_NEW_TODO = 'DESCRIPTION_CHANGE_NEW_TODO';
export const START_DATE_CHANGE_NEW_TODO = 'START_DATE_CHANGE_NEW_TODO';
export const END_DATE_CHANGE_NEW_TODO = 'START_DATE_CHANGE_NEW_TODO';

export const showNewTodo = (start, end) => {
    return {
        type: SHOW_NEW_TODO,
        payload: {
            show: true,
            start,
            end,
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

export const saveNewTodo = (data) => {
    return {
        type: API,
        payload: {
            url: 'rest/todo/create',
            method: "POST",
            label: "NEW_TODO",
            data,
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
