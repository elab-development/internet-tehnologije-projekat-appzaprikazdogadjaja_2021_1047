import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Navbar.css';

const Navbar = ({ user, onLogout }) => {
    const navigate = useNavigate();

    const handleLogout = async () => {
        try {
            const token = sessionStorage.getItem('access_token');
            await axios.post('http://localhost:8000/api/logout', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            onLogout();
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('access_token');
            navigate('/login');
        } catch (error) {
            console.error('Logout failed:', error);
        }
    };
    return (
        <nav className="navbar">
            <div className="navbar-brand">
                <Link to="/">Welcome to Belgrade Events 2024</Link>
            </div>
            <ul className="navbar-links">
                <li>
                    <Link to="/">Home</Link>
                </li>
                {!user ? (
                    <>
                        <li>
                            <Link to="/login">Login</Link>
                        </li>
                        <li>
                            <Link to="/register">Register</Link>
                        </li>
                    </>
                ) : (
                    <>
                        <li>
                            <span>Welcome, {user.name}</span>
                        </li>
                        <li>
                            <button onClick={handleLogout}>Logout</button>
                        </li>
                    </>
                )}
            </ul>
        </nav>
    );
};

export default Navbar;
