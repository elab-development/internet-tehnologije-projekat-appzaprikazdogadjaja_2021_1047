import logo from './logo.svg';
import './App.css';
import HomePage from './HomePage/HomePage';
import Login from './Authorization/Login';
import Register from './Authorization/Register';

function App() {
  return (
    <div className="App">
      <Register></Register>
      <Login />
      <HomePage></HomePage>
    </div>
  );
}

export default App;
