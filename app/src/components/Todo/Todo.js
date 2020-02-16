import React from 'react';
import {FilePlus, X} from "react-feather";
import {useDispatch, useSelector} from "react-redux";
import {Button, FormCheck, Modal} from "react-bootstrap";
import DatePicker from "react-datepicker"
import {
    deleteTodo,
    hideTodo,
    LABEL_TODO,
    todoCompletedChange,
    todoDescriptionChange,
    todoIntervalChange,
    todoTitleChange,
    saveTodo
} from "../../actions/todo";
import {FETCH_INIT, FETCH_START} from "../../reducers/api";
import moment from "moment";

const Todo = function () {
    const {id, show, interval, title, description, completed} = useSelector(state => state.todo);
    const apiState = useSelector(state => state.fetching[LABEL_TODO]);
    const dispatch = useDispatch();

    const {start, end} = interval;

    const isLoading = () => [FETCH_INIT, FETCH_START].includes(apiState);

    const onClose = () => {
        dispatch(hideTodo())
    };

    const onDelete = () => {
        dispatch(deleteTodo(id));
    };

    const onSave = () => {
        dispatch(
            saveTodo(
                {
                    id,
                    start: moment(start).format('YYYY-MM-DD\THH:mm:ss'),
                    end: moment(end).format('YYYY-MM-DD\THH:mm:ss'),
                    title,
                    description,
                    completed
                }
            )
        )
    };

    const onCompletedChange = event => {
        dispatch(todoCompletedChange(event.target.checked));
    };

    const onTitleChange = event => {
        dispatch(todoTitleChange(event.target.value))
    };

    const onStartDateChange = start => {
        if (start.getTime() > end.getTime()) {
            dispatch(todoIntervalChange(
                {
                    start,
                    end: moment(start).add(15, 'minutes').toDate()
                }
            ));
        } else {
            dispatch(todoIntervalChange({start, end}));
        }

    };

    const onEndDateChange = end => {
        if (start.getTime() > end.getTime()) {
            dispatch(todoIntervalChange(
                {
                    start: moment(end).subtract(15, 'minutes').toDate(),
                    end,
                }
            ));
        } else {
            dispatch(todoIntervalChange({start, end}));
        }
    };

    const onDescriptionChange = event => {
        dispatch(todoDescriptionChange(event.target.value))
    };

    return (
        <Modal show={show} centered onHide={onClose}>
            <Modal.Header closeButton>
                <Modal.Title>
                    {typeof id === 'undefined'
                    ? 'New Todo'
                    : (
                        <>
                            <span className="mr-2">Edit todo</span>
                            <Button variant="outline-danger" disabled={isLoading()} onClick={onDelete} size='sm'>Remove</Button>
                        </>
                    )}
                </Modal.Title>
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

export default Todo
