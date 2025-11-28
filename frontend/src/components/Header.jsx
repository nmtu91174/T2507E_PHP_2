import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import Badge from 'react-bootstrap/Badge';
import { Link } from 'react-router-dom';
import { useCart } from '../context/CartContext';

function Header() {
    const { cart } = useCart();
    const totalItems = cart.reduce((acc, item) => acc + item.qty, 0);

    return (
        <Navbar bg="dark" data-bs-theme="dark" expand="lg" sticky="top">
            <Container>
                <Navbar.Brand as={Link} to="/">T2507E Store</Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                    <Nav className="me-auto">
                        <Nav.Link as={Link} to="/">Trang chủ</Nav.Link>
                        <Nav.Link as={Link} to="/shop">Cửa hàng</Nav.Link>
                    </Nav>
                    <Nav>
                        <Nav.Link as={Link} to="/cart">
                            <i className="fas fa-shopping-cart"></i> Giỏ hàng
                            {totalItems > 0 && <Badge bg="danger" className="ms-1">{totalItems}</Badge>}
                        </Nav.Link>
                    </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    );
}

export default Header;