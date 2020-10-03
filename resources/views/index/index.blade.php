@extends('common.layout')
@section('title')
主页
@endsection
@section('maintext')
<div class="container">
    <div class="jumbotron my-4">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">这是一个laravel项目.</p>
        <hr class="my-4">
        <h5>todo</h5>
        <ul>
            <li>修改头像(文件上传缩略图功能)(重写)</li>
            <li>权限管理RABC</li>
            <li>注册请求的数据库还没调整好</li>
            <li>改写thinkphp, image类</li>
        </ul>
        <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
      </div>
  </div>
@endsection