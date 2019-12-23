import {

} from '../actions/common';
import {DISPLAY_TODO, REMOVE_MESSAGE} from "../actions/types";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case DISPLAY_TODO:
            return {
                data: action.payload
            };
        case REMOVE_MESSAGE:
            const messages = state.messages.filter(({id}) => {
                console.log(id);
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
