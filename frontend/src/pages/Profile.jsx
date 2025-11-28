import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { API_URL } from '../config';

export default function Profile() {
    const [user, setUser] = useState({ name: '', email: '', avatar: '' });
    const [newPassword, setNewPassword] = useState('');
    const [message, setMessage] = useState(null);
    const [uploading, setUploading] = useState(false);

    // 1. Tải thông tin user khi vào trang
    useEffect(() => {
        axios.get(`${API_URL}/profile.php`, { withCredentials: true })
            .then(res => setUser(res.data))
            .catch(err => console.error("Lỗi tải profile:", err));
    }, []);

    // 2. Xử lý Upload ảnh
    const handleFileChange = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        setUploading(true);
        try {
            const res = await axios.post(`${API_URL}/upload.php`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            // Upload xong thì cập nhật state avatar ngay để preview
            setUser(prev => ({ ...prev, avatar: res.data.url }));
        } catch (err) {
            alert("Lỗi upload ảnh: " + (err.response?.data?.message || err.message));
        } finally {
            setUploading(false);
        }
    };

    // 3. Xử lý Lưu thông tin
    const handleSubmit = async (e) => {
        e.preventDefault();
        setMessage(null);

        try {
            const res = await axios.post(`${API_URL}/profile.php`, {
                name: user.name,
                avatar: user.avatar,
                new_password: newPassword // Gửi kèm password mới nếu có
            }, { withCredentials: true });

            if (res.data.status === 'success') {
                setMessage({ type: 'success', text: 'Cập nhật hồ sơ thành công!' });
                setNewPassword(''); // Reset ô password
            }
        } catch (err) {
            setMessage({ type: 'danger', text: 'Cập nhật thất bại.' });
        }
    };

    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card shadow">
                        <div className="card-header bg-primary text-white">
                            <h4 className="mb-0">Hồ sơ cá nhân</h4>
                        </div>
                        <div className="card-body">
                            {message && (
                                <div className={`alert alert-${message.type}`}>{message.text}</div>
                            )}

                            <form onSubmit={handleSubmit}>
                                {/* Avatar Section */}
                                <div className="text-center mb-4">
                                    <img
                                        src={user.avatar || "https://via.placeholder.com/150"}
                                        alt="Avatar"
                                        className="rounded-circle img-thumbnail mb-3"
                                        style={{ width: '150px', height: '150px', objectFit: 'cover' }}
                                    />
                                    <div className="d-flex justify-content-center">
                                        <input
                                            type="file"
                                            className="form-control w-50"
                                            accept="image/*"
                                            onChange={handleFileChange}
                                        />
                                    </div>
                                    {uploading && <small className="text-muted">Đang tải ảnh lên...</small>}
                                </div>

                                {/* Info Section */}
                                <div className="mb-3">
                                    <label className="form-label">Email</label>
                                    <input type="text" className="form-control" value={user.email} disabled />
                                    <small className="text-muted">Email không thể thay đổi.</small>
                                </div>

                                <div className="mb-3">
                                    <label className="form-label">Họ và Tên</label>
                                    <input
                                        type="text"
                                        className="form-control"
                                        value={user.name}
                                        onChange={e => setUser({ ...user, name: e.target.value })}
                                        required
                                    />
                                </div>

                                <div className="mb-3">
                                    <label className="form-label">Đổi mật khẩu (Bỏ trống nếu không đổi)</label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        placeholder="Nhập mật khẩu mới..."
                                        value={newPassword}
                                        onChange={e => setNewPassword(e.target.value)}
                                    />
                                </div>

                                <button type="submit" className="btn btn-success w-100">
                                    <i className="fas fa-save me-2"></i> Lưu thay đổi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}