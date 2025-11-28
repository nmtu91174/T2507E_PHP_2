import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { API_URL } from '../config'; // Lấy địa chỉ API (http://localhost:8000/api)

export default function MyOrders() {
    // 1. KHAI BÁO BIẾN (STATE)
    // orders: Biến để chứa danh sách đơn hàng lấy từ Server về
    const [orders, setOrders] = useState([]);

    // loading: Biến để biết đang tải dữ liệu hay xong rồi (true = đang tải)
    const [loading, setLoading] = useState(true);

    // error: Biến để lưu thông báo lỗi nếu có (ví dụ: chưa đăng nhập)
    const [error, setError] = useState(null);

    // 2. GỌI API KHI TRANG VỪA MỞ LÊN
    useEffect(() => {
        // Hàm lấy dữ liệu
        const fetchOrders = async () => {
            try {
                // Gọi API backend kèm theo thông tin cookie/session (quan trọng để biết ai đang gọi)
                const response = await axios.get(`${API_URL}/my_orders.php`, {
                    withCredentials: true // Bắt buộc có dòng này để gửi Session ID lên Server
                });

                // Nếu Server trả về lỗi dạng "Unauthorized" (Chưa đăng nhập)
                if (response.data.message === "Unauthorized") {
                    setError("Bạn cần đăng nhập để xem lịch sử mua hàng.");
                } else {
                    // Nếu thành công, lưu dữ liệu vào biến orders
                    setOrders(response.data);
                }
            } catch (err) {
                console.error("Lỗi:", err);
                setError("Có lỗi xảy ra khi tải danh sách đơn hàng.");
            } finally {
                // Dù thành công hay thất bại thì cũng tắt trạng thái "Đang tải"
                setLoading(false);
            }
        };

        fetchOrders(); // Chạy hàm trên
    }, []); // [] rỗng nghĩa là chỉ chạy 1 lần duy nhất khi vào trang

    // 3. XỬ LÝ GIAO DIỆN KHI ĐANG TẢI HOẶC LỖI
    if (loading) {
        return <div className="container mt-5 text-center"><h3>Đang tải dữ liệu...</h3></div>;
    }

    if (error) {
        return (
            <div className="container mt-5 text-center">
                <div className="alert alert-warning">{error}</div>
                <Link to="/login" className="btn btn-primary">Đăng nhập ngay</Link>
            </div>
        );
    }

    // 4. GIAO DIỆN CHÍNH (HIỂN THỊ DANH SÁCH)
    return (
        <div className="container mt-5">
            <h2 className="mb-4 text-primary"><i className="fas fa-history me-2"></i>Lịch sử mua hàng</h2>

            {orders.length === 0 ? (
                // Nếu không có đơn hàng nào
                <div className="text-center p-5 bg-light rounded">
                    <p className="lead">Bạn chưa mua đơn hàng nào.</p>
                    <Link to="/shop" className="btn btn-success">Đi mua sắm ngay</Link>
                </div>
            ) : (
                // Nếu có đơn hàng -> Hiện bảng
                <div className="table-responsive shadow-sm rounded">
                    <table className="table table-hover align-middle mb-0">
                        <thead className="table-dark">
                            <tr>
                                <th>Mã đơn (#)</th>
                                <th>Ngày đặt</th>
                                <th>Địa chỉ nhận</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            {/* Dùng vòng lặp map để in từng dòng đơn hàng */}
                            {orders.map((order) => (
                                <tr key={order.id}>
                                    <td><strong>#{order.id}</strong></td>
                                    <td>
                                        {/* Chuyển đổi ngày giờ cho dễ đọc */}
                                        {new Date(order.created_at).toLocaleString('vi-VN')}
                                    </td>
                                    <td style={{ maxWidth: '300px' }} className="text-truncate">
                                        {order.customer_address}
                                    </td>
                                    <td className="text-danger fw-bold">
                                        ${Number(order.total_money).toLocaleString()}
                                    </td>
                                    <td>
                                        <Link to={`/order-detail/${order.id}`} className="btn btn-sm btn-outline-primary">
                                            <i className="fas fa-eye me-1"></i> Chi tiết
                                        </Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
}