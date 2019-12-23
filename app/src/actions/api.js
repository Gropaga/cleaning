export const API = 'API';
export const API_START = "API_START";
export const API_END = "API_END";
export const ACCESS_DENIED = "ACCESS_DENIED";
export const API_ERROR = "API_ERROR";
export const API_SUCCESS = "API_SUCCESS";

export const apiStart = label => ({
    type: API_START,
    payload: {
        label
    }
});

export const apiEnd = label => ({
    type: API_END,
    payload: {
        label
    }
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
        label
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
