<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Адмінка') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/admin_app.css') }}" rel="stylesheet">
    <!-- materialize -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<style>
.router-link-exact-active{font-size: 20px;
                    font-weight: bold;
                    text-decoration: underline;}
</style>
</head>
<body>

<nav class="light-blue accent-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="{{ url('/') }}" class="brand-logo">Logo</a>
    @guest
        <ul class="right hide-on-med-and-down">
            <li><a href="{{ route('login') }}">Вхід</a></li>
            @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}">Зареєструватись</a>
                </li>
            @endif
        </ul>
    @else
      <ul class="right hide-on-med-and-down text-blue text-darken-4">
        <li><a class="text-blue text-darken-4" href="{{ url('/admin') }}">Вітаємо, {{ Auth::user()->name }}! [{{ Auth::user()->role }}]</a></li>
        <li><a class="text-blue text-darken-4" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Вихід
        </a></li>
      </ul>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
      @endguest
    </div>
  </nav>

    <main class="container">
        <div id="app">
            <app></app>
          </div>
    </main>

    <footer class="page-footer light-blue accent-1">
        <div class="footer-copyright">
          <div class="container">
          Made by <a class="text-blue text-darken-4" href="http://materializecss.com">Materialize</a>
          </div>
        </div>
      </footer>
<style>
body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
}
main {
  flex: 1 0 auto;
}
</style>

  <script src="{{ mix('js/admin_app.js') }}"></script>
</body>
</html>