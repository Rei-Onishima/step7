$(document).ready(function() {
    $('.delete-btn').click(function() {
        if (!confirm('本当に削除しますか？')) {
            return;
        }

        var form = $(this).closest('.delete-form');
        var productId = form.data('id');
        var url = form.attr('action');
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: token
            },
            success: function(response) {
                form.closest('tr').remove();
            },
            error: function(xhr) {
                alert('削除に失敗しました');
            }
        });
    });
});
