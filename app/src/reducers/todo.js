import {
    ADD_TODO,
    COMPLETED_CHANGE_TODO, DELETE_TODO_SUCCESS,
    DESCRIPTION_CHANGE_TODO,
    HIDE_TODO,
    INTERVAL_CHANGE_TODO,
    SHOW_EDIT_TODO,
    SHOW_TODO,
    TITLE_CHANGE_TODO
} from "../actions/todo";
import {TODO_LIST} from "./init";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case SHOW_TODO:
            return {
                ...state,
                todo: {
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
        case DELETE_TODO_SUCCESS:
            const filteredTodoList = Object.entries(state[TODO_LIST]).reduce((acc, [id, value]) => {
                if (id !== action.payload) {
                    acc[id] = value;
                }
                return acc;
            }, {});

            return {
                ...state,
                TODO_LIST: filteredTodoList,
                todo: {
                    ...state.todo,
                    show: false,
                }
            };
        case SHOW_EDIT_TODO:
            return {
                ...state,
                todo: {
                    ...state[TODO_LIST][action.payload],
                    show: true,
                }
            };
        case ADD_TODO:
            return {
                ...state,
                TODO_LIST: {
                    ...state[TODO_LIST],
                    [action.payload.id]: action.payload
                },
                todo: {
                    ...state.todo,
                    show: false,
                }
            };
        case HIDE_TODO:
            return {
                ...state,
                todo: {
                    ...state.todo,
                    show: false,
                }
            };
        case TITLE_CHANGE_TODO:
            return {
                ...state,
                todo: {
                    ...state.todo,
                    title: action.payload
                }
            };
        case DESCRIPTION_CHANGE_TODO:
            return {
                ...state,
                todo: {
                    ...state.todo,
                    description: action.payload
                }
            };
        case INTERVAL_CHANGE_TODO:
            return {
                ...state,
                todo: {
                    ...state.todo,
                    interval: action.payload
                }
            };
        case COMPLETED_CHANGE_TODO:
            return {
                ...state,
                todo: {
                    ...state.todo,
                    completed: action.payload
                }
            };
        default:
            return state
    }
};
