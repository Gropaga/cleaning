export const TODO_LIST = "TODO_LIST";

const initialState = {
    fetching: {},
    messages: [],
    [TODO_LIST]: false,
    todo: {
        show: false,
        interval: {
            start: false,
            end: false,
        },
        title: '',
        description: '',
        completed: false
    }
};

const initReducer = (state = { ...initialState }) => {
    return state
};

export default initReducer
