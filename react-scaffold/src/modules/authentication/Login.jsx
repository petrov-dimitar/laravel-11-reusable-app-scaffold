import React from 'react'

import TextField from '@mui/material/TextField'
// Define a functional component named MyComponent
function Login() {
  return (
    <div>
      <h1>Hello, React!</h1>
      <TextField id="filled-basic" label="Filled" variant="filled" />
      <TextField id="standard-basic" label="Standard" variant="standard" />
    </div>
  )
}

export default Login
