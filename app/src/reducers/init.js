export const TODO_LIST = "TODO_LIST";

const initialState = {
    fetching: {},
    messages: [],
    [TODO_LIST]: false,
    newTodo: {
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