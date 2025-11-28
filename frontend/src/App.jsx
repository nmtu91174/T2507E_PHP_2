import { Routes, Route } from 'react-router-dom';
import Header from './components/Header';
import Footer from './components/Footer'; // Import Footer
import Home from './pages/Home';
import Shop from './pages/Shop';
import ProductDetail from './pages/ProductDetail';
import Cart from './pages/Cart';
import Checkout from './pages/Checkout';
import OrderDetail from './pages/OrderDetail';
import Profile from './pages/Profile'; // Import trang Profile mới tạo
import MyOrders from './pages/MyOrders'; // Import trang Lịch sử đơn hàng (đã tạo ở bước trước)

function App() {
  return (
    <>
      <div className="d-flex flex-column min-vh-100">
        {/* Wrapper này giúp Footer luôn bị đẩy xuống đáy nếu nội dung ngắn */}

        <Header />

        <div className="flex-grow-1"> {/* Phần nội dung chính sẽ giãn ra */}
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/shop" element={<Shop />} />
            <Route path="/product/:id" element={<ProductDetail />} />
            <Route path="/cart" element={<Cart />} />
            <Route path="/checkout" element={<Checkout />} />
            <Route path="/order-detail/:id" element={<OrderDetail />} />
            <Route path="/profile" element={<Profile />} /> {/* Route cho trang Profile */}
            <Route path="/my-orders" element={<MyOrders />} /> {/* Route cho trang Lịch sử đơn hàng */}
          </Routes>
        </div>
        <Footer /> {/* Footer nằm ở đây */}
      </div>
    </>
  );
}

export default App;