import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'
import { setUser } from './slicers/userSlice'

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
      async onQueryStarted(arg, { dispatch, queryFulfilled }) {
        try {
          const { data } = await queryFulfilled
          dispatch(setUser(data))
        } catch (error) {
          console.error('Failed to fetch logged in user:', error)
        }
      },
    }),
    getTransactions: builder.query({
      query: () => '/api/transactions',
    }),
    getBanksByCountry: builder.query({
      query: (country) => ({
        url: `api/banks/${country}`,
        method: 'GET',
      }),
    }),
    // Add the createAgreement endpoint
    createAgreement: builder.mutation({
      query: (requestData) => ({
        url: '/api/gocardless/agreement',
        method: 'POST',
        body: requestData,
      }),
    }),
  }),
})

export const {
  useGetUsersQuery,
  useLoginMutation,
  useGetLoggedInUserQuery,
  useGetTransactionsQuery,
  useGetBanksByCountryQuery,
  useCreateAgreementMutation, // Add this line to access the createAgreement mutation hook
} = coreAPI
