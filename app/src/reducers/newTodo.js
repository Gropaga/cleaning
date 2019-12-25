import {
    ADD_NEW_TODO,
    COMPLETED_CHANGE_NEW_TODO,
    DESCRIPTION_CHANGE_NEW_TODO,
    HIDE_NEW_TODO,
    INTERVAL_CHANGE_NEW_TODO,
    SHOW_EDIT_TODO,
    SHOW_NEW_TODO,
    TITLE_CHANGE_NEW_TODO
} from "../actions/newTodo";
import {TODO_LIST} from "./init";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case SHOW_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    show: true,
                    interval: {
                        start: action.payload.start,
                        end: action.payload.end,
                    },
                    title: '',
                    description: '',
                    completed: false,
                }
            };
        case SHOW_EDIT_TODO:
            return {
                ...state,
                newTodo: {
                    ...state[TODO_LIST][action.payload],
                    show: true,
                }
            };
        case ADD_NEW_TODO:
            return {
                ...state,
                TODO_LIST: {
                    ...state[TODO_LIST],
                    [action.payload.id]: action.payload
                },
                newTodo: {
                    ...state.newTodo,
                    show: false,
                }
            };
        case HIDE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    show: false,
                }
            };
        case TITLE_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    title: action.payload
                }
            };
        case DESCRIPTION_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    description: action.payload
                }
            };
        case INTERVAL_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    interval: action.payload
                }
            };
        case COMPLETED_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    completed: action.payload
                }
            };
        default:
            return state
    }
};
