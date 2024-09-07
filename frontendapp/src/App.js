import logo from './logo.svg';
import './App.css';
import HomePage from './HomePage/HomePage';
import Login from './Authorization/Login';

function App() {
  return (
    <div className="App">
      <Login />
      <HomePage></HomePage>
    </div>
  );
}

export default App;
