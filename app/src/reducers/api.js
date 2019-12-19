import { uuid } from 'uuidv4';

import {
    API,
    API_START,
    API_END,
    API_ERROR,
    API_SUCCESS
} from "../actions/types";
import {MESSAGE_ERROR} from "../components/Message/Toast";

export const FETCH_INIT = 'FETCH_INIT';
export const FETCH_START = 'FETCH_START';
export const FETCH_END = 'FETCH_END';
export const FETCH_ERROR = 'FETCH_ERROR';

const apiReducer = function(state = {}, action) {
    switch (action.type) {
        case API:
            return {
                ...state,
                fetching: {
                    ...state.fetching,
                    [action.payload.label]: FETCH_INIT,
                }
            };
        case API_START:
            return {
                ...state,
                fetching: {
                    ...state.fetching,
                    [action.payload.label]: FETCH_START,
                }
            };
        case API_END:
            return {
                ...state,
                fetching: {
                    ...state.fetching,
                    [action.payload.label]: FETCH_END,
                }
            };
        case API_ERROR:
            return {
                ...state,
                messages: [
                    ...state.messages,
                    {
                        ...action.payload,
                        id: uuid(),
                        type: MESSAGE_ERROR,
                    }
                ],
                fetching: {
                    ...state.fetching,
                    [action.payload.label]: FETCH_ERROR,
                }
            };
        case API_SUCCESS:
            return {
                ...state,
                [action.payload.label]: {
                    ...[action.payload.label],
                    ...action.payload.data
                }
            };
        default:
            return state;
    }
};

export default apiReducer;
