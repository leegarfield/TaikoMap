<?php
if (isset($acc['NUM'])){
    echo '<!-- already login -->';
}else{
?>
    <!-- login modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Login</h4>
          </div>
          <div class="modal-body">
            <form id='loginForm' action="/php/login.php" method="post">
              <div class="form-group">
                <label for="InputNickname1">昵称</label>
                <input name="nickname" type="text" class="form-control" id="InputNickname1" placeholder="nickname">
              </div>
              <div class="form-group">
                <label for="InputPassword1">密码</label>
                <input name="password" type="password" class="form-control" id="InputPassword1" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-primary">登录</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- signup modal -->
    <div class="modal fade" id="modalSignup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Signup</h4>
          </div>
          <div class="modal-body">
            <form id='signupForm' action="/php/signup.php" method="post">
              <div class="form-group">
                <label for="InputNickname2">输入昵称</label>
                <input name="nickname" type="text" class="form-control" id="InputNickname2" placeholder="nickname">
              </div>
              <div class="form-group">
                <label for="InputPassword2">输入密码</label>
                <input name="password" type="password" class="form-control" id="InputPassword2" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword1">确认密码</label>
                <input name="password2" type="password" class="form-control" id="ConfirmPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="InputEmail1">(可选)设置一个邮箱用于密码找回(暂不可用)</label>
                <input name="email" type="email" class="form-control" id="InputEmail1" placeholder="abc@example.com">
              </div>
              <div class="checkbox">
                <label>
                  <input name="check" type="checkbox"> 确认遵守目前还不存在的用户协议
                </label>
              </div>
              <button type="submit" class="btn btn-primary">注册</button>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php
}
?>