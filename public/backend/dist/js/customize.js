(function () {
  "use strict";
  var HT = {};
  const DOMAIN = 'http://127.0.0.1:8000';
  const PREFIX_API = 'api';

  HT.formatPrice = () => {
    $('.price').each(function () {
      let val = parseInt($(this).text().trim()) || 0;
      let formatted = val.toLocaleString('vi', { style: 'currency', currency: 'VND' });
      $(this).text(formatted);
    });
  }
  HT.searchNavbar = () => {
    $('.search-navbar-input').keyup(function (e) {
      let _keyword = $(this).val();
      if (_keyword == "") {
        $('.search-navbar-list').html("");
        $('.navbar-result-header').hide();
        $('.navbar-result-footer').hide();
        return;
      }
      let _html = ``;
      $.ajax({
        type: "GET",
        url: `${DOMAIN}/${PREFIX_API}/search-navbar/`,
        data: { keyword: _keyword },
        dataType: "json",
        success: function (res) {
          let data = res.data;
          console.log(data);

          if (data.length > 0) {
            for (let i = 0; i < data.length; i++) {
              _html += `<a href="#" class="search-navbar-item">`;
              _html += `<img src="${DOMAIN}${data[i]['avatar']}" alt="Avatar" class="result-avatar">`;
              _html += `<div class="result-info">`;
              _html += `<div class="result-name">${data[i]['fullname']}</div>`;
              _html += `<div class="result-detail"><strong>Email :</strong> ${data[i]['email']}</div>`;
              _html += `<div class="result-detail"><strong>SĐT :</strong> ${data[i]['phone']}</div>`;
              _html += `</div>`;
              _html += `</a>`;
            }

            $('.search-navbar-list').html(_html);
            $('.navbar-result-header').show();
            $('.navbar-result-footer').show();
          } else {
            _html += '<span class="d-block my-2 text-danger text-center fw-semibold"> Không tìm thấy thông tin </span> ';
            $('.search-navbar-list').html(_html);
            $('.navbar-result-header').show();
            $('.navbar-result-footer').show();
          }
        }
      });





    });
  }

  HT.ValidateInputUpdateTuition = () => {
    $('.update_amount').on('keyup', function () {
      let fee_amount = parseInt($('.fee_amount').text().replace(/\./g, '').replace('đ', '').trim());
      let paid_amount = parseInt($('.paid_amount').text().replace(/\./g, '').replace('đ', '').trim());
      let is_check_fee = parseInt($(this).val());

      // Nếu không nhập số hợp lệ
      if (isNaN(is_check_fee) || is_check_fee == "") {
        $(this).css("border", "1px solid gray"); // giữ màu mặc định
        return;
      }

      // Validate logic
      if (is_check_fee + paid_amount > fee_amount) {
        alert('Khoản tiền nhập vào cao hơn số tiền tổng học phí. Vui lòng kiểm tra và nhập lại.');
      }
    });
  }

  $(document).ready(function () {
    HT.searchNavbar();
    HT.formatPrice();
    HT.ValidateInputUpdateTuition();
  });

})(jQuery);



