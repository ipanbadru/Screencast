import Navigation from "../components/Navigation";

function App(props) {
    document.title = props.title;
    return (
        <div>
            <Navigation />
            <main className="pt-5">
                {props.children}
            </main>

            <div className="mt-5 py-4 bg-light border">
                <div className="container">
                    Since 1987 &trade;
                </div>
            </div>
        </div>
    )
}

export default App;