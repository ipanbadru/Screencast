import axios from 'axios';
import { useRecoilState } from 'recoil'
import App from '../../layouts/App'
import { aNumberOfCart } from '../../store';
import { useEffect, useState } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { Link } from 'react-router-dom';

export default function Cart() {
    const [carts, setCarts] = useRecoilState(aNumberOfCart);
    const [total, setTotal] = useState('');
    const removeCartHandler = async (index) => {
        const { data } = await  axios.delete(`/api/remove-cart/${carts[index].id}`);
        toast.success(data.message, {
            position: 'top-left',
            autoClose: 1700,
            pauseOnHover: false,
            hideProgressBar: true
        });
        setCarts(carts.filter(i => i !== carts[index]));
    }

    const checkoutHandler = async () => {
        const {data} = await axios.post('/api/orders/create');
        window.open(data.redirect_url);
    }

    useEffect(() => {
        let getTotal = carts.reduce((x, y) => x + y.price, 0);
        setTotal(getTotal);
    }, [total, carts]);

    return (
        <div>
            <App title="Your Carts">
                <div className="container">
                    { carts.length > 0 ? 
                        <div className="row">
                            <div className="col-md-8">
                                <div className="card">
                                    <div className="card-header">
                                        <span className="badge bg-primary">{carts.length}</span>
                                        <span className="ms-2">Your Cart</span>
                                    </div>
                                    <div className="card-body">
                                        <table className="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Playlist Name</th>
                                                    <th>Price</th>
                                                    <th>remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                { carts.map((cart, index) => (
                                                    <tr key={index}>
                                                        <td>{index + 1}</td>
                                                        <td>{cart.playlist.name}</td>
                                                        <td className="text-end">Rp. {cart.price}</td>
                                                        <td>
                                                            <button onClick={() => removeCartHandler(index)} className="btn btn-danger btn-sm">Remove</button>
                                                        </td>
                                                    </tr>
                                                )) }
                                                <tr>
                                                    <td colSpan="2"></td>
                                                    <td className="text-end">Rp. {total}</td>
                                                    <td>
                                                        <button onClick={checkoutHandler} className="btn btn-primary btn-sm">Checkout</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    : 
                        <div className="alert alert-info">Your Cart is empty, Please buy atleast one <Link to="/series">Playlists</Link></div>
                    }
                </div>
            </App>
            <ToastContainer />
        </div>
    )
}