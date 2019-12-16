import {

} from '../actions/common';
import {REMOVE_MESSAGE} from "../actions/types";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case REMOVE_MESSAGE:

            const messages = Object.entries(state.messages).filter(([key, _]) => {
                return key !== action.payload.id;
            });

            return {
                ...state,
                messages
            };

        default:
            return state
    }
};
