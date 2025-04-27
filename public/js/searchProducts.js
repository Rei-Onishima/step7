//　ドキュメントが読み込まれたときに実行
$(document).ready(function() {
    // フォームが送信されたときに実行
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();  // フォームのデフォルトの送信動作をキャンセル
        const query = $('#searchQuery').val();  // ID属性がsearchQueryの値をqueryという変数に代入
        const companyId = $('#companySelect').val();
        const resultsBody = $('#resultsBody');
        resultsBody.html('<tr><td colspan="7">検索中...</td></tr>');

        console.log('Search Query:', query);  // デバッグ用
        console.log('Company ID:', companyId);  // デバッグ用

        // Ajaxリクエストを送信
        $.ajax({
            url: '/step7/public/products',  // リクエストを送信するURL
            type: 'GET',  // HTTPメソッド（GETリクエスト）
            data: {
                search: query, // ここでのプロパティ名：変数名
                company_id: companyId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',  // サーバーからのレスポンスがJSON形式であることを指定
            success: function(data) {  // successコールバック関数の引数名がresponseでもdataでも動作は基本的に同じ
                // リクエストが成功したときの処理
                console.log('Success:', data);  // デバッグ用
                displayResults(data);
            },
            error: function(xhr, status, error) {
                // エラーが発生したときの処理
                resultsBody.html('<tr><td colspan="7">検索エラー</td></tr>');
                console.error('Error:', error);
                console.error('XHR:', xhr);  // デバッグ用
                console.error('Status:', status);  // デバッグ用
            }
        });
    });

    function displayResults(results) {
        const resultsBody = $('#resultsBody');
        resultsBody.empty();  // 既存のテーブルの内容をクリア

        if (results.length === 0) {
            resultsBody.html('<tr><td colspan="7">結果が見つかりませんでした。</td></tr>');
            return;
        }

        results.forEach(result => {
            const tr = $('<tr></tr>'); // 新しいテーブルの行を作成
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
