import React from 'react'
import Login from './Login'
import Register from './Register'
import { useGetPokemonByNameQuery } from '../../redux/api.service'

// Define a functional component named MyComponent
function Authentication() {
  const { data, error, isLoading } = useGetPokemonByNameQuery('bulbasaur')

  return (
    <div>
      <div className="App">
        {error ? (
          <>Oh no, there was an error</>
        ) : isLoading ? (
          <>Loading...</>
        ) : data ? (
          <>
            <h3>{data.species.name}</h3>
            <img src={data.sprites.front_shiny} alt={data.species.name} />
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
