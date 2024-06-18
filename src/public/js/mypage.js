'use strict';
{
    document.querySelector('.heart_true').addEventListener('click', () => {
        let shopId = heart.getAttribute('data-shop-id');

        fetch('/toggle-favorite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                shop_id: shopId
            })
        })
    });
}
