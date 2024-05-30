<header class="header">
    {{-- @if( Auth::check() ) --}}
    <div class="header-content">
        <div id="open"><i class="bi bi-list"></i></div>
        <h1 class="header-ttl">Rese</h1>
    </div>
    <div id="mask" class="hidden"></div>
    <section id="modal" class="hidden">
        <div id="close"><i class="bi bi-x"></i></div>

        <nav class="header-nav">
            <ul class="header-nav-list">
                <li class="header-nav-item"><a href="/">HOME</a></li>
                <li class="header-nav-item"><a href="/">Logout</a></li>
                <li class="header-nav-item"><a href="/">Mypage</a></li>
            </ul>
        </nav>
    </section>
    <script src="js/header.js"></script>

    {{-- @endif --}}
</header>
