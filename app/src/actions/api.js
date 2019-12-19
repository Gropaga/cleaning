import {ACCESS_DENIED, API_END, API_ERROR, API_START, API_SUCCESS} from "../actions/types";

export const apiStart = label => ({
    type: API_START,
    payload: label
});

export const apiEnd = label => ({
    type: API_END,
    payload: label
});

export const accessDenied = url => ({
    type: ACCESS_DENIED,
    payload: {
        url
    }
});

export const apiSuccess = (label, data) => ({
    type: API_SUCCESS,
    payload: {
        label,
        data
    }
});

export const apiError = (label, heading, body) => ({
    type: API_ERROR,
    payload: {
        label,
        heading,
        body
    },
});
