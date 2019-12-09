<div class="app-page-title m-0 mb-3 p-0">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="
                @if(in_array(Route::currentRouteName(),['admin.users.create','admin.users.index'])) lnr-users
                @elseif(in_array(Route::currentRouteName(),['common.password.edit','common.profile.edit'])) lnr-user
                @else pe-7s-car
                @endif
                icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>@yield('heading','Heading')
                <div class="page-title-subheading">@yield('sub-heading','')
                </div>
            </div>
        </div>
    </div>
</div>
