import React from 'react';

const LargeSpinner = () => (
    <div className="d-flex justify-content-center">
        <div className="spinner-border" style={{width: '3rem', height: '3rem'}} role="status">
            <span className="sr-only">Loading...</span>
        </div>
    </div>
);

export default LargeSpinner;
