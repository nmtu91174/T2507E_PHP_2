import React from 'react';
import { useCart } from '../context/CartContext';
import { Link } from 'react-router-dom';

export default function Cart() {
    const { cart, removeFromCart, updateQty, totalMoney } = useCart();

    if (cart.length === 0) {
        return (
            <div className="container mt-5 text-center">
                <h3>Giỏ hàng của bạn đang trống</h3>
                <Link to="/shop" className="btn btn-primary mt-3">Quay lại mua sắm</Link>
            </div>
        );
    }

    return (
        <div className="container mt-5">
            <h2 className="mb-4">Giỏ hàng của bạn</h2>
            <div className="table-responsive">
                <table className="table align-middle">
                    <thead className="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {cart.map(item => (
                            <tr key={item.id}>
                                <td>
                                    <div className="d-flex align-items-center">
                                        <img src={item.thumbnail} width="50" className="me-2" alt="" />
                                        <strong>{item.name}</strong>
                                    </div>
                                </td>
                                <td>${Number(item.price).toLocaleString()}</td>
                                <td>
                                    {/* Cần bổ sung hàm updateQty trong Context nếu chưa có */}
                                    <span className="badge bg-secondary">{item.qty}</span>
                                </td>
                                <td>${(item.price * item.qty).toLocaleString()}</td>
                                <td>
                                    <button onClick={() => removeFromCart(item.id)} className="btn btn-danger btn-sm">
                                        <i className="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            <div className="d-flex justify-content-end align-items-center mt-3">
                <h4 className="me-4">Tổng cộng: <span className="text-danger">${totalMoney.toLocaleString()}</span></h4>
                <Link to="/checkout" className="btn btn-success btn-lg">Tiến hành thanh toán</Link>
            </div>
        </div>
    );
}