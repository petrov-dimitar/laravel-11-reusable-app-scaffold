import React, { useState } from 'react'
import { useSelector } from 'react-redux'
import {
  TextField,
  Select,
  MenuItem,
  FormControl,
  InputLabel,
  Button, // Import Button component
  Avatar,
} from '@mui/material'
import {
  useGetBanksByCountryQuery,
  useCreateAgreementMutation,
} from '../../redux/api.service'

function GoCardlessFlowPage() {
  const user = useSelector((state) => state.user.user)
  const [country, setCountry] = useState('')
  const [selectedBank, setSelectedBank] = useState(null) // Track selected bank
  const { data: banks, isLoading } = useGetBanksByCountryQuery(country, {
    skip: !country,
  })

  // Mutation hook for createAgreement
  const [createAgreement, { data, isLoading: isCreatingAgreement }] =
    useCreateAgreementMutation()

  const handleCountryChange = (event) => {
    setCountry(event.target.value)
  }

  const handleBankSelect = (event) => {
    setSelectedBank(event.target.value)
  }

  const generateRandomNumber = () => {
    // Generate a random number between 10000 and 99999
    return Math.floor(10000 + Math.random() * 90000).toString()
  }

  const handleCreateAgreement = () => {
    if (selectedBank) {
      // Generate a random reference number
      const referenceNumber = generateRandomNumber()

      // Trigger the mutation with selected bank data and the generated reference number
      createAgreement({
        redirect: 'http://localhost:3000/complete-agreement',
        institution_id: selectedBank.id,
        reference: referenceNumber,
        max_historical_days: 30,
        access_valid_for_days: 90,
        access_scope: ['balances', 'details', 'transactions'],
        user_language: 'en',
      })
    }
  }

  const avatarStyle = {
    width: 24,
    height: 24,
    marginRight: 8,
  }

  return (
    <div>
      <h1>Go Cardless Flow</h1>
      {user && (
        <div>
          <p>User Name: {user.name}</p>
          <p>User Email: {user.email}</p>
          <TextField
            label="Go Cardless Token"
            value={user.gocardless_token || ''}
            multiline
            rows={4}
            variant="outlined"
            fullWidth
            InputProps={{
              readOnly: true,
            }}
          />
          <FormControl fullWidth margin="normal">
            <InputLabel>Country</InputLabel>
            <Select value={country} onChange={handleCountryChange}>
              <MenuItem value="bg">Bulgaria</MenuItem>
              <MenuItem value="gb">United Kingdom</MenuItem>
              {/* Add other countries as needed */}
            </Select>
          </FormControl>
          {country &&
            (isLoading ? (
              <p>Loading banks...</p>
            ) : (
              <FormControl fullWidth margin="normal">
                <InputLabel>Bank</InputLabel>
                <Select value={selectedBank} onChange={handleBankSelect}>
                  {banks?.map((bank) => (
                    <MenuItem key={bank.id} value={bank}>
                      <div
                        style={{
                          display: 'flex',
                          justifyContent: 'space-between',
                        }}
                      >
                        <Avatar
                          src={bank.logo}
                          alt={bank.name}
                          style={avatarStyle}
                        />
                        <div>{bank.name}</div>
                      </div>
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            ))}
          {/* Button to initiate createAgreement */}
          <Button
            variant="contained"
            color="primary"
            onClick={handleCreateAgreement}
            disabled={!selectedBank || isCreatingAgreement}
          >
            {isCreatingAgreement ? 'Creating Agreement...' : 'Create Agreement'}
          </Button>
          {/* Display the link if data contains a link */}
          {data && (
            <div>
              <a href={data.link} target="_blank" rel="noopener noreferrer">
                {data.link}
              </a>
            </div>
          )}
        </div>
      )}
    </div>
  )
}

export default GoCardlessFlowPage
