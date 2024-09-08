import { useState, useEffect } from 'react';
import axios from 'axios';

const UseLocations = () => {
    const [locations, setLocations] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchLocations = async () => {
            const token = sessionStorage.getItem('access_token');
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/locations', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                setLocations(response.data);
            } catch (err) {
                setError(err);
            } finally {
                setLoading(false);
            }
        };

        fetchLocations();
    }, []);

    return { locations, loading, error };
};

export default UseLocations;