import React from 'react';
import {FilePlus, X} from "react-feather";
import {useDispatch, useSelector} from "react-redux";
import {Button, FormCheck, Modal} from "react-bootstrap";
import DatePicker from "react-datepicker"
import {
    hideNewTodo,
    NEW_TODO,
    newTodoCompletedChange,
    newTodoDescriptionChange,
    newTodoIntervalChange,
    newTodoTitleChange,
    saveNewTodo
} from "../../actions/newTodo";
import {FETCH_INIT, FETCH_START} from "../../reducers/api";
import moment from "moment";

const NewTodo = function () {
    const {id, show, interval, title, description, completed} = useSelector(state => state.newTodo);
    const apiState = useSelector(state => state.fetching[NEW_TODO]);
    const dispatch = useDispatch();

    const {start, end} = interval;

    const isLoading = () => [FETCH_INIT, FETCH_START].includes(apiState);

    const onClose = () => {
        dispatch(hideNewTodo())
    };

    const onSave = () => {
        dispatch(
            saveNewTodo(
                {
                    id,
                    interval: {
                        start: moment(start).format('YYYY-MM-DD\THH:mm:ss'),
                        end: moment(end).format('YYYY-MM-DD\THH:mm:ss'),
                    },
                    title,
                    description,
                    completed
                }
            )
        )
    };

    const onCompletedChange = event => {
        dispatch(newTodoCompletedChange(event.target.checked));
    };

    const onTitleChange = event => {
        dispatch(newTodoTitleChange(event.target.value))
    };

    const onStartDateChange = start => {
        if (start.getTime() > end.getTime()) {
            dispatch(newTodoIntervalChange(
                {
                    start,
                    end: moment(start).add(15, 'minutes').toDate()
                }
            ));
        } else {
            dispatch(newTodoIntervalChange({start, end}));
        }

    };

    const onEndDateChange = end => {
        if (start.getTime() > end.getTime()) {
            dispatch(newTodoIntervalChange(
                {
                    start: moment(end).subtract(15, 'minutes').toDate(),
                    end,
                }
            ));
        } else {
            dispatch(newTodoIntervalChange({start, end}));
        }
    };

    const onDescriptionChange = event => {
        dispatch(newTodoDescriptionChange(event.target.value))
    };

    return (
        <Modal show={show} centered onHide={onClose}>
            <Modal.Header closeButton>
                <Modal.Title>New Todo</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <form>
                    <div className="form-row">
                        <div className="col pb-2">
                            <label htmlFor="exampleFormControlTextarea1">Title</label>
                            <input type="text" className="form-control" value={title} onChange={onTitleChange}
                                   placeholder="Title"/>
                        </div>
                        <div className="col">
                            <label htmlFor="exampleFormControlTextarea1">Start</label>
                            <DatePicker
                                className="form-control"
                                showTimeInput
                                selected={start}
                                onChange={onStartDateChange}
                                dateFormat="dd/MM/yyyy HH:mm"
                            />
                        </div>
                        <div className="col">
                            <label htmlFor="exampleFormControlTextarea1">End</label>
                            <DatePicker
                                className="form-control"
                                showTimeInput
                                selected={end}
                                onChange={onEndDateChange}
                                dateFormat="dd/MM/yyyy HH:mm"
                            />
                        </div>
                    </div>
                    <div className="form-group">
                        <label htmlFor="exampleFormControlTextarea1">Description</label>
                        <textarea className="form-control" id="exampleFormControlTextarea1" value={description}
                                  onChange={onDescriptionChange} rows="5"/>
                    </div>
                    <FormCheck
                        type="switch"
                        id="custom-switch"
                        label="Completed"
                        checked={completed}
                        onChange={onCompletedChange}
                    />
                </form>
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={onClose}>
                    <X height='15' width='15'/> Close
                </Button>
                <Button variant="primary" size="sm" onClick={onSave} disabled={isLoading()}>
                    <FilePlus height='15' width='15'/> Save Changes
                </Button>
            </Modal.Footer>
        </Modal>
    );
};

export default NewTodo
