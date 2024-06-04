<div class="nav">
    {{-- @if( Auth::check() ) --}}
    <div class="nav-content">
        <div id="open"><i class="bi bi-list"></i></div>
        <h1 class="nav-ttl">Rese</h1>
    </div>
    <div id="mask" class="hidden"></div>
    <section id="modal" class="hidden">
        <div id="close"><i class="bi bi-x"></i></div>
        <nav class="modal-nav">
            <ul class="modal-nav-list">
                <li class="modal-nav-item"><a href="/">HOME</a></li>
                <li class="modal-nav-item"><a href="/">Logout</a></li>
                <li class="modal-nav-item"><a href="/">Mypage</a></li>
            </ul>
        </nav>
    </section>
    <script src="js/nav.js"></script>

    {{-- @endif --}}
</div>
