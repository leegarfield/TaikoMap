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
            <h4 class="modal-title">登录</h4>
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
            <h4 class="modal-title">注册</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning"><strong id='signupModal_alert'>带*号的为必填项</strong></div>
            <form id='signupForm' action="" method="post">
              <div class="form-group">
                <label for="InputNickname2">*输入昵称</label>
                <input name="nickname" type="text" class="form-control" id="InputNickname2" placeholder="nickname">
              </div>
              <div class="form-group">
                <label for="InputPassword2">*输入密码</label>
                <input name="password" type="password" class="form-control" id="InputPassword2" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="ConfirmPassword1">*确认密码</label>
                <input name="password2" type="password" class="form-control" id="ConfirmPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="InputEmail1">*设置一个邮箱</label>
                <input name="email_addr" type="email" class="form-control" id="InputEmail1" placeholder="abc@example.com">
              </div>
              <div class="checkbox">
                <label>
                  <input name="check" type="checkbox" id='CheckBox1'> 确认遵守目前还不存在的用户协议
                </label>
              </div>
            </form>
            <div id='verlifyForm' style="display: none;">
              <form action="" method="post">
                <div class="form-group">
                  <label for="InputCode">请前往邮箱，输入获取到的校验码</label>
                  <input name="token" type="number" class="form-control" id="InputToken1" placeholder="123456">
                </div>
              </form>
              <button type="submit" class="btn btn-success" id="signupModal_btn2">提交校验码</button>
              <button type="submit" class="btn btn-warning" id="signupModal_btn3">返回修改邮箱</button>
            </div>
            <br />
            <button type="submit" class="btn btn-block btn-primary" id="signupModal_btn">发送验证邮件</button>
            <button style="display: none;" type="submit" class="btn btn-block btn-warning" id="signupModal_btn4">返回填写校验码</button>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function(){
          $('#signupModal_btn').click(function(){
            $('#signupModal_btn').text("发送中。。。");
            var post = {
              nickname : $('#InputNickname2').val(),
              password : $('#InputPassword2').val(),
              password2 : $('#ConfirmPassword1').val(),
              email_addr : $('#InputEmail1').val(),
              check : $('#CheckBox1').prop("checked")
            };

            unSyncPost(post, '/php/signup.php', function(data){
              if(data == 'success'){
                $('#signupModal_btn').text("再次发送");
                $('#signupModal_alert').text("发送成功！");
                $('#signupModal_alert').parent().removeClass('alert-warning');
                $('#signupModal_alert').parent().removeClass('alert-danger');
                $('#signupModal_alert').parent().addClass('alert-success');
                $('#signupForm').hide();
                $('#signupModal_btn4').hide();
                $('#verlifyForm').show();
              }else{
                $('#signupModal_alert').text(data);
                $('#signupModal_alert').parent().removeClass('alert-warning');
                $('#signupModal_alert').parent().removeClass('alert-success');
                $('#signupModal_alert').parent().addClass('alert-danger');
                $('#signupModal_btn').text("发送验证邮件");
              }
            });
          });

          $('#signupModal_btn2').click(function(){
            var post = {
              token: $('#InputToken1').val()
            };

            unSyncPost(post, '/php/signup.php', function(data){
              if(data == 'success'){
                $('#signupModal_alert').text('注册成功！即将自动<a href="/">刷新页面</a>');
                $('#signupModal_alert').parent().removeClass('alert-warning');
                $('#signupModal_alert').parent().removeClass('alert-danger');
                $('#signupModal_alert').parent().addClass('alert-success');
                $('#verlifyForm').hide();
                setTimeout(function(){
                  window.location.reload(true);
                }, 1000)
              }else{
                $('#signupModal_alert').text(data);
                $('#signupModal_alert').parent().removeClass('alert-warning');
                $('#signupModal_alert').parent().removeClass('alert-success');
                $('#signupModal_alert').parent().addClass('alert-danger');
              }
            });
          });

          $('#signupModal_btn3').click(function(){
            $('#signupForm').show();
            $('#signupModal_btn4').show();
            $('#verlifyForm').hide();
          });
          $('#signupModal_btn4').click(function(){
            $('#signupForm').hide();
            $('#signupModal_btn4').hide();
            $('#verlifyForm').show();
          });
        });
      </script>
    </div>
<?php
}
?>