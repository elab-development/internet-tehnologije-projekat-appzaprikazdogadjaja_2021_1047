import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './Login.css';

const Login = ({ onLogin }) => {
    const [email, setEmail] = useState('liza.wilkinson@example.net');
    const [password, setPassword] = useState('password');
    const [error, setError] = useState('');
    const [showResetForm, setShowResetForm] = useState(false);
    const [resetEmail, setResetEmail] = useState('');
    const [newPassword, setNewPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        setError('');

        try {
            const response = await axios.post('http://localhost:8000/api/login', {
                email,
                password
            });
            console.log('Login successful:', response.data);
            onLogin(response.data.user, response.data.access_token);
            navigate("/events");
        } catch (err) {
            console.error('Login failed:', err.response.data);
            setError('Invalid credentials. Please try again.');
        }
    };

    const handlePasswordReset = async (e) => {
        e.preventDefault();
        setError('');

        try {
            const response = await axios.post('http://localhost:8000/api/reset-password', {
                email: resetEmail,
                password: newPassword,
                password_confirmation: confirmPassword
            });
            console.log('Password reset successful:', response.data);
            setShowResetForm(false);
            alert('Password reset successfully. You can now log in with your new password.');
        } catch (err) {
            console.error('Password reset failed:', err.response.data);
            setError('Failed to reset password. Please try again.');
        }
    };

    return (
        <div className="login-page">
            <div className="login-container">
                <h2>{showResetForm ? 'Reset Password' : 'Login'}</h2>
                {showResetForm ? (
                    <form onSubmit={handlePasswordReset} className='login-form'>
                        <div className="form-group">
                            <label htmlFor="reset-email">Email</label>
                            <input
                                type="email"
                                id="reset-email"
                                value={resetEmail}
                                onChange={(e) => setResetEmail(e.target.value)}
                                required
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="new-password">New Password</label>
                            <input
                                type="password"
                                id="new-password"
                                value={newPassword}
                                onChange={(e) => setNewPassword(e.target.value)}
                                required
                            />
                        </div>
                        <div className="form-group">
                            <label htmlFor="confirm-password">Confirm Password</label>
                            <input
                                type="password"
                                id="confirm-password"
                                value={confirmPassword}
                                onChange={(e) => setConfirmPassword(e.target.value)}
                                required
                            />
                        </div>
                        {error && <p className="error">{error}</p>}
                        <button className='buttonLogin' type="submit">Reset Password</button>
                        <div className='back-to-login-button-div'>
                        <button className='buttonCancel' type="button" onClick={() => setShowResetForm(false)}>Back to Login</button>
                        </div>
                    </form>
                ) : (
                    <form onSubmit={handleLogin} className='login-form'>
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
                        <div className='forgot-pass-label-div'>
                            <label className='forgot-pass-label' onClick={() => setShowResetForm(true)}>Forgot password?</label>
                        </div>
                    </form>
                )}
            </div>
        </div>
    );
};

export default Login;