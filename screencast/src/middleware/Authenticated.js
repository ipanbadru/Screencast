import { useNavigate } from "react-router-dom";
import { useEffect } from "react";
import { useRecoilValue } from "recoil";
import { authenticatedUser } from "../store";

function Authenticated(props) {
    const auth = useRecoilValue(authenticatedUser);
    const navigate = useNavigate();
    useEffect(() => {
        if(!auth.check){
            navigate('/login');
        }
    }, [auth])
    return props.render;
}

export default Authenticated;