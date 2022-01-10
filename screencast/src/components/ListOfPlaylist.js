import { Link } from "react-router-dom";

export default function ListOfPlaylist({playlist, lessons}) {
    return (
        <ol className="m-0 py-1">
            { lessons.map((lesson, index) => (
                <li key={index} className="my-2">
                    <Link to={`/series/${playlist}/${lesson.episode}`} key={index} className="text-decoration-none text-dark">
                        {lesson.title}
                    </Link>
                </li>
            )) }
        </ol>
    )
}
