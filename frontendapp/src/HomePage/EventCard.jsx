import React from 'react';
import './EventCard.css';

const EventCard = ({ image, title, description }) => {
    return (
        <div className="event-card">
            <h3>{title}</h3>
            <img src={image} alt={title} />
            <p>{description}</p>
        </div>
    );
};

export default EventCard;