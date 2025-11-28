import React, { createContext, useState, useContext, useEffect } from 'react';

const CartContext = createContext();

export const CartProvider = ({ children }) => {
    // SỬA LẠI ĐOẠN KHỞI TẠO NÀY AN TOÀN HƠN
    const [cart, setCart] = useState(() => {
        try {
            const savedCart = localStorage.getItem('cart');
            // Nếu có dữ liệu thì parse, nếu không thì là mảng rỗng
            const parsedCart = savedCart ? JSON.parse(savedCart) : [];
            // Kiểm tra chắc chắn kết quả là Array, nếu không phải thì reset về mảng rỗng
            return Array.isArray(parsedCart) ? parsedCart : [];
        } catch (error) {
            console.error("Lỗi đọc LocalStorage:", error);
            return []; // Nếu JSON lỗi, trả về giỏ hàng rỗng
        }
    });

    // Mỗi khi cart thay đổi, lưu lại vào LocalStorage
    useEffect(() => {
        localStorage.setItem('cart', JSON.stringify(cart));
    }, [cart]);

    const addToCart = (product) => {
        setCart((prev) => {
            // Đảm bảo prev luôn là mảng trước khi find
            const currentCart = Array.isArray(prev) ? prev : [];
            const existing = currentCart.find(item => item.id === product.id);
            if (existing) {
                return currentCart.map(item =>
                    item.id === product.id ? { ...item, qty: item.qty + 1 } : item
                );
            }
            return [...currentCart, { ...product, qty: 1 }];
        });
    };

    const removeFromCart = (id) => {
        setCart(prev => (Array.isArray(prev) ? prev : []).filter(item => item.id !== id));
    };

    const updateQty = (id, num) => {
        setCart(prev => (Array.isArray(prev) ? prev : []).map(item =>
            item.id === id ? { ...item, qty: num } : item
        ));
    }

    const clearCart = () => setCart([]);

    // Kiểm tra cart là mảng trước khi reduce
    const totalMoney = Array.isArray(cart) ? cart.reduce((acc, item) => acc + item.price * item.qty, 0) : 0;

    return (
        <CartContext.Provider value={{ cart, addToCart, removeFromCart, updateQty, clearCart, totalMoney }}>
            {children}
        </CartContext.Provider>
    );
};

export const useCart = () => useContext(CartContext);