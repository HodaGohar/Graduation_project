import React from 'react';
import { Link } from 'react-router-dom';
import { FaHome, FaInfoCircle, FaUsers, FaSignOutAlt } from 'react-icons/fa';

const Dashboard = () => {
    const handleLogout = () => {
        // Implement your logout logic here
    };

    return (
        <div>
            <div>
                <Link to="/">
                    <FaHome />
                    Home
                </Link>
            </div>
            <div>
                <Link to="/about">
                    <FaInfoCircle />
                    About
                </Link>
            </div>
            <div>
                <Link to="/teams">
                    <FaUsers />
                    Teams
                </Link>
            </div>
            <div>
                <button onClick={handleLogout}>
                    <FaSignOutAlt />
                    Logout
                </button>
            </div>
        </div>
    );
};

export default Dashboard;