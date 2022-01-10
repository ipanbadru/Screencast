import ReactRouter from "./router";
import { useRecoilState, useSetRecoilState } from 'recoil';
import { aNumberOfCart, authenticatedUser } from "./store";
import { useEffect } from "react";
import axios from "axios";
import { useState } from "react";

function App(){
  const [mounted, setMounted] = useState(false)
  const setAuth = useSetRecoilState(authenticatedUser);
  const [numberOfCart, setANumberOfCart] = useRecoilState(aNumberOfCart);
  useEffect(() => {
    const getUser = async () => {
      setMounted(false)
      try{
        let { data } = await axios.get('/api/me');
        setAuth({ user: data.data, check: true });
      } catch {
        // console.log('You are not log in');
      }
      setMounted(true)
    }
    const getCarts = async () => {
      let { data } = await axios.get('/api/carts');
      setANumberOfCart(data.data);
    }

    getCarts();
    getUser();
  }, [setAuth])
  if(!mounted){
    return <div className="d-flex justify-content-center align-items-center min-vh-100">Loading.....</div>
  }
  return (
    <div>
      <ReactRouter />
    </div>
  )
}

export default App;