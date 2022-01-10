import { useParams } from 'react-router-dom';
import { useEffect, useState } from 'react';
import axios from 'axios';
import YouTube from 'react-youtube';
import App from '../../layouts/App';
import ListOfPlaylist from '../../components/ListOfPlaylist';
import usePlaylist from '../../hooks/usePlaylist';

const Show = () => {
    const [lesson, setLesson] = useState([]);
    const [errorScreen, setErrorScreen] = useState(false);
    const { episode, slug } = useParams();
    const { playlist, lessons, hasBought } = usePlaylist(slug);

    const onReady = () => {
        console.log('Your video from youtube ready to watch')
    }

    const onStateChange = () => {
        console.log('Video State was updated');
    }

    useEffect(() => {
        const getLesson = async () => {
            try{
                const {data} = await axios.get(`/api/playlists/${slug}/${episode}`);
                setLesson(data.data);
                setErrorScreen(false);
            }catch(e){
                setErrorScreen(true);
            }
        }
        getLesson();
    }, [episode, slug])

    return (
        <App title={lesson.title}>
            <div className="bg-dark mb-5" style={{ marginTop: '-49px' }}>
                <div className="container">
                    {hasBought && !errorScreen &&
                        <YouTube
                            videoId={lesson.unique_video_id}     
                            className={``}   
                            containerClassName={'ratio ratio-16x9'}
                            onReady={onReady}
                            onStateChange={onStateChange}
                        />
                    }
                    { !hasBought && lesson.intro && !errorScreen &&
                        <YouTube
                            videoId={lesson.unique_video_id}     
                            className={``}   
                            containerClassName={'ratio ratio-16x9'}
                            onReady={onReady}
                            onStateChange={onStateChange}
                        />
                    }

                    { errorScreen && 
                    <div className="text-white p-5">
                        <div className="container">
                            You have to buy if you want to watch
                        </div>
                    </div> 
                    }
                </div>
            </div>
            <div className="container">
                <div className="row">
                    <div className="col-md-6">
                        <div className="card">
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
    )
}

export default Show;