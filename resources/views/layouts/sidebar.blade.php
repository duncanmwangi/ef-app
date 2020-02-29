<div class="app-sidebar sidebar-shadow bg-light sidebar-text-dark">
    @include('layouts.header/logo')
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            @if(auth()->user()->isAdmin())
                @include('layouts.sidebar.adminMenu')
            @elseif(auth()->user()->isFundManager())
                @include('layouts.sidebar.fundManagerMenu')
            @elseif(auth()->user()->isInvestor())
                @include('layouts.sidebar.investorsMenu')
            @endif
        </div>
    </div>
</div>