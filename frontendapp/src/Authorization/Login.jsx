import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Login.css';

const Login = ({ onLogin }) => {
    const [email, setEmail] = useState('liza.wilkinson@example.net');
    const [password, setPassword] = useState('password');
    const [error, setError] = useState('');
    const navigate= useNavigate();
    const handleLogin = async (e) => {
        e.preventDefault();
        setError('');

        try {
            const response = await axios.post('http://localhost:8000/api/login', {
                email,
                password
            });
            console.log('Login successful:', response.data);
            onLogin(response.data.user,response.data.access_token);
            navigate("/events")
        } catch (err) {
            console.error('Login failed:', err.response.data);
            setError('Invalid credentials. Please try again.');
        }
    };

    return (
        <div className="login-page">
            <div className="login-container">
                <h2>Login</h2>
                <form onSubmit={handleLogin}>
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                    </div>
                    {error && <p className="error">{error}</p>}
                    <button className='buttonLogin' type="submit">Login</button>
                </form>
            </div>
        </div>
    );
};

export default Login;