import logo from './logo.svg';
import './App.css';
import HomePage from './HomePage/HomePage';
import Login from './Authorization/Login';
import Register from './Authorization/Register';
import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Navbar from './Navigation/Navbar';
import Events from './Events/Events';
import CreateEvent from './Events/CreateEvent';
import AdminUsers from './Admin/AdminUsers';

function App() {

  const [user, setUser] = useState(null);

  useEffect(() => {
    const storedUser = sessionStorage.getItem('user');
    const storedToken = sessionStorage.getItem('access_token');
    if (storedUser && storedToken) {
      setUser(JSON.parse(storedUser));
    }
  }, []);

  const handleLogin = (userData, token) => {
    setUser(userData);
    sessionStorage.setItem('user', JSON.stringify(userData));
    sessionStorage.setItem('access_token', token);
  };

  const handleLogout = () => {
    setUser(null);
    sessionStorage.removeItem('user');
    sessionStorage.removeItem('access_token');
  };

  const isAdmin = user?.roles?.some(role => role.id === 1);

  return (
    <Router>
      <div className="App">
      <Navbar user={user} onLogout={handleLogout} />
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/login" element={<Login onLogin={handleLogin} />} />
          <Route path="/register" element={<Register />} />
          <Route path="/events" element={<Events user={user} />} />
          {isAdmin && (
                <Route path="/admin/users" element={<AdminUsers />} />
            )}
          <Route path="/events/create" element={<CreateEvent />} />
          <Route path="/edit-event/:id" element={<CreateEvent />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
