import axios from 'axios';
import {useEffect, useState} from 'react'

export default function usePlaylist(identifier) {
    const [playlist, setPlaylist] = useState([]);
    const [lessons, setLessons] = useState([]);
    const [hasBought, setHasBought] = useState(false)

    useEffect(() => {
        let isMounted = true;
        const getPlaylist = async () => {
            const { data } = await axios.get(`/api/playlists/${identifier}/videos`);
            if(isMounted){
                setPlaylist(data.playlist);
                setLessons(data.data)
            }
            return () => {isMounted = false};
        };

        const checkIfUserHasBought = async () => {
            const {data} = await axios.get(`/api/check-if-user-has-bought-the-series-${identifier}`);
            setHasBought(data.data)
        }

        checkIfUserHasBought();
        getPlaylist();
    }, [identifier])
    return {
        playlist,
        lessons,
        hasBought
    }
}
