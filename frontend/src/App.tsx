import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import { Home } from './pages/Home';
import { Board } from './pages/Board';
import { Thread } from './pages/Thread';
import './App.css';

function App() {
  return (
    <Router>
      <div className="App">
        <header>
          <nav>
            <Link to="/">Home</Link> | <Link to="/soy/">/soy/</Link> | <Link to="/qa/">/qa/</Link> | <Link to="/pol/">/pol/</Link> 
          </nav>
        </header>
        <main style={{ padding: '2rem' }}>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/:board/*" element={<Board />} />
            <Route path="/:board/thread/:threadId" element={<Thread />} />
          </Routes>
        </main>
      </div>
    </Router>
  );
}

export default App;

