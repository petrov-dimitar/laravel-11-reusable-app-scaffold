import React from 'react'
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
} from '@mui/material'
import { useGetTransactionsQuery } from '../../redux/api.service'

function TransactionTable() {
  const { data: transactions, isLoading, isError } = useGetTransactionsQuery()

  if (isLoading) return <div>Loading...</div>
  if (isError) return <div>Error fetching transactions</div>

  return (
    <TableContainer component={Paper}>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell>Date</TableCell>
            <TableCell>IBAN</TableCell>
            <TableCell>Bank</TableCell>
            <TableCell>Amount</TableCell>
            <TableCell>Currency</TableCell>
            <TableCell>Currency Rate</TableCell>
            <TableCell>Result</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {transactions.map((transaction) => (
            <TableRow key={transaction.id}>
              <TableCell>{transaction.date}</TableCell>
              <TableCell>{transaction.iban}</TableCell>
              <TableCell>{transaction.bank}</TableCell>
              <TableCell>{transaction.amount}</TableCell>
              <TableCell>{transaction.currency}</TableCell>
              <TableCell>{transaction.currency_rate}</TableCell>
              <TableCell>{transaction.result}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  )
}

export default TransactionTable
