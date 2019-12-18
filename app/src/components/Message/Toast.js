import React from 'react';
import {AlertCircle, Info, X} from 'react-feather'
import {useDispatch, useSelector} from "react-redux";
import {removeMessage} from "../../actions/common";

export const MESSAGE_INFO = 'MESSAGE_INFO';
export const MESSAGE_ERROR = 'MESSAGE_ERROR';

const Toast = () => {
    const messages = useSelector(state => state.messages);
    const dispatch = useDispatch();

    return messages.map(({id, type, heading, body}) => {
            let className = 'toast-header';
            if (type === MESSAGE_ERROR){
                className += ' text-danger';
            }

            return (
                <div key={id} className="toast showing" role="alert" aria-live="assertive" aria-atomic="true">
                    <div className={className}>
                        {
                            type === MESSAGE_ERROR
                                ? <AlertCircle className="mr-1" style={{height: "1rem", width: "1rem"}}/>
                                : <Info className="mr-1" style={{height: "1rem", width: "1rem"}}/>
                        }

                        <strong className="mr-auto">{heading}</strong>
                        <button type="button" className="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true"><X onClick={() => dispatch(removeMessage(id))}
                                                        style={{height: "1rem", width: "1rem"}}/></span>
                        </button>
                    </div>
                    <div className="toast-body">
                        {body}
                    </div>
                </div>
            );
        }
    );
};

export default Toast;
