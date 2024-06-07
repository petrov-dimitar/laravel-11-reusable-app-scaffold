import React, { useState } from 'react'
import { useSelector } from 'react-redux'
import {
  TextField,
  Select,
  MenuItem,
  FormControl,
  InputLabel,
  ListItemIcon,
  Avatar,
  ListItemText,
} from '@mui/material'
import { useGetBanksByCountryQuery } from '../../redux/api.service'

function GoCardlessFlowPage() {
  const user = useSelector((state) => state.user.user)
  const [country, setCountry] = useState('')

  const { data: banks, isLoading } = useGetBanksByCountryQuery(country, {
    skip: !country,
  })

  const handleCountryChange = (event) => {
    setCountry(event.target.value)
  }

  const avatarStyle = {
    width: 24,
    height: 24,
    marginRight: 8, // Adjust margin as needed
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
                <Select>
                  {banks?.map((bank) => (
                    <MenuItem key={bank.id} value={bank.id}>
                      <div
                        style={{
                          display: 'flex',
                          justifyContent: 'space-between',
                        }}
                      >
                        {/* Logo at the start */}
                        <Avatar
                          src={bank.logo}
                          alt={bank.name}
                          style={avatarStyle}
                        />

                        <div>{bank.name}</div>
                        {/* Uncomment below to position the logo at the end */}
                        {/* {bank.name}
                      <ListItemIcon>
                        <Avatar src={bank.logo} alt={bank.name} style={avatarStyle} />
                      </ListItemIcon> */}
                      </div>
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            ))}
        </div>
      )}
    </div>
  )
}

export default GoCardlessFlowPage
