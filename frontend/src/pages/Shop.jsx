import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link, useSearchParams } from 'react-router-dom';
import { API_URL } from '../config';

export default function Shop() {
    const [products, setProducts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [pagination, setPagination] = useState({});

    // Quản lý URL params để share link dễ dàng
    const [searchParams, setSearchParams] = useSearchParams();

    // State cho bộ lọc
    const [filters, setFilters] = useState({
        category_id: searchParams.get('category_id') || '',
        search: searchParams.get('search') || '',
        sort: searchParams.get('sort') || 'newest',
        page: searchParams.get('page') || 1
    });

    useEffect(() => {
        // Lấy danh mục
        axios.get(`${API_URL}/categories.php`).then(res => setCategories(res.data));
    }, []);

    useEffect(() => {
        fetchProducts();
        // Cập nhật URL khi filters thay đổi
        setSearchParams(filters);
    }, [filters]);

    const fetchProducts = () => {
        // Tạo query string từ state filters
        const params = new URLSearchParams(filters).toString();

        axios.get(`${API_URL}/products.php?${params}`)
            .then(res => {
                // API mới trả về { data: [], pagination: {} }
                setProducts(res.data.data);
                setPagination(res.data.pagination);
            })
            .catch(err => console.error(err));
    };

    const handleFilterChange = (e) => {
        setFilters({ ...filters, [e.target.name]: e.target.value, page: 1 }); // Reset về trang 1 khi lọc
    };

    return (
        <div className="container mt-4">
            <div className="row">
                {/* Sidebar Bộ lọc */}
                <div className="col-md-3">
                    <div className="card p-3 shadow-sm">
                        <h5 className="mb-3">Tìm kiếm & Lọc</h5>

                        {/* Tìm kiếm tên */}
                        <div className="mb-3">
                            <label className="form-label">Tên sản phẩm</label>
                            <input
                                type="text"
                                className="form-control"
                                name="search"
                                value={filters.search}
                                onChange={handleFilterChange}
                                placeholder="Nhập tên..."
                            />
                        </div>

                        {/* Danh mục */}
                        <div className="mb-3">
                            <label className="form-label">Danh mục</label>
                            <select
                                className="form-select"
                                name="category_id"
                                value={filters.category_id}
                                onChange={handleFilterChange}
                            >
                                <option value="">Tất cả</option>
                                {categories.map(c => (
                                    <option key={c.id} value={c.id}>{c.name}</option>
                                ))}
                            </select>
                        </div>

                        {/* Sắp xếp */}
                        <div className="mb-3">
                            <label className="form-label">Sắp xếp</label>
                            <select
                                className="form-select"
                                name="sort"
                                value={filters.sort}
                                onChange={handleFilterChange}
                            >
                                <option value="newest">Mới nhất</option>
                                <option value="price_asc">Giá tăng dần</option>
                                <option value="price_desc">Giá giảm dần</option>
                            </select>
                        </div>
                    </div>
                </div>

                {/* Danh sách sản phẩm */}
                <div className="col-md-9">
                    <div className="row">
                        {products.length > 0 ? products.map(p => (
                            <div className="col-md-4 mb-4" key={p.id}>
                                <div className="card h-100 shadow-sm border-0">
                                    <img src={p.thumbnail} className="card-img-top" style={{ height: '200px', objectFit: 'contain', padding: '10px' }} alt={p.name} />
                                    <div className="card-body d-flex flex-column text-center">
                                        <h5 className="card-title text-truncate">{p.name}</h5>
                                        <div className="mt-auto">
                                            <p className="text-danger fw-bold fs-5 mb-2">${Number(p.price).toLocaleString()}</p>
                                            <Link to={`/product/${p.id}`} className="btn btn-outline-primary w-100">Xem chi tiết</Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )) : <div className="col-12 text-center py-5"><h5>Không tìm thấy sản phẩm nào.</h5></div>}
                    </div>

                    {/* Phân trang */}
                    {pagination.total_pages > 1 && (
                        <nav className="mt-4">
                            <ul className="pagination justify-content-center">
                                <li className={`page-item ${filters.page <= 1 ? 'disabled' : ''}`}>
                                    <button className="page-link" onClick={() => setFilters({ ...filters, page: parseInt(filters.page) - 1 })}>Trước</button>
                                </li>
                                {[...Array(pagination.total_pages)].map((_, idx) => (
                                    <li key={idx + 1} className={`page-item ${filters.page == idx + 1 ? 'active' : ''}`}>
                                        <button className="page-link" onClick={() => setFilters({ ...filters, page: idx + 1 })}>{idx + 1}</button>
                                    </li>
                                ))}
                                <li className={`page-item ${filters.page >= pagination.total_pages ? 'disabled' : ''}`}>
                                    <button className="page-link" onClick={() => setFilters({ ...filters, page: parseInt(filters.page) + 1 })}>Sau</button>
                                </li>
                            </ul>
                        </nav>
                    )}
                </div>
            </div>
        </div>
    );
}