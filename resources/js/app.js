import './bootstrap';

import { addToCart, removeFromCart, updateQuantity, checkout } from './cart';

window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.checkout = checkout;
