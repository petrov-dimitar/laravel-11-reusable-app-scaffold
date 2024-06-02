import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'

// Define a service using a base URL and expected endpoints
export const coreAPI = createApi({
  reducerPath: 'coreAPI',
  baseQuery: fetchBaseQuery({
    baseUrl: process.env.REACT_APP_BASE_URL,
    prepareHeaders: (headers) => {
      // Get the token from sessionStorage
      const token = sessionStorage.getItem('access_token')
      if (token) {
        headers.set('Authorization', `Bearer ${token}`)
      }
      return headers
    },
  }),
  endpoints: (builder) => ({
    getUsers: builder.query({
      query: () => '/users',
    }),
    login: builder.mutation({
      query: (credentials) => ({
        url: '/api/login',
        method: 'POST',
        body: credentials,
      }),
      async onQueryStarted(arg, { dispatch, queryFulfilled }) {
        try {
          const { data } = await queryFulfilled
          // Store the access token in sessionStorage
          sessionStorage.setItem('access_token', data.access_token)
        } catch (error) {
          console.error('Failed to login:', error)
        }
      },
    }),
    getLoggedInUser: builder.query({
      query: () => '/api/me',
    }),
  }),
})

// Export hooks for usage in functional components, which are
// auto-generated based on the defined endpoints
export const { useGetUsersQuery, useLoginMutation, useGetLoggedInUserQuery } =
  coreAPI
