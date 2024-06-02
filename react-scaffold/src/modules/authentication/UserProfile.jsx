import React from 'react'
import { useGetLoggedInUserQuery } from '../../redux/api.service'

const UserProfile = () => {
  const { data: user, error, isLoading } = useGetLoggedInUserQuery()

  const handleLogout = () => {
    // Clear the access token from sessionStorage
    sessionStorage.removeItem('access_token')
    // Redirect to the login page or update the login state
    // For simplicity, let's reload the page to reset the app state
    window.location.reload()
  }

  if (isLoading) return <p>Loading...</p>
  if (error) return <p>Error fetching user data: {error.message}</p>

  return (
    <div>
      <h1>User Profile</h1>
      <p>Name: {user.name}</p>
      <p>Email: {user.email}</p>
      <button onClick={handleLogout}>Logout</button>
    </div>
  )
}

export default UserProfile
