import React, { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import axios from 'axios';
import './CreateEvent.css';
import UseCategories from '../Hooks/UseCategories';
import UseLocations from '../Hooks/UseLocations';


const CreateEvent = () => {
    const { categories, loading: loadingCategories, error: errorCategories } = UseCategories();
    const { locations, loading: loadingLocations, error: errorLocations } = UseLocations();
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [startDate, setStartDate] = useState('');
    const [endDate, setEndDate] = useState('');
    const [locationId, setLocationId] = useState('');
    const [categoryId, setCategoryId] = useState('');
    const [url, setUrl] = useState('');
    const [image, setImage] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const { id } = useParams();
    const isEditing = Boolean(id);

    useEffect(() => {
        if (isEditing) {
            const fetchEvent = async () => {
                const token = sessionStorage.getItem('access_token');
                try {
                    const response = await axios.get(`http://127.0.0.1:8000/api/events/${id}`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                    const event = response.data;
                    setTitle(event.title);
                    setDescription(event.description);
                    setStartDate(event.start_date);
                    setEndDate(event.end_date);
                    setLocationId(event.location.id);
                    setCategoryId(event.category.id);
                    setUrl(event.url);
                    setImage(event.image);
                } catch (error) {
                    setError('Error fetching event data.');
                    console.error(error);
                }
            };
            fetchEvent();
        }
    }, [id, isEditing]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        const token = sessionStorage.getItem('access_token');

        const eventData = {
            title,
            description,
            start_date: startDate,
            end_date: endDate,
            location_id: locationId,
            category_id: categoryId,
            reference_id: 1,  // Default source ID
            url,
            image
        };
        try {
            if (isEditing) {
                await axios.put(`http://127.0.0.1:8000/api/events/${id}`, eventData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                console.log('Event updated successfully');
            } else {
                await axios.post('http://127.0.0.1:8000/api/events', eventData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                console.log('Event created successfully');
            }
            navigate('/events');
        } catch (err) {
            console.error('Error creating event:', err.response.data);
            setError('Error submitting event.');
            console.error(err);
        }
    };

    if (loadingCategories || loadingLocations) return <p>Loading data...</p>;
    if (errorCategories) return <p>Error loading categories: {errorCategories.message}</p>;
    if (errorLocations) return <p>Error loading locations: {errorLocations.message}</p>;

    return (
        <div className="create-event-page">
            <div className="create-event-container">
            <h2>{isEditing ? 'Edit Event' : 'Create Event'}</h2>
            {error && <p className="error">{error}</p>}
                <form onSubmit={handleSubmit}>
                    <div className="form-group2">
                        <label htmlFor="title">Title</label>
                        <input
                            type="text"
                            id="title"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group2">
                        <label htmlFor="description">Description</label>
                        <input
                            type="text"
                            id="description"
                            value={description}
                            onChange={(e) => setDescription(e.target.value)}
                        />
                    </div>
                    <div className="form-group2">
                        <label htmlFor="startDate">Start Date</label>
                        <input
                            type="date"
                            id="startDate"
                            value={startDate}
                            onChange={(e) => setStartDate(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group2">
                        <label htmlFor="endDate">End Date</label>
                        <input
                            type="date"
                            id="endDate"
                            value={endDate}
                            onChange={(e) => setEndDate(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group2">
                        <label htmlFor="locationId">Location</label>
                        <select
                            id="locationId"
                            value={locationId}
                            onChange={(e) => setLocationId(e.target.value)}
                            required
                        >
                            <option location="">Select Location</option>
                            {locations.map((location) => (
                                <option key={location.id} value={location.id}>
                                    {location.name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="form-group2">
                        <label htmlFor="categoryId">Category</label>
                        <select
                            id="categoryId"
                            value={categoryId}
                            onChange={(e) => setCategoryId(e.target.value)}
                            required
                        >
                            <option value="">Select Category</option>
                            {categories.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="form-group2">
                        <label htmlFor="url">URL</label>
                        <input
                            type="url"
                            id="url"
                            value={url}
                            onChange={(e) => setUrl(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group2">
                        <label htmlFor="image">Image URL</label>
                        <input
                            type="url"
                            id="image"
                            value={image}
                            onChange={(e) => setImage(e.target.value)}
                        />
                    </div>
                    <button className='buttonCreateUpdateEvent' type="submit">{isEditing ? 'Update Event' : 'Create Event'}</button>
                </form>
            </div>
        </div>
    );
};

export default CreateEvent;