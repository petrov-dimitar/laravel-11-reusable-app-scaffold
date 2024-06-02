import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'

export const coreAPI = createApi({
  reducerPath: 'coreAPI',
  baseQuery: fetchBaseQuery({
    baseUrl: process.env.REACT_APP_BASE_URL,
    prepareHeaders: (headers) => {
      const token = sessionStorage.getItem('access_token')
      if (token) {
        headers.set('Authorization', `Bearer ${token}`)
      }
      return headers
    },
  }),
  endpoints: (builder) => ({
    // Existing endpoints...
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
          sessionStorage.setItem('access_token', data.access_token)
        } catch (error) {
          console.error('Failed to login:', error)
        }
      },
    }),
    getLoggedInUser: builder.query({
      query: () => '/api/me',
    }),
    // New endpoint for fetching transactions
    getTransactions: builder.query({
      query: () => '/api/transactions',
    }),
  }),
})

export const {
  useGetUsersQuery,
  useLoginMutation,
  useGetLoggedInUserQuery,
  useGetTransactionsQuery,
} = coreAPI
