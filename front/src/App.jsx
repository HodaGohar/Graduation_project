import { useState } from 'react'
import './App.css'
import Signup from './componets/Signup'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Login from './componets/Login'
import Dashboard from './componets/Dashbord'

function App() {

  return (
    <BrowserRouter>
     <Routes>
      <Route path='/' element={<Signup />}></Route>
      <Route path='/login' element={<Login />}></Route>
      <Route path='/dashbord' element={<Dashboard />}></Route>
     </Routes>
    </BrowserRouter>
  )
}

export default App
