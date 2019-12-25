import commonReducer from "./common";
import initReducer from "./init";
import apiReducer from "./api";
import todoReducer from "./todo";

const combineReducers = function (reducers) {
    return (state, action) => {
        return reducers.reduce((newState, reducer) => {
            return Object.assign(
                {},
                newState,
                reducer(newState, action)
            );
        }, state);
    }
};

export default combineReducers([
    initReducer,
    commonReducer,
    todoReducer,
    apiReducer
]);
