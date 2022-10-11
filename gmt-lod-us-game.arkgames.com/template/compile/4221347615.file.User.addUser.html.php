<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F1282025408";a:2:{i:0;s:38:"../template/template/User.addUser.html";i:1;i:1665370249;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2022-10-10 05:50:56
         compiled from "../template/template/User.addUser.html" */ ?>
<div  id="bodyTitle">添加用户账号</div>
<div class="bodyContent"  style="border-top: 2px solid #666;">
  <div class="bodyContentBody">
  <div class="bodyContentHead" >
      <iframe id="iframeload" name="iframeload" src="/img/1.gif" style="width:0px; height:0px; display:none" frameborder="0" scrolling="no">
</iframe>
  <form name="myform" id="myform" action="?act=User.addUser" method="post" target="iframeload" >
    <table align="left" cellspacing="1" cellpadding="0" class="userTable" style="width:80%;" id="tbl">

    <tr>
      <td align="right">用户名字：</td>
      <td align="left"><input type="name" name="name" id="name" style="width:200px" /></td>
    </tr>
    <tr >
      <td align="right">用户密码：</td>
      <td align="left"><input type="password" name="password" id="password" style="width:200px" /></td>
    </tr>
    <tr >
      <td align="right">重复输入密码：</td>
      <td align="left"><input type="password2" name="password2" id="password2" style="width:200px" /></td>
    </tr>
    </table>

    <div style="width:50%;margin:auto;">

    <input name="submit" type="submit" class="submit"  value="提交" />
    </div>
  </form>
</div>


</div>
</div>
