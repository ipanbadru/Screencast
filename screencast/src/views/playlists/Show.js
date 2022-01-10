import { useState, useEffect, React } from "react";
import axios from 'axios';
import App from "../../layouts/App";
import Header from "../../components/Header";
import { Link, useParams } from "react-router-dom";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { useRecoilState } from "recoil";
import { aNumberOfCart } from "../../store";
import ListOfPlaylist from "../../components/ListOfPlaylist";
import usePlaylist from "../../hooks/usePlaylist";

function Show() {
    const [numberOfCart, setANumberOfCart] = useRecoilState(aNumberOfCart);
    const {slug} = useParams();
    const {playlist, lessons, hasBought} = usePlaylist(slug)

    const addToCartHandler = async () => {
        try{
            let {data} = await axios.post(`/api/add-to-cart/${playlist.slug}`);
            toast.success(data.message, {
                position: 'top-left',
                autoClose: 1700,
                pauseOnHover: false,
                hideProgressBar: true
            });
            setANumberOfCart(cart => [...cart, data.data]);
        }catch (error) {
            toast.error(error.response.data.message, {
                position: 'top-left',
                autoClose: 1700,
                pauseOnHover: false,
                hideProgressBar: true
            });
        }
    }
    return (
        <div>
            <App title="Series">
                <Header title={playlist.name}>
                    {playlist.description}
                    <div className="mt-4">
                        <Link to={`/series/${playlist.slug}/1`} className="btn btn-secondary me-2">Watch</Link>
                        { !hasBought &&
                        <button onClick={addToCartHandler} className="btn btn-primary">Add to cart</button>
                        }
                    </div>
                </Header>
                <div className="container">
                    <div className="row">
                        <div className="col-md-6">
                            <div className="card" style={{ marginTop: -80 }}>
                                <div className="card-header bg-white border-bottom">
                                    {playlist.name}
                                </div>
                                <div className="card-body">
                                    <ListOfPlaylist playlist={playlist.slug} lessons={lessons}/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </App>
            <ToastContainer />
        </div>
    )
}

export default Show;