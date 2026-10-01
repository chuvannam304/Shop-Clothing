
function formatMoney(value) {
    return Number(value).toLocaleString('vi-VN') + 'đ';
}


// CẬP NHẬT BADGE GIỎ HÀNG
function updateCartBadge(cartCount) {

    const cart = document.getElementById('headerCart');

    if (!cart) {
        return;
    }

    let badge = document.getElementById('cartBadge');

    cartCount = Number(cartCount);

    if (cartCount <= 0) {

        if (badge) {
            badge.remove();
        }

        return;
    }

    if (!badge) {

        badge = document.createElement('span');

        badge.id = 'cartBadge';
        badge.className = 'cart-badge';

        cart.appendChild(badge);
    }

    badge.textContent =
        cartCount > 99
            ? '99+'
            : cartCount;
}


// UPDATE SỐ LƯỢNG
async function updateQuantity(cartItem, newQuantity) {

    const maCTGH = cartItem.dataset.cartItem;
    const stock = Number(cartItem.dataset.stock);

    // Không cho nhỏ hơn 1
    if (newQuantity < 1) {
        return;
    }

    // Không cho vượt tồn kho
    if (newQuantity > stock) {
        return;
    }

    const input =
        cartItem.querySelector('.cart-quantity-input');

    const minusButton =
        cartItem.querySelector('.cart-quantity-minus');

    const plusButton =
        cartItem.querySelector('.cart-quantity-plus');

    // Khóa nút trong lúc update
    minusButton.disabled = true;
    plusButton.disabled = true;

    const formData = new FormData();

    formData.append('MaCTGH', maCTGH);
    formData.append('SoLuong', newQuantity);

    try {

        const response = await fetch(
            'index.php?controller=giohang&action=updateQuantity',
            {
                method: 'POST',
                body: formData
            }
        );

        const data = await response.json();

        if (!data.success) {

            alert(
                data.message ||
                'Không thể cập nhật số lượng.'
            );

            return;
        }

        // Số lượng mới
        input.value = data.soLuong;

        // Thành tiền sản phẩm
        const itemTotal =
            cartItem.querySelector(
                '.cart-item-total-value'
            );

        if (itemTotal) {
            itemTotal.textContent =
                formatMoney(data.thanhTien);
        }

        // Tổng tiền giỏ
        const subtotal =
            document.getElementById('cartSubtotal');

        const total =
            document.getElementById('cartTotal');

        if (subtotal) {
            subtotal.textContent =
                formatMoney(data.tongTien);
        }

        if (total) {
            total.textContent =
                formatMoney(data.tongTien);
        }

        // Badge
        updateCartBadge(data.cartCount);

    } catch (error) {

        console.error(error);

        alert(
            'Có lỗi xảy ra khi cập nhật số lượng.'
        );

    } finally {

        const quantity = Number(input.value);

        // − khóa khi = 1
        minusButton.disabled =
            quantity <= 1;

        // + khóa khi = tồn kho
        plusButton.disabled =
            quantity >= stock;
    }
}


// NÚT -
document.querySelectorAll(
    '.cart-quantity-minus'
).forEach(function (button) {

    button.addEventListener('click', function () {

        const cartItem =
            button.closest('.cart-item');

        const input =
            cartItem.querySelector(
                '.cart-quantity-input'
            );

        const currentQuantity =
            Number(input.value);

        if (currentQuantity <= 1) {
            return;
        }

        updateQuantity(
            cartItem,
            currentQuantity - 1
        );
    });
});


// NÚT +
document.querySelectorAll(
    '.cart-quantity-plus'
).forEach(function (button) {

    button.addEventListener('click', function () {

        const cartItem =
            button.closest('.cart-item');

        const input =
            cartItem.querySelector(
                '.cart-quantity-input'
            );

        const currentQuantity =
            Number(input.value);

        const stock =
            Number(cartItem.dataset.stock);

        if (currentQuantity >= stock) {
            return;
        }

        updateQuantity(
            cartItem,
            currentQuantity + 1
        );
    });
});


// DẤU X - XÓA SẢN PHẨM
document.querySelectorAll(
    '.cart-remove-x'
).forEach(function (button) {

    button.addEventListener(
        'click',
        async function () {

            const cartItem =
                button.closest('.cart-item');

            const maCTGH =
                button.dataset.id;


        
            // MODAL XÓA SẢN PHẨM
        

            const deleteModal =
                document.getElementById('cartDeleteModal');

            const deleteCancel =
                document.getElementById('cartDeleteCancel');

            const deleteConfirm =
                document.getElementById('cartDeleteConfirm');

            let itemWaitingDelete = null;
            let idWaitingDelete = null;


        
            // BẤM DẤU X
        

            document.querySelectorAll('.cart-remove-x').forEach(function (button) {

                button.addEventListener('click', function () {

                    itemWaitingDelete =
                        button.closest('.cart-item');

                    idWaitingDelete =
                        button.dataset.id;

                    if (deleteModal) {
                        deleteModal.classList.add('show');
                    }

                });

            });


        
            // BẤM HỦY
        

            if (deleteCancel) {

                deleteCancel.addEventListener('click', function () {

                    closeDeleteModal();

                });

            }


        
            // CLICK RA NGOÀI HỘP -> ĐÓNG
        

            if (deleteModal) {

                deleteModal.addEventListener('click', function (event) {

                    if (event.target === deleteModal) {
                        closeDeleteModal();
                    }

                });

            }


        
            // BẤM XÁC NHẬN XÓA
        

            if (deleteConfirm) {

                deleteConfirm.addEventListener('click', async function () {

                    if (!itemWaitingDelete || !idWaitingDelete) {
                        return;
                    }

                    const formData = new FormData();

                    formData.append(
                        'MaCTGH',
                        idWaitingDelete
                    );

                    try {

                        deleteConfirm.disabled = true;

                        deleteConfirm.textContent =
                            'Đang xóa...';


                        const response = await fetch(
                            'index.php?controller=giohang&action=delete',
                            {
                                method: 'POST',
                                body: formData
                            }
                        );


                        const data =
                            await response.json();


                        if (!data.success) {

                            alert(
                                data.message ||
                                'Không thể xóa sản phẩm.'
                            );

                            return;
                        }


                        // XÓA SẢN PHẨM KHỎI GIAO DIỆN

                        itemWaitingDelete.remove();


                        // CẬP NHẬT TẠM TÍNH

                        const subtotal =
                            document.getElementById(
                                'cartSubtotal'
                            );

                        if (subtotal) {

                            subtotal.textContent =
                                formatMoney(data.tongTien);

                        }


                        // CẬP NHẬT TỔNG TIỀN

                        const total =
                            document.getElementById(
                                'cartTotal'
                            );

                        if (total) {

                            total.textContent =
                                formatMoney(data.tongTien);

                        }


                        // BADGE GIỎ HÀNG

                        updateCartBadge(
                            data.cartCount
                        );


                        // SỐ SẢN PHẨM CÒN LẠI

                        const remaining =
                            document.querySelectorAll(
                                '.cart-item'
                            ).length;


                        const productCount =
                            document.getElementById(
                                'cartProductCount'
                            );

                        if (productCount) {

                            productCount.textContent =
                                remaining + ' sản phẩm';

                        }


                        closeDeleteModal();


                        // XÓA HẾT -> HIỆN GIỎ TRỐNG

                        if (remaining === 0) {

                            window.location.reload();

                        }

                    } catch (error) {

                        console.error(error);

                        alert(
                            'Có lỗi xảy ra khi xóa sản phẩm.'
                        );

                    } finally {

                        deleteConfirm.disabled = false;

                        deleteConfirm.textContent =
                            'Xóa';

                    }

                });

            }


        
            // ĐÓNG MODAL
        

            function closeDeleteModal() {

                if (deleteModal) {

                    deleteModal.classList.remove(
                        'show'
                    );

                }

                itemWaitingDelete = null;
                idWaitingDelete = null;

            }
            if (!confirmed) {
                return;
            }


            const formData =
                new FormData();

            formData.append(
                'MaCTGH',
                maCTGH
            );


            try {

                button.disabled = true;


                const response = await fetch(
                    'index.php?controller=giohang&action=delete',
                    {
                        method: 'POST',
                        body: formData
                    }
                );


                const data =
                    await response.json();


                if (!data.success) {

                    button.disabled = false;

                    alert(
                        data.message ||
                        'Không thể xóa sản phẩm.'
                    );

                    return;
                }


                // Xóa khỏi giao diện
                cartItem.remove();


                // Cập nhật tổng tiền
                const subtotal =
                    document.getElementById(
                        'cartSubtotal'
                    );

                const total =
                    document.getElementById(
                        'cartTotal'
                    );


                if (subtotal) {
                    subtotal.textContent =
                        formatMoney(data.tongTien);
                }

                if (total) {
                    total.textContent =
                        formatMoney(data.tongTien);
                }


                // Cập nhật badge
                updateCartBadge(
                    data.cartCount
                );


                // Cập nhật số sản phẩm trên tiêu đề
                const productCount =
                    document.getElementById(
                        'cartProductCount'
                    );

                const remaining =
                    document.querySelectorAll(
                        '.cart-item'
                    ).length;


                if (productCount) {
                    productCount.textContent =
                        remaining + ' sản phẩm';
                }


                // Nếu xóa sản phẩm cuối
                // reload để PHP hiện giỏ trống
                if (remaining === 0) {
                    window.location.reload();
                }

            } catch (error) {

                console.error(error);

                button.disabled = false;

                alert(
                    'Có lỗi xảy ra khi xóa sản phẩm.'
                );
            }
        }
    );
});
