import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './HomePage.css';
import EventCard from './EventCard';
import CategoryCard from './CategoryCard';

const HomePage = () => {
    const [eventImages, setEventImages] = useState([]);
    const [categoryImages, setCategoryImages] = useState([]);

    useEffect(() => {
        const fetchImages = async () => {
            const eventKeywords = ['concert', 'art exhibition', 'sports event', 'business event'];
            const categoryKeywords = ['music', 'art', 'sports', 'business'];

            const fetchEventImages = eventKeywords.map((keyword, index) =>
                axios.get(`https://picsum.photos/400/300?random=${index}`)
            );
            const fetchCategoryImages = categoryKeywords.map((keyword, index) =>
                axios.get(`https://picsum.photos/200/200?random=${index}`)
            );

            try {
                const eventResponses = await Promise.all(fetchEventImages);
                const categoryResponses = await Promise.all(fetchCategoryImages);

                setEventImages(eventResponses.map(response => response.request.responseURL));
                setCategoryImages(categoryResponses.map(response => response.request.responseURL));
            } catch (error) {
                console.error('Error fetching images from Lorem Picsum API', error);
            }
        };

        fetchImages();
    }, []);

    return (
        <div className="homepage">
            <header className="header">
                <h1>Belgrade Events 2024</h1>
                <p>Discover the best events happening in Belgrade</p>
            </header>
            <section className='welcome'>
                <h1>One place for all events</h1>
            </section>
            <section className="categories">
                <h2>Event Categories</h2>
                <div className="category-cards">
                    {categoryImages.map((image, index) => (
                        <div className="category-card" key={index}>
                            <img src={image} alt={`Category ${index + 1}`} />
                            <h3>{['Music', 'Art', 'Sports' , 'Business'][index]}</h3>
                        </div>
                    ))}
                </div>
            </section>
            <section className="events-highlight">
                <h2>Fameous Events</h2>
                <div className="event-cards">
                    {eventImages.map((image, index) => (
                        <EventCard
                        key={index}
                        image={image}
                        title={`Event Title ${index + 1}`}
                        description="Event description goes here."
                    />
                    ))}
                </div>
            </section>
            <footer className="footer">
                <p>© Belgrade Events 2024. All rights reserved.</p>
            </footer>
        </div>
    );
};

export default HomePage;