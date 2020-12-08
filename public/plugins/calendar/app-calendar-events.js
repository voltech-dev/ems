// sample calendar events data
'use strict'
var curYear = moment().format('YYYY');
var curMonth = moment().format('MM');
// National Holidays
var sptCalendarEvents = {
	id: 1,
	events: [{
		id: '1',
		start: curYear + '-' + curMonth + '-02T09:00:00',
		end: curYear + '-' + curMonth + '-02T13:00:00',
		title: 'Spruko Meetup',
		backgroundColor: 'rgba(112, 94, 200, 0.3)',
		borderColor: 'rgba(112, 94, 200, 0.3)',
		description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
	}]
};
// State Holidays
var sptBirthdayEvents = {
	id: 2,
	backgroundColor: 'rgba(251, 28, 82, 0.3)',
	borderColor: 'rgba(251, 28, 82, 0.3)',
	events: [{
		id: '7',
		start: curYear + '-' + curMonth + '-04T18:00:00',
		end: curYear + '-' + curMonth + '-04T23:30:00',
		title: 'Harcates Birthday',
		backgroundColor: 'rgba(251, 28, 82, 0.3)',
		borderColor: 'rgba(251, 28, 82, 0.3)',
		description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
	}]
};
//Weekly off
var sptHolidayEvents = {
	id: 3,
	backgroundColor: 'rgba(56, 203, 137, 0.3)',
	borderColor: 'rgba(56, 203, 137, 0.3)',
	events: [{
		id: '10',
		start: curYear + '-' + curMonth + '-05',
		end: curYear + '-' + curMonth + '-08',
		title: 'Festival Day'
	}]
};
