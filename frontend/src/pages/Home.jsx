import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import { API_URL } from '../config';

export default function Home() {
    const [featuredProducts, setFeaturedProducts] = useState([]);

    useEffect(() => {
        axios.get(`${API_URL}/products.php`)
            .then(res => setFeaturedProducts(res.data.slice(0, 10))) // Chỉ lấy 4 sp mới nhất
            .catch(err => console.error(err));
    }, []);

    return (
        <div>
            {/* 1. Hero Banner */}
            <div className="bg-dark text-white text-center py-5" style={{
                backgroundImage: 'url("https://source.unsplash.com/random/1600x600/?technology")',
                backgroundSize: 'cover',
                backgroundBlendMode: 'overlay'
            }}>
                <div className="container py-5">
                    <h1 className="display-4 fw-bold">Chào mừng đến với T2507E Store</h1>
                    <p className="lead mb-4">Công nghệ đỉnh cao - Giá cả hợp lý - Giao hàng siêu tốc</p>
                    <Link to="/shop" className="btn btn-primary btn-lg px-4 me-2">Mua sắm ngay</Link>
                </div>
            </div>

            {/* 2. Features (Tính năng) */}
            <div className="container my-5">
                <div className="row text-center">
                    <div className="col-md-4">
                        <div className="p-3 border rounded shadow-sm">
                            <i className="fas fa-shipping-fast fa-2x text-primary mb-3"></i>
                            <h5>Miễn phí vận chuyển</h5>
                            <p className="text-muted">Cho đơn hàng trên 1 triệu đồng</p>
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="p-3 border rounded shadow-sm">
                            <i className="fas fa-headset fa-2x text-success mb-3"></i>
                            <h5>Hỗ trợ 24/7</h5>
                            <p className="text-muted">Luôn sẵn sàng giải đáp mọi thắc mắc</p>
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="p-3 border rounded shadow-sm">
                            <i className="fas fa-undo fa-2x text-warning mb-3"></i>
                            <h5>Hoàn trả 30 ngày</h5>
                            <p className="text-muted">Đổi trả miễn phí nếu có lỗi</p>
                        </div>
                    </div>
                </div>
            </div>

            {/* 3. Sản phẩm nổi bật */}
            <div className="container mb-5">
                <h2 className="text-center mb-4"><span className="border-bottom border-primary border-3">Sản phẩm Mới</span></h2>
                <div className="row">
                    {featuredProducts.map(p => (
                        <div className="col-md-3 mb-4" key={p.id}>
                            <div className="card h-100 shadow-sm border-0">
                                <img src={p.thumbnail} className="card-img-top" alt={p.name} style={{ height: '200px', objectFit: 'cover' }} />
                                <div className="card-body text-center">
                                    <h5 className="card-title text-truncate">{p.name}</h5>
                                    <p className="card-text text-danger fw-bold fs-5">${Number(p.price).toLocaleString()}</p>
                                    <Link to={`/product/${p.id}`} className="btn btn-outline-primary w-100">Xem chi tiết</Link>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
                <div className="text-center">
                    <Link to="/shop" className="btn btn-secondary">Xem tất cả sản phẩm</Link>
                </div>
            </div>
        </div>
    );
}