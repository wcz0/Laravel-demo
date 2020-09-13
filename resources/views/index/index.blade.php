@extends('common.layout')

@section('maintext')
<div class="container">
    <div class="jumbotron my-4">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">这是一个thinkphp项目.</p>
        <hr class="my-4">
        <h5>已实现功能</h5>
        <ul>
            <li>注册登录</li>
            <li>个人资料修改(表单提交)</li>
            <li>修改头像(文件上传缩略图功能)</li>
            <li>记住登录状态(cookie实现)</li>
            <li>权限管理</li>
        </ul>
        <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
      </div>
  </div>
@stop