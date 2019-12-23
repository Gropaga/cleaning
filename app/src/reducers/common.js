import {SUCCESS_TODO, REMOVE_MESSAGE, SHOW_NEW_TODO} from "../actions/common";
import {TODO_LIST} from "./init";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case SUCCESS_TODO:
            const data = action.payload.data.reduce((acc, item) => {
                acc[item.id] = item;
                return acc;
            }, {});

            return {
                ...state,
                TODO_LIST: {
                    ...state[TODO_LIST],
                    ...data
                }
            };
        case SHOW_NEW_TODO:
            return {
                ...state,
                newTodo: {
                    show: true,
                    start: action.payload.start,
                    end: action.payload.end,
                }
            };
        case REMOVE_MESSAGE:
            const messages = state.messages.filter(({id}) => {
                return id !== action.payload.id;
            });

            return {
                ...state,
                messages
            };
        default:
            return state
    }
};
