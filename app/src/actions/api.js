import { API_START, API_END, ACCESS_DENIED, API_ERROR, DISPLAY_ERROR } from "../actions/types";

export const displayError = (data) => ({
    type: DISPLAY_ERROR,
    payload: data,
});

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

export const apiError = (label, message, url, data) => ({
    type: API_ERROR,
    payload: {
        label,
        message,
        url,
        data
    },
});
