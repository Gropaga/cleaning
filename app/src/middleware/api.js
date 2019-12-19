import axios from "axios";
import {API} from "../actions/types";
import {accessDenied, apiEnd, apiError, apiStart, apiSuccess} from "../actions/api";

const apiMiddleware = ({dispatch}) => next => action => {
    next(action);

    if (action.type !== API) return;

    const {
        url,
        method,
        data,
        accessToken,
        onSuccess,
        onFailure,
        label,
        headers
    } = action.payload;

    const dataOrParams = ["GET", "DELETE"].includes(method) ? "params" : "data";


    // axios default configs
    axios.defaults.baseURL = process.env.REACT_APP_BASE_URL || "";
    axios.defaults.headers.common["Content-Type"] = "application/json";
    axios.defaults.headers.common["Authorization"] = `Bearer${accessToken}`;

    if (label) {
        dispatch(apiStart(label));
    }

    axios
        .request({
            url,
            method,
            headers,
            [dataOrParams]: data
        })
        .then(({data}) => {
            dispatch(apiSuccess(label, data));
        })
        .catch(error => {
            if (error.response && error.response.status === 403) {
                dispatch(accessDenied(window.location.pathname));
            } else if (error.response) {
                dispatch(apiError(label, 'Network error', JSON.stringify({
                        url: error.request.url,
                        data: error.response.data,
                        status: error.response.status,
                        headers: error.response.headers,
                    }))
                );
            } else if (error.request) {
                dispatch(apiError(label, 'Network error: no response', JSON.stringify({
                        url: error.request,
                    }))
                );
            } else {
                dispatch(apiError(label, error.name, error.message));
            }

            console.error(error);
        })
        .finally(() => {
            if (label) {
                dispatch(apiEnd(label));
            }
        });

};

export default apiMiddleware;
