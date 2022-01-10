import App from "../layouts/App";
import { authenticatedUser } from "../store";
import { useRecoilValue } from 'recoil';

function Dashboard() {
    const auth = useRecoilValue(authenticatedUser);
    return (
        <App title="Dashboard">
            <div className="container">
                Welcome to dashboard {auth.user.name}
            </div>
        </App>
    )
}

export default Dashboard;