import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import { useCart } from '../context/CartContext';
import { API_URL } from '../config';

export default function ProductDetail() {
    const { id } = useParams();
    const [product, setProduct] = useState(null);
    const { addToCart } = useCart();

    useEffect(() => {
        axios.get(`${API_URL}/products.php?id=${id}`)
            .then(res => setProduct(res.data))
            .catch(err => console.error(err));
    }, [id]);

    if (!product) return <div className="text-center mt-5">Đang tải...</div>;

    return (
        <div className="container mt-5">
            <div className="row">
                <div className="col-md-5">
                    <img src={product.thumbnail} className="img-fluid rounded border" alt={product.name} />
                </div>
                <div className="col-md-7">
                    <h1 className="display-5 fw-bold">{product.name}</h1>
                    <p className="text-muted">Danh mục: {product.category_name}</p>
                    <h3 className="text-danger mb-4">${Number(product.price).toLocaleString()}</h3>

                    <p className="lead">{product.description}</p>

                    <div className="d-grid gap-2 d-md-block mt-4">
                        <button onClick={() => addToCart(product)} className="btn btn-primary btn-lg me-2">
                            <i className="fas fa-cart-plus me-2"></i> Thêm vào giỏ
                        </button>
                        <button className="btn btn-outline-secondary btn-lg">Yêu thích</button>
                    </div>
                </div>
            </div>
        </div>
    );
}