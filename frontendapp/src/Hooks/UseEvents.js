import { useState, useEffect } from 'react';
import axios from 'axios';

const UseEvents = () => {
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchEvents = async () => {
            const token = sessionStorage.getItem('access_token');
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/events', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                setEvents(response.data);
            } catch (err) {
                setError(err);
            } finally {
                setLoading(false);
            }
        };

        fetchEvents();
    }, []);

    return { events, setEvents, loading, error };
};

export default UseEvents;