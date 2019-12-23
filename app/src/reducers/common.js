import {SUCCESS_TODO, REMOVE_MESSAGE} from "../actions/common";
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
