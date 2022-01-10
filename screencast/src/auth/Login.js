import { useState } from "react";
import App from "../layouts/App";
import axios from 'axios';
import { useNavigate } from "react-router-dom";
import { useRecoilState } from "recoil";
import { authenticatedUser } from "../store";

const Login =  () => {
    const navigate = useNavigate();
    const [auth, setAuth] = useRecoilState(authenticatedUser);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [errors, setErrors] = useState([]);
    let credentials = {email, password};
    const submitHandler = async (e) => {
        e.preventDefault();
        try{
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('/login', credentials);
            let { data } = await axios.get('/api/me');
            setAuth({user: data.data, check: true});
            navigate('/dashboard');
        }catch({ response }){
            setErrors(response.data.errors);
        }
    }
    return (
        <App title="Login">
            <div className="container">
                <div className="row">
                    <div className="col-md-4">
                        <div className="card">
                            <div className="card-header">Login</div>
                            <div className="card-body">
                                <form onSubmit={submitHandler}>
                                    <div className="mb-3">
                                        <label htmlFor="email" className="form-label">Email</label>
                                        <input type="email" value={email} onChange={e => setEmail(e.target.value)} name="email" id="email" className="form-control" />
                                        { errors.email && <span className="text-danger mt-1">{ errors.email[0] }</span> }
                                    </div>
                                    <div className="mb-3">
                                        <label htmlFor="password" className="form-label">Password</label>
                                        <input type="password" value={password} onChange={e => setPassword(e.target.value)} name="password" id="password" className="form-control" />
                                        { errors.password && <span className="text-danger mt-1">{ errors.password[0] }</span> }
                                    </div>
                                    <button type="submit" className="btn btn-primary">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </App>
    )
}

export default Login;