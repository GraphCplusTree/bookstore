<!doctype html>
<html lang="SC">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Pdfexe">
    <title>登陆</title>
    <link rel="stylesheet" href="{{asset('/bootstrap-4.0.0/dist/css/bootstrap.css')}}" >
    <link rel="stylesheet" href="{{asset('/login/login.css')}}" >
    <link rel="icon" href="{{asset('/login_img/icon.ico')}}">
</head>

<body class="text-center">
<a href="{{url('/')}}"><img class="mb-4" src="{{asset('login_img/login_title.png')}}" width="112" height="69"></a>
<h1 class="h3 mb-3 font-weight-normal">也许您需要登陆</h1>
@if(session('msg'))
<p>{{session('msg')}}</p>
@endif
<form class="form-signin" name="login" action="" method="post">
    {{csrf_field()}}
    <label for="inputEmail" class="sr-only  container">Email address</label>
    <input type=text name="name" class="form-control  container" placeholder="User ID" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <br>
    <input type=password name="password" class="form-control  container" placeholder="Password" required><br>
    <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
    <br>
</form>
<!-- <a href="signup.html" class="btn btn-lg btn-primary btn-block likeabutton">注册</a> -->
<button onclick="document.getElementById('id01').style.display='block'" class="btn btn-lg btn-primary btn-block likeabutton">Sign Up</button>

<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>

    <a href="{{url('/')}}"><img class="mb-4" src="{{asset('login_img/login_title.png')}}" width="112" height="69"></a>
    <h1 class="h3 mb-3 font-weight-normal">欢迎注册！</h1>
    <form class="form-signin" name="login" action="{{url('signup')}}" method="post">
        {{csrf_field()}}
        <label for="inputEmail" class="sr-only  container">Email address</label>
        <input type=text name="name" class="form-control  container" placeholder="User ID" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <br>
        <input type=password name="password" class="form-control  container" placeholder="Password" required><br>
        <button class="btn btn-lg btn-primary btn-block container" type="submit">注册</button>
    </form>

</div>
</body>
</html>

