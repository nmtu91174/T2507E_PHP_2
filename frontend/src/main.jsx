import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
// 1. Import Bootstrap CSS (để giao diện không bị vỡ)
import 'bootstrap/dist/css/bootstrap.min.css'
// 2. Import Router
import { BrowserRouter } from 'react-router-dom'
// 3. Import CartProvider (Quan trọng nhất để sửa lỗi của bạn)
import { CartProvider } from './context/CartContext'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <BrowserRouter>
      {/* Bao bọc App bằng CartProvider thì Header và các trang con mới dùng được useCart() */}
      <CartProvider>
        <App />
      </CartProvider>
    </BrowserRouter>
  </React.StrictMode>,
)