import logo from './logo.svg'
import './App.css'
import Authentication from './modules/authentication'
import TransactionTable from './modules/transactions'
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Navigate,
  Link,
} from 'react-router-dom'
import { AppBar, Toolbar, Button } from '@mui/material'
import { useGetLoggedInUserQuery } from './redux/api.service'
import GoCardlessFlowPage from './modules/goCardless'
import WebSocketComponent from './modules/example/WebSocketComponent'

function App() {
  const { data: loggedInUser } = useGetLoggedInUserQuery() // Check if the user is logged in

  return (
    <div className="App">
      <Router>
        <AppBar position="static">
          <WebSocketComponent />
          <Toolbar>
            <div
              style={{
                flexGrow: 1,
              }}
            >
              <Button component={Link} to="/transactions" color="inherit">
                Transactions
              </Button>
              <Button component={Link} to="/authentication" color="inherit">
                Authentication
              </Button>
            </div>

            <Button component={Link} to="/new-account" color="inherit">
              Add New Account
            </Button>
            {/* Add more navigation buttons as needed */}
          </Toolbar>
        </AppBar>

        <body
          style={{
            padding: '16px',
          }}
        >
          <Routes>
            <Route
              path="/transactions"
              element={
                loggedInUser ? (
                  <TransactionTable />
                ) : (
                  <Navigate to="/authentication" />
                )
              }
            />
            <Route path="/authentication" element={<Authentication />} />
            <Route path="/new-account" element={<GoCardlessFlowPage />} />

            {/* Define other routes here */}
            <Route path="/" element={<Navigate to="/transactions" />} />
          </Routes>
        </body>
      </Router>
    </div>
  )
}

export default App
