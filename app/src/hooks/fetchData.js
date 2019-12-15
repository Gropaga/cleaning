import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux'
import {FETCH_EMPTY, FETCH_INIT, FETCH_START} from "../reducers/api";

function FetchData (dataKey, label, action) {
    const data = useSelector(state => state[dataKey]);
    const fetching = useSelector(state => state.fetching);
    const dispatch = useDispatch();

    useEffect(() => {
        if (typeof data === 'object') {
            return;
        }

        console.log('fetching[label]', fetching[label]);

        if (typeof fetching[label] === 'undefined') {
            console.log('fetch data via hook request');
            dispatch(action());
        }
    });
}

export default FetchData;
