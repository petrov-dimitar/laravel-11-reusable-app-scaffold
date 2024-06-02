import React, { useState } from 'react'
import Login from './Login'
import Register from './Register'
import UserProfile from './UserProfile'
import { useGetUsersQuery } from '../../redux/api.service'

function Authentication() {
  const { data, error, isLoading } = useGetUsersQuery()
  const [isLoggedIn, setIsLoggedIn] = useState(
    !!sessionStorage.getItem('access_token'),
  )

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
      {isLoggedIn ? (
        <UserProfile />
      ) : (
        <>
          <Login onLoginSuccess={() => setIsLoggedIn(true)} />
          <Register />
        </>
      )}
    </div>
  )
}

export default Authentication
