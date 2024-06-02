import React, { useState } from 'react'
import TextField from '@mui/material/TextField'
import Button from '@mui/material/Button'
import { useLoginMutation } from '../../redux/api.service'

const Login = ({ onLoginSuccess }) => {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [login, { isLoading, error }] = useLoginMutation()

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      await login({ email, password }).unwrap()
      onLoginSuccess()
    } catch (err) {
      console.error('Failed to login', err)
    }
  }

  return (
    <div>
      <h1>Login</h1>
      <form onSubmit={handleSubmit}>
        <div>
          <TextField
            id="email"
            label="Email"
            variant="standard"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            fullWidth
          />
        </div>
        <div>
          <TextField
            id="password"
            label="Password"
            type="password"
            variant="standard"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            fullWidth
          />
        </div>
        <div>
          <Button
            type="submit"
            variant="contained"
            color="primary"
            disabled={isLoading}
          >
            {isLoading ? 'Logging in...' : 'Login'}
          </Button>
        </div>
        {error && (
          <p style={{ color: 'red' }}>Failed to login: {error.message}</p>
        )}
      </form>
    </div>
  )
}

export default Login
