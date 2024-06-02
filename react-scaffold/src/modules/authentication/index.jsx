import React from 'react'
import Login from './Login'
import Register from './Register'
import { useGetUsersQuery } from '../../redux/api.service'

// Define a functional component named MyComponent
function Authentication() {
  const { data, error, isLoading } = useGetUsersQuery()

  return (
    <div>
      <div className="App">
        {error ? (
          <>Oh no, there was an error</>
        ) : isLoading ? (
          <>Loading...</>
        ) : data ? (
          <>
            <h3>{JSON.stringify(data)}</h3>
          </>
        ) : null}
      </div>
      <h1>Authentication View</h1>
      <Login />
      <Register />
    </div>
  )
}

export default Authentication
