<?php
    if(isset($_SESSION['loginError'])) {
        $errorMessage = $_SESSION['loginError'];
        unset($_SESSION['loginError']);
    }
    if(isset($_SESSION['loginSuccess'])) {
        $successMessage = $_SESSION['loginSuccess'];
        unset($_SESSION['loginSuccess']);
    }
?>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        
        <div class="modal-dialog" role="document">
            <?php
                if(isset($errorMessage)) 
                {
                    echo ' <div class="alert alert-error text-center" role="alert" id="login-message">Error </div>';
                }
                else if(isset($successMessage))
                {
                    echo ' <div class="alert alert-success text-center" role="alert" id="login-message">Success </div>';
                }
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập</label>
                            <input name="username" type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập">
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input name="password" type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                        </div>
                        <button type="submit" style="background-color:#7fad39; color:white;" class="btn btn-block">Đăng nhập</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <p class="text-center w-100">
                        Bạn chưa có tài khoản? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" class="text-primary">Đăng ký</a>
                    </p>
                </div>
            </div>
        </div>
    </div>