import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "../auth/Login";
import Register from "../auth/Register";
import Dashboard from "../views/Dashboard";
import Home from "../views/Home";
import * as Middleware from '../middleware';
import * as Series from "../views/playlists/App";
import * as Lessons from "../views/lessons/App";
import Cart from "../views/order/Cart";
import PaymentSuccess from '../views/order/PaymentSuccess';

export default function ReactRouter() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Home />}/>
                <Route path="/series" element={<Series.Index />}/>
                <Route path="/series/:slug" element={<Series.Show />}/>
                <Route path="/series/:slug/:episode" element={<Lessons.Show />}/>
                <Route path="/login" element={<Middleware.Guest render={<Login/>} />}/>
                <Route path="/register" element={<Middleware.Guest render={<Register/>} />}/>
                <Route path="/dashboard" element={<Middleware.Authenticated render={<Dashboard/>} />}/>
                <Route path="/your-cart" element={<Middleware.Authenticated render={<Cart/>} />}/>
                <Route path="/your-payment-success" element={<Middleware.Authenticated render={<PaymentSuccess/>} />}/>
            </Routes>
        </BrowserRouter>
    )
}