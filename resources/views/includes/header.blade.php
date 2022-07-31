<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('user.Dashboard')}}">Trello</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0">
                    @if (Auth::guard('user')->check())
                        <li class="nav-item me-4">
                            <a href="{{route('user.Dashboard')}}" class="btn">{{(Auth::guard('user')->user()->name)}}'s Dashboard</a>
                        </li>
                    @endif
                        <li class="nav-item me-4">
                            <a href="{{route('user.Logout')}}" class="nav-link btn btn-sm btn-danger" style="color: white">Logout</a>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
