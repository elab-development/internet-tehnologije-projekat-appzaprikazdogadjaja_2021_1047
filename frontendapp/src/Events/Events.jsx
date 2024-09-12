import React, { useState } from 'react';
import './Events.css';
import UseEvents from '../Hooks/UseEvents';
import Card from './Card';
import ReactPaginate from 'react-paginate';

const Events = () => {
    const { events, setEvents,  loading, error } = UseEvents();
    const [currentPage, setCurrentPage] = useState(0);
    const [filter, setFilter] = useState('');
    const eventsPerPage = 6;

    const handlePageClick = (data) => {
        setCurrentPage(data.selected);
    };

    const handleFilterChange = (e) => {
        setFilter(e.target.value);
        setCurrentPage(0);
    };

    const handleDeleteEvent = (id) => {
        setEvents(prevEvents => prevEvents.filter(event => event.id !== id));
    };

    const filteredEvents = events.filter(event =>
        event.title.toLowerCase().includes(filter.toLowerCase()) ||
        event.description.toLowerCase().includes(filter.toLowerCase())
    );

    const pageCount = Math.ceil(filteredEvents.length / eventsPerPage);
    const offset = currentPage * eventsPerPage;
    const currentEvents = filteredEvents.slice(offset, offset + eventsPerPage);

    if (loading) return <p>Loading events...</p>;
    if (error) return <p>Error loading events: {error.message}</p>;

    return (
        <div className="events">
            <h2>Events</h2>
            <input
                type="text"
                placeholder="Filter events"
                value={filter}
                onChange={handleFilterChange}
                className="filter-input"
            />
            <div className="events-list">
                 {currentEvents.map((event) => (
                    <Card key={event.id} event={event} onDelete={handleDeleteEvent} />
                ))}
            </div>
            <ReactPaginate
                previousLabel={'Previous'}
                nextLabel={'Next'}
                breakLabel={'...'}
                breakClassName={'break-me'}
                pageCount={pageCount}
                marginPagesDisplayed={2}
                pageRangeDisplayed={5}
                onPageChange={handlePageClick}
                containerClassName={'pagination'}
                subContainerClassName={'pages pagination'}
                activeClassName={'active'}
            />
        </div>
    );
};

export default Events;