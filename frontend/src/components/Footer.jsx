import React from 'react';
import { Link } from 'react-router-dom';

export default function Footer() {
    return (
        <footer className="bg-dark text-light pt-5 pb-3 mt-auto">
            <div className="container">
                <div className="row">
                    {/* Cột 1: Giới thiệu */}
                    <div className="col-md-4 mb-4">
                        <h5 className="text-warning text-uppercase mb-3">Về chúng tôi</h5>
                        <p className="text-secondary">
                            T2507E Store chuyên cung cấp các sản phẩm công nghệ chính hãng với mức giá tốt nhất thị trường.
                            Cam kết chất lượng, bảo hành uy tín và hỗ trợ khách hàng 24/7.
                        </p>
                        <div className="mt-3">
                            <a href="#" className="text-light me-3"><i className="fab fa-facebook fa-lg"></i></a>
                            <a href="#" className="text-light me-3"><i className="fab fa-twitter fa-lg"></i></a>
                            <a href="#" className="text-light me-3"><i className="fab fa-instagram fa-lg"></i></a>
                            <a href="#" className="text-light"><i className="fab fa-youtube fa-lg"></i></a>
                        </div>
                    </div>

                    {/* Cột 2: Liên kết nhanh */}
                    <div className="col-md-2 mb-4">
                        <h5 className="text-warning text-uppercase mb-3">Liên kết</h5>
                        <ul className="list-unstyled">
                            <li className="mb-2"><Link to="/" className="text-decoration-none text-secondary hover-white">Trang chủ</Link></li>
                            <li className="mb-2"><Link to="/shop" className="text-decoration-none text-secondary hover-white">Cửa hàng</Link></li>
                            <li className="mb-2"><Link to="/cart" className="text-decoration-none text-secondary hover-white">Giỏ hàng</Link></li>
                            <li className="mb-2"><Link to="/checkout" className="text-decoration-none text-secondary hover-white">Thanh toán</Link></li>
                        </ul>
                    </div>

                    {/* Cột 3: Hỗ trợ khách hàng */}
                    <div className="col-md-2 mb-4">
                        <h5 className="text-warning text-uppercase mb-3">Hỗ trợ</h5>
                        <ul className="list-unstyled">
                            <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Chính sách bảo hành</a></li>
                            <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Chính sách đổi trả</a></li>
                            <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Bảo mật thông tin</a></li>
                            <li className="mb-2"><a href="#" className="text-decoration-none text-secondary">Câu hỏi thường gặp</a></li>
                        </ul>
                    </div>

                    {/* Cột 4: Thông tin liên hệ */}
                    <div className="col-md-4 mb-4">
                        <h5 className="text-warning text-uppercase mb-3">Liên hệ</h5>
                        <p className="text-secondary mb-2">
                            <i className="fas fa-map-marker-alt me-2"></i>
                            Số 8A Tôn Thất Thuyết, Mỹ Đình, Hà Nội
                        </p>
                        <p className="text-secondary mb-2">
                            <i className="fas fa-envelope me-2"></i>
                            support@t2507e.edu.vn
                        </p>
                        <p className="text-secondary mb-2">
                            <i className="fas fa-phone-alt me-2"></i>
                            +84 123 456 789
                        </p>
                        <div className="mt-3">
                            <h6 className="text-light">Đăng ký nhận tin:</h6>
                            <div className="input-group">
                                <input type="email" className="form-control form-control-sm" placeholder="Email của bạn" />
                                <button className="btn btn-warning btn-sm">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr className="border-secondary my-4" />

                <div className="row align-items-center">
                    <div className="col-md-6 text-center text-md-start">
                        <p className="mb-0 text-secondary">&copy; 2025 <strong className="text-white">T2507E Store</strong>. All Rights Reserved.</p>
                    </div>
                    <div className="col-md-6 text-center text-md-end">
                        <i className="fab fa-cc-visa fa-2x text-secondary me-2"></i>
                        <i className="fab fa-cc-mastercard fa-2x text-secondary me-2"></i>
                        <i className="fab fa-cc-paypal fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </footer>
    );
}