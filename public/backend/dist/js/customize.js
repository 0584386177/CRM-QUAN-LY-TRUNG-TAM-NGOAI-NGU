(function () {
    "use strict";
    var HT = {};

  HT.formatNumberPhone = () => {
    $('.user-infor.phone').each(function () {
        let phone = $(this).text().replace(/\D/g, ''); // chỉ lấy số

        // Nếu là dạng quốc tế +84 -> đổi thành 0
        if (phone.startsWith('84') && phone.length === 11) {
            phone = '0' + phone.slice(2);
        }

        // Format số di động VN (10 số): 0xxx xxx xxx
        if (phone.length === 10) {
            phone = phone.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
        }

        $(this).text(phone);
    });
};

// HT.checkAll = () => {
//     $('.check-all').on('change',function(e){
//         e.preventDefault();
//         $('.row-check').prop('checked',$(this).prop('checked'));
//     })

//     $('.row-check').on('change',function(e){
//         if(!$(this).prop('checked')){
//             $('.check-all').prop('checked', false);

//         }
//     })
// }
    
$(document).ready(function () {
    HT.formatNumberPhone();
    HT.checkAll();
});

})(jQuery);
