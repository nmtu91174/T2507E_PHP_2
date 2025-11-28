import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import axios from 'axios';
import { API_URL } from '../config';

export default function OrderDetail() {
    const { id } = useParams();
    const [order, setOrder] = useState(null);

    useEffect(() => {
        axios.get(`${API_URL}/order_detail.php?id=${id}`)
            .then(res => setOrder(res.data))
            .catch(err => console.error(err));
    }, [id]);

    if (!order) return <div className="text-center mt-5">Đang tải thông tin đơn hàng...</div>;

    return (
        <div className="container mt-5">
            <div className="card shadow-lg border-0">
                <div className="card-header bg-success text-white text-center py-3">
                    <h3><i className="fas fa-check-circle me-2"></i>Đặt hàng thành công!</h3>
                    <p className="mb-0">Mã đơn hàng: #{order.id}</p>
                </div>
                <div className="card-body p-4">
                    <div className="row mb-4">
                        <div className="col-md-6">
                            <h5>Thông tin khách hàng</h5>
                            <p><strong>Tên:</strong> {order.customer_name}</p>
                            <p><strong>Email:</strong> {order.customer_email}</p>
                            <p><strong>SĐT:</strong> {order.customer_phone}</p>
                            <p><strong>Địa chỉ:</strong> {order.customer_address}</p>
                        </div>
                        <div className="col-md-6 text-md-end">
                            <h5>Thời gian đặt</h5>
                            <p>{new Date(order.created_at).toLocaleString()}</p>
                            <h4 className="text-danger">Tổng: ${Number(order.total_money).toLocaleString()}</h4>
                        </div>
                    </div>

                    <h5>Chi tiết sản phẩm</h5>
                    <table className="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            {order.items && order.items.map((item, index) => (
                                <tr key={index}>
                                    <td>
                                        <div className="d-flex align-items-center">
                                            <img src={item.thumbnail} width="40" className="me-2" alt="" />
                                            {item.name}
                                        </div>
                                    </td>
                                    <td>${Number(item.price).toLocaleString()}</td>
                                    <td>{item.quantity}</td>
                                    <td>${(item.price * item.quantity).toLocaleString()}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>

                    <div className="text-center mt-4">
                        <Link to="/" className="btn btn-primary">Về trang chủ</Link>
                    </div>
                </div>
            </div>
        </div>
    );
}