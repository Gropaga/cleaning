import React from 'react';
import {FilePlus, X} from "react-feather";
import {useDispatch, useSelector} from "react-redux";
import {Button, Modal} from "react-bootstrap";
import DatePicker from "react-datepicker"
import {
    hideNewTodo, newTodoDescriptionChange,
    newTodoEndDateChange,
    newTodoStartDateChange,
    newTodoTitleChange,
    saveNewTodo
} from "../../actions/newTodo";

const NewTodo = function () {
    const {show, start, end, title, description} = useSelector(state => state.newTodo);
    const dispatch = useDispatch();

    const onClose = () => {
        dispatch(hideNewTodo())
    };

    const onSave = () => {
        dispatch(saveNewTodo({start, end, title, description}))
    };

    const onTitleChange = event => {
        dispatch(newTodoTitleChange(event.target.value))
    };

    const onStartDateChange = date => {
        dispatch(newTodoStartDateChange(date))
    };

    const onEndDateChange = date => {
        dispatch(newTodoEndDateChange(date))
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
                            <input type="text" className="form-control" value={title} onChange={onTitleChange} placeholder="Title"/>
                        </div>
                        <div className="col">
                            <label htmlFor="exampleFormControlTextarea1">Start</label>
                            <DatePicker
                                className="form-control"
                                showTimeInput
                                selected={start}
                                onChange={onStartDateChange}
                                dateFormat="MM/dd/yyyy HH:mm"
                            />
                        </div>
                        <div className="col">
                            <label htmlFor="exampleFormControlTextarea1">End</label>
                            <DatePicker
                                className="form-control"
                                showTimeInput
                                selected={end}
                                onChange={onEndDateChange}
                                dateFormat="MM/dd/yyyy hh:mm"
                            />
                        </div>
                    </div>
                    <div className="form-group">
                        <label htmlFor="exampleFormControlTextarea1">Description</label>
                        <textarea className="form-control" id="exampleFormControlTextarea1" value={description} onChange={onDescriptionChange} rows="5" />
                    </div>
                </form>
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={onClose}>
                    <X height='15' width='15'/> Close
                </Button>
                <Button variant="primary" size="sm" onClick={onSave}>
                    <FilePlus height='15' width='15'/> Save Changes
                </Button>
            </Modal.Footer>
        </Modal>
    );
};

export default NewTodo
