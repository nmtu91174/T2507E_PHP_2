import React, { useState } from 'react';
import { useCart } from '../context/CartContext';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { API_URL } from '../config';

export default function Checkout() {
    const { cart, totalMoney, clearCart } = useCart();
    const navigate = useNavigate();

    // Tính phí ship tạm tính để hiển thị (Backend sẽ tính lại lần nữa cho chắc)
    const shippingFee = totalMoney >= 1000000 ? 0 : 30000;
    const finalTotal = totalMoney + shippingFee;

    const [formData, setFormData] = useState({
        customer_name: '', customer_email: '', customer_phone: '', customer_address: '',
        payment_method: 'COD' // Mặc định là COD
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        const orderData = { ...formData, cart: cart }; // Không gửi totalMoney để tránh hack

        try {
            // 1. Tạo đơn hàng
            const res = await axios.post(`${API_URL}/checkout.php`, orderData, { withCredentials: true });


            if (res.data.status === 'success') {
                const orderId = res.data.order_id;

                // 2. Nếu chọn VNPay -> Gọi API lấy link thanh toán
                if (formData.payment_method === 'VNPAY') {
                    const vnpRes = await axios.post(`${API_URL}/vnpay_create_payment.php`, { order_id: orderId });
                    if (vnpRes.data.status === 'success') {
                        // Chuyển hướng sang VNPay
                        window.location.href = vnpRes.data.payment_url;
                    }
                } else {
                    // COD -> Xong luôn
                    clearCart();
                    navigate(`/order-detail/${orderId}`);
                }
            }
        } catch (error) {
            alert("Đặt hàng thất bại: " + (error.response?.data?.message || "Lỗi hệ thống"));
        }
    };

    return (
        <div className="container mt-5">
            <h2 className="mb-4">Thanh toán</h2>
            <div className="row">
                <div className="col-md-7">
                    <div className="card p-4 shadow-sm">
                        <form onSubmit={handleSubmit}>
                            <h4 className="mb-3">Thông tin giao hàng</h4>
                            <div className="mb-3">
                                <label>Họ tên</label>
                                <input type="text" className="form-control" required onChange={e => setFormData({ ...formData, customer_name: e.target.value })} />
                            </div>
                            <div className="row mb-3">
                                <div className="col">
                                    <label>Email</label>
                                    <input type="email" className="form-control" required onChange={e => setFormData({ ...formData, customer_email: e.target.value })} />
                                </div>
                                <div className="col">
                                    <label>SĐT</label>
                                    <input type="text" className="form-control" required onChange={e => setFormData({ ...formData, customer_phone: e.target.value })} />
                                </div>
                            </div>
                            <div className="mb-3">
                                <label>Địa chỉ</label>
                                <textarea className="form-control" rows="2" required onChange={e => setFormData({ ...formData, customer_address: e.target.value })}></textarea>
                            </div>

                            <h4 className="mb-3">Phương thức thanh toán</h4>
                            <div className="form-check mb-2">
                                <input className="form-check-input" type="radio" name="payment" id="cod"
                                    value="COD" checked={formData.payment_method === 'COD'}
                                    onChange={e => setFormData({ ...formData, payment_method: e.target.value })} />
                                <label className="form-check-label" htmlFor="cod">Thanh toán khi nhận hàng (COD)</label>
                            </div>
                            <div className="form-check mb-3">
                                <input className="form-check-input" type="radio" name="payment" id="vnpay"
                                    value="VNPAY" checked={formData.payment_method === 'VNPAY'}
                                    onChange={e => setFormData({ ...formData, payment_method: e.target.value })} />
                                <label className="form-check-label" htmlFor="vnpay">
                                    Thanh toán qua VNPay <img src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg" height="20" alt="" />
                                </label>
                            </div>

                            <button className="btn btn-primary w-100 btn-lg" type="submit">
                                {formData.payment_method === 'VNPAY' ? 'Tiếp tục qua VNPay' : 'Đặt hàng'}
                            </button>
                        </form>
                    </div>
                </div>

                {/* Cột Tổng kết đơn hàng */}
                <div className="col-md-5">
                    <div className="card p-4 bg-light">
                        <h4>Đơn hàng của bạn</h4>
                        <hr />
                        {cart.map(item => (
                            <div key={item.id} className="d-flex justify-content-between mb-2">
                                <span>{item.name} x {item.qty}</span>
                                <span>${(item.price * item.qty).toLocaleString()}</span>
                            </div>
                        ))}
                        <hr />
                        <div className="d-flex justify-content-between">
                            <span>Tạm tính:</span>
                            <span>${totalMoney.toLocaleString()}</span>
                        </div>
                        <div className="d-flex justify-content-between">
                            <span>Phí vận chuyển:</span>
                            <span>${shippingFee.toLocaleString()}</span>
                        </div>
                        <hr />
                        <div className="d-flex justify-content-between fw-bold fs-5 text-danger">
                            <span>Tổng cộng:</span>
                            <span>${finalTotal.toLocaleString()}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}