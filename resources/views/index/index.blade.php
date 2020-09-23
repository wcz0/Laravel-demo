@extends('common.layout')

@section('maintext')
<div class="container">
    <div class="jumbotron my-4">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">这是一个laravel项目.</p>
        <hr class="my-4">
        <h5>todo</h5>
        <ul>
            <li>cookie设置方法</li>
            <li>数据库相关重写</li>
            <li>修改头像(文件上传缩略图功能)(重写)</li>
            <li>模板逻辑重构</li>
        </ul>
        <a class="btn btn-primary btn-lg" href="vscode:" role="button">Just do it</a>
      </div>
  </div>
@endsection