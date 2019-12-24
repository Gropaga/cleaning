import {
    ADD_NEW_TODO,
    DESCRIPTION_CHANGE_NEW_TODO,
    END_DATE_CHANGE_NEW_TODO,
    HIDE_NEW_TODO,
    SHOW_NEW_TODO,
    START_DATE_CHANGE_NEW_TODO,
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
                    start: action.payload.start,
                    end: action.payload.end,
                    title: '',
                    description: ''
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
                    show: false
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
        case START_DATE_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    start: action.payload
                }
            };
        case END_DATE_CHANGE_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    ...state.newTodo,
                    end: action.payload.date
                }
            };
        default:
            return state
    }
};
