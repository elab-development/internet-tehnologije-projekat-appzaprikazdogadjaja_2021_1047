import React from 'react';
import './Events.css';
import UseEvents from '../Hooks/UseEvents';
import Card from './Card';

const Events = () => {
    const { events, loading, error } = UseEvents();

    if (loading) return <p>Loading events...</p>;
    if (error) return <p>Error loading events: {error.message}</p>;

    return (
        <div className="events">
            <h2>Events</h2>
            <div className="events-list">
                 {events.map((event) => (
                    <Card key={event.id} event={event} />
                ))}
            </div>
        </div>
    );
};

export default Events;