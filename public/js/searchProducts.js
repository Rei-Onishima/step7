let currentSort = 'id';        // 初期ソートカラム
let currentDirection = 'desc'; // 初期は降順

$(document).ready(function () {
    // 検索フォーム送信
    $('#searchForm').on('submit', function (event) {
        event.preventDefault();
        fetchProducts();
    });

    // ソートリンククリック
    $(document).on('click', '.sort-link', function (e) {
        e.preventDefault();
        const selectedSort = $(this).data('sort');

        if (currentSort === selectedSort) {
            currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort = selectedSort;
            currentDirection = 'asc';
        }

        fetchProducts();
    });

    // Ajaxで検索＋ソート
    function fetchProducts() {
        const query = $('#searchQuery').val();
        const companyId = $('#companySelect').val();
        const priceMin = $('#priceMin').val();
        const priceMax = $('#priceMax').val();
        const stockMin = $('#stockMin').val();
        const stockMax = $('#stockMax').val();

        //$('#resultsBody').html('<tr><td colspan="7">読み込み中...</td></tr>');

        $.ajax({
            url: '/step7/public/products',
            type: 'GET',
            dataType: 'json',
            data: {
                search: query,
                company_id: companyId,
                price_min: priceMin,
                price_max: priceMax,
                stock_min: stockMin,
                stock_max: stockMax,
                sort: currentSort,
                direction: currentDirection
            },
            success: function (data) {
                displayResults(data);
            },
            error: function (xhr, status, error) {
                $('#resultsBody').html('<tr><td colspan="7">読み込みエラー</td></tr>');
                console.error('エラー:', error);
            }
        });
    }

    // 結果表示
    function displayResults(results) {
        const resultsBody = $('#resultsBody');
        resultsBody.empty();

        if (results.length === 0) {
            resultsBody.html('<tr><td colspan="7">結果が見つかりませんでした。</td></tr>');
            return;
        }

        results.forEach(result => {
            const tr = $('<tr></tr>');
            tr.html(`
                <td>${result.id}</td>
                <td><img src="${result.img_path}" alt="商品画像" width="100"></td>
                <td>${result.product_name}</td>
                <td>${result.price}</td>
                <td>${result.stock}</td>
                <td>${result.company_name}</td>
                <td>
                    <a href="/products/${result.id}" class="btn btn-secondary btn-sm mx-1">詳細表示</a>
                    <form method="POST" action="/products/${result.id}" class="d-inline delete-form">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                    </form>
                </td>
            `);
            resultsBody.append(tr);
        });
    }
});
