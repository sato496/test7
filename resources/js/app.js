import $ from 'jquery';
window.$ = $;
window.jQuery = $;

$(document).ready(function () {
  $('.search-button').on('click', function (e) {
    e.preventDefault();

    const formData = $('#search-form').serialize();

    $.ajax({
      url: '/products/search', // ルートは必要に応じて調整
      type: 'GET',
      data: formData,
      success: function (response) {
        $('#products-area').html(response.html);
      },
      error: function () {
        alert('検索に失敗しました。');
      }
    });
  });
});
