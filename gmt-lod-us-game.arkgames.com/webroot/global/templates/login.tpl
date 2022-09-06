{include file="header.tpl"}

<div class="container">
    <form action="login.php" class="form-horizontal"  role="form" method="get">
        <fieldset>
            <legend>{include file="default_top.tpl"}</legend>

			<div class="form-group">
			    <label for="auth_user">用户名</label>
			    <input type="text" class="form-control" name="auth_user" id="auth_user" placeholder="User" value="{$auth_user}">
			  </div>
			  <div class="form-group">
			    <label for="auth_pwd">密码</label>
			    <input type="password" class="form-control" name="auth_pwd" id="auth_pwd" placeholder="Password">
  			</div>

            <div class="col-md-7 control-label">
            	<input type="hidden" id="t" name="t" value="{$t}" />
				<input type="hidden" id="s" name="s" value="{$s}" />
                <input type="hidden" id="php_self" name="php_self" value="{$php_self}" />
            	<input type="hidden" id="do_search" name="do_search" value="do" />
            	<button type="submit" class="btn btn-success">登录</button>
            </div>
        </fieldset>
	</form>
</div>


{include file="footer.tpl"}
