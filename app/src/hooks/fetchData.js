import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux'

function FetchData (dataKey, action) {
    const data = useSelector(state => state[dataKey]);
    const fetching = useSelector(state => state.fetching);
    const dispatch = useDispatch();

    useEffect(() => {
        if (typeof data === 'object') {
            return;
        }

        if (typeof fetching[dataKey] === 'undefined') {
            dispatch(action());
        }
    });
}

export default FetchData;
