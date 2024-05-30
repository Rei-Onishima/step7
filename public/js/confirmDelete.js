document.addEventListener('DOMContentLoaded', function() {
    // すべての削除フォームを取得
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(function(form) {
        // フォームの送信イベントを監視
        form.addEventListener('submit', function(event) {
            // 確認ダイアログを表示し、ユーザーの応答を取得
            const confirmed = confirm('本当に削除しますか？');

            // ユーザーが「キャンセル」を選択した場合、フォーム送信をキャンセル
            if (!confirmed) {
                event.preventDefault();
            }
        });
    });
});
