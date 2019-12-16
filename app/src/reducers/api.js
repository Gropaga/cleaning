import { uuid } from 'uuidv4';

import {
    API,
    API_START,
    API_END,
    DISPLAY_TODO,
    FETCH_TODO,
    API_ERROR
} from "../actions/types";
import {MESSAGE_ERROR} from "../components/Message/Toast";

export const FETCH_EMPTY = 'FETCH_EMPTY';
export const FETCH_INIT = 'FETCH_INIT';
export const FETCH_START = 'FETCH_START';
export const FETCH_END = 'FETCH_END';

const apiReducer = function(state = {}, action) {
    console.log("action type => ", action.type);
    switch (action.type) {
        case API:
            if (action.payload === FETCH_TODO) {
                return {
                    ...state,
                    fetching: {
                        ...state.fetching,
                        FETCH_TODO: FETCH_INIT,
                    }
                };
            }
            break;
        case API_START:
            if (action.payload === FETCH_TODO) {
                return {
                    ...state,
                    fetching: {
                        ...state.fetching,
                        FETCH_TODO: FETCH_START,
                    }
                };
            }
            break;
        case API_END:
            if (action.payload === FETCH_TODO) {
                return {
                    ...state,
                    fetching: {
                        ...state.fetching,
                        FETCH_TODO: FETCH_END,
                    }
                };
            }
            break;
        case API_ERROR:
            return {
                ...state,
                messages: {
                    ...state.messages,
                    [uuid()]: {
                        type: MESSAGE_ERROR,
                        ...action.payload
                    }
                },
                fetching: {
                    ...state.fetching,
                    FETCH_TODO: FETCH_END,
                }
            };
        case DISPLAY_TODO:
            return {
                data: action.payload
            };
        default:
            return state;
    }
};

export default apiReducer;
