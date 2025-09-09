<h1>Đăng ký tài khoản {{ $user->fullname }} thành công</h1>
<p>Vui lòng kích hoạt tài khoản để sử dụng các tính năng</p>
<a href="{{ route('activate.register.user', $user->activation_token) }}"
    style="display:inline-block;padding:10px 20px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:5px;">
    Kích hoạt
</a>