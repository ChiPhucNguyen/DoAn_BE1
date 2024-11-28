<?php
    if(isset($_SESSION['registerError'])) {
        $errorMessage = $_SESSION['registerError'];
        unset($_SESSION['registerError']);
    }
    if(isset($_SESSION['registerSuccess'])) {
        $successMessage = $_SESSION['registerSuccess'];
        unset($_SESSION['registerSuccess']);
    }
?>
 <!-- Modal -->
 <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php
                    if(isset($errorMessage)) 
                    {
                        echo <<<HTML
                        <div class="alert alert-danger text-center" role="alert" id="register-message">Error </div>;
                        HTML;
                    }
                    if(isset($successMessage))
                    {
                        echo <<<HTML
                                <div class="alert alert-info text-center" role="alert" id="register-message">Success </div>;
                            HTML;
                    }
                ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Đăng ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="register.php" method="post" id="form-register">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input 
                            name="username" 
                            type="text" 
                            class="form-control" 
                            id="username" 
                            placeholder="Nhập tên đăng nhập"
                            pattern="^[a-zA-Z0-9_]{5,15}$" 
                            title="Tên đăng nhập chỉ chứa chữ, số, gạch dưới và có độ dài từ 5 đến 15 ký tự"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input 
                            name="password" 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            placeholder="Nhập mật khẩu"
                            pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=!]).{8,}$" 
                            title="Mật khẩu phải ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="repeatPassword">Nhập lại mật khẩu</label>
                        <input 
                            name="repeatPassword" 
                            type="password" 
                            class="form-control" 
                            id="repeatPassword" 
                            placeholder="Nhập lại mật khẩu"
                            required>
                    </div>
                    <button type="submit" style="background-color:#7fad39; color:white;" class="btn btn-block">Đăng ký</button>
                </form>

                </div>
                <div class="modal-footer">
                    <p class="text-center w-100">
                        Bạn đã có tài khoản? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-primary">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div><script>
    document.querySelector('.form-register').addEventListener('submit', function (e) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const repeatPassword = document.getElementById('repeatPassword').value;

        // Regex rules
        const usernameRegex = /^[a-zA-Z0-9_]{5,15}$/;
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[a-z])(?=.*[@#$%^&+=!]).{8,}$/;

        // Username validation
        if (!usernameRegex.test(username)) {
            alert('Tên đăng nhập phải từ 5-15 ký tự, chỉ chứa chữ, số và dấu gạch dưới.');
            e.preventDefault();
            return;
        }

        // Password validation
        if (!passwordRegex.test(password)) {
            alert('Mật khẩu phải ít nhất 8 ký tự, chứa chữ hoa, chữ thường, số và ký tự đặc biệt.');
            e.preventDefault();
            return;
        }

    });
</script>
<script>
    // Truyền biến PHP sang JavaScript
    const errorMessage = <?= json_encode($errorMessage ?? '') ?>;
    const successMessage = <?= json_encode($successMessage ?? '') ?>;
    const loginErrorMessage = <?= json_encode($loginErrorMessage ?? '') ?>;

    document.addEventListener("DOMContentLoaded", function () {
        if (errorMessage) {
            console.log('Error Message:', errorMessage); // Debugging
            // Hiển thị modal nếu có lỗi
            const modal = new bootstrap.Modal(document.getElementById('registerModal'));
            modal.show();
            // Hiển thị thông báo lỗi
            document.getElementById('register-message').textContent = errorMessage;

        } else if (successMessage) {
            console.log('Success Message:', successMessage); // Debugging
            // Hiển thị modal nếu thành công
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
            // Hiển thị thông báo thành công
            document.getElementById('login-message').textContent = successMessage;
        }
        else   if (loginErrorMessage) {
            console.log('Error Message:', loginErrorMessage); // Debugging
            // Hiển thị modal nếu có lỗi
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
            // Hiển thị thông báo lỗi
            document.getElementById('login-message').textContent = loginErrorMessage;
        }
    });
</script>
</div>
