'use strict';
{
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.heart_false, .heart_true').forEach(function (heart) {
            heart.addEventListener('click', function () {
                let isFavorite = heart.classList.contains('heart_true');
                let shopId = heart.getAttribute('data-shop-id'); // ショップIDを取得する

                // お気に入りの状態を変更する
                heart.classList.toggle('heart_true', !isFavorite);
                heart.classList.toggle('heart_false', isFavorite);

                // サーバーにリクエストを送信
                fetch('/toggle-favorite', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        shop_id: shopId,
                        is_favorite: !isFavorite
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            // エラーが発生した場合、状態を元に戻す
                            heart.classList.toggle('heart_true', isFavorite);
                            heart.classList.toggle('heart_false', !isFavorite);
                        }
                    });
            });
        });
    });
}
