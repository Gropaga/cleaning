import React from 'react'
import {Calendar as ReactBigCalendar, momentLocalizer} from 'react-big-calendar'
import moment from "moment";
import {useDispatch, useSelector} from "react-redux";
import {TODO_LIST} from "../../reducers/init";
import {apiTodo} from "../../actions/common";
import NewTodo from "./NewTodo";
import {showNewTodo} from "../../actions/newTodo";
import DatePicker from "react-datepicker";

let Calendar = () => {
    const dispatch = useDispatch();
    const events = useSelector(state => state[TODO_LIST]);

    moment.updateLocale('en', {
        week: {
            dow: 1, // Monday is the first day of the week.
        }
    });

    return (
        <>
            <NewTodo />,
            <ReactBigCalendar
                events={
                    Object.entries(events).map(([_, {id, title, description, date}]) => {
                        return {
                            id: id,
                            title: title,
                            desc: description,
                            start: moment(date).toDate(),
                            end: moment(date).add(1, 'hour').toDate()
                        }
                    })
                }
                selectable
                step={60}
                showMultiDayTimes
                onView={(event) => console.log(event)}
                onRangeChange={({start, end}) => dispatch(
                    apiTodo(
                        moment(start).format('YYYY-MM-DD'),
                        moment(end).format('YYYY-MM-DD')
                    )
                )}
                onSelectSlot={({start, end}) => dispatch(showNewTodo(start, end))}
                localizer={momentLocalizer(moment)}
            />
        </>
    );
};

export default Calendar
