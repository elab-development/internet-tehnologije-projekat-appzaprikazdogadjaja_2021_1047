import React from 'react';
import './Card.css';

const Card = ({ event }) => {
    return (
        <div className="events-card">
            <h3>{event.title}</h3>
            {event.image && <img src={event.image} alt={event.title} />}
            <p>{event.description}</p>
            {event.location.name !== 'Unknown Location' && (
                <p><strong>Location:</strong> {event.location.name}</p>
            )}
            <p><strong>Category:</strong> {event.category.name}</p>
            <p><strong>Source:</strong> {event.reference.name}</p>
            <p><strong>Start Date:</strong> {event.start_date}</p>
            <p><strong>End Date:</strong> {event.end_date}</p>
        </div>
    );
};

export default Card;