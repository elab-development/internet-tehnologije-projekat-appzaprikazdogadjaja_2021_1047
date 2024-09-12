import React from 'react';
import './Card.css';
import axios from 'axios';
import { FaTrashCan } from "react-icons/fa6";

const Card = ({ event, onDelete }) => {
   
    const handleDelete = async () => {
        const token = sessionStorage.getItem('access_token');
        try {
            await axios.delete(`http://127.0.0.1:8000/api/events/${event.id}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            onDelete(event.id);
        } catch (err) {
            console.error('Error deleting event:', err);
        }
    };

    return (
        <div className="events-card">
            <button onClick={handleDelete} className="delete-button"><FaTrashCan/></button>
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