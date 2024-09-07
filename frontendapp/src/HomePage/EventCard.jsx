import React from 'react';
import './EventCard.css';

const EventCard = ({ image, title, description }) => {
    return (
        <div className="event-card">
            <img src={image} alt={title} />
            <h3>{title}</h3>
            <p>{description}</p>
        </div>
    );
};

export default EventCard;