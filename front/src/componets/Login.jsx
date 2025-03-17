import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';


const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();

    const handleLogin = async () => {
        try {
            const response = await axios.post(
                'http://localhost:8000/api/users/login',
                { email, password },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }
            );

            if (response.data.success) {
                console.log(response.data);
                alert('Login successful!');
                navigate('/dashbord'); // تأكد من أن لديك هذه الصفحة
            } else {
                alert(response.data.message || 'Login failed. Please check your credentials.');
            }
        } catch (error) {
            console.error('An error occurred during login:', error);

            // عرض رسالة خطأ واضحة
            if (error.response) {
                alert(`Login failed: ${error.response.data.message || 'Server error'}`);
            } else {
                alert('An error occurred during login. Please try again later.');
            }
        }
    };

    return (
        <div>
            <h2>Login</h2>
            <form onSubmit={(e) => e.preventDefault()}>
                <div>
                    <label>Email:</label>
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Password:</label>
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                    />
                </div>
                <button type="button" onClick={handleLogin}>
                    Login
                </button>
            </form>
        </div>
    );
};

export default Login;
