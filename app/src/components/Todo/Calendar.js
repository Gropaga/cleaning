import React from 'react'
import {Calendar, momentLocalizer, Views} from 'react-big-calendar'
import events from './events'
import moment from "moment";

let allViews = Object.keys(Views).map(k => Views[k]);

let Basic = () => {
    const localizer = momentLocalizer(moment);

    console.log('events', events);

    return (
        <Calendar
            events={events}
            views={allViews}
            step={60}
            showMultiDayTimes
            defaultDate={new Date(2015, 3, 1)}
            localizer={localizer}
        />
    );
};




export default Basic
