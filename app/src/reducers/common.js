import {

} from '../actions/common';
import {REMOVE_MESSAGE} from "../actions/types";

export default (state = {}, {type, ...action}) => {
    switch (type) {
        case REMOVE_MESSAGE:


        default:
            return state
    }
};
