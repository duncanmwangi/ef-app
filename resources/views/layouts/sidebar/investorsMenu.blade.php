
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Investor Menu</li>
                <li class="@if(Route::currentRouteName()=='investor.dashboard') mm-active @endif" >
                    <a href="{{ route('investor.dashboard') }}"  class="@if(Route::currentRouteName()=='investor.dashboard') mm-active @endif">
                        <i class="metismenu-icon lnr-pie-chart">
                        </i>Dashboard
                    </a>
                </li>

                <li class="@if(Route::currentRouteName()=='investor.investment-vehicles.index') mm-active @endif" >
                    <a href="{{ route('investor.investment-vehicles.index') }}" class="@if(Route::currentRouteName()=='investor.investment-vehicles.index') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>Investment Vehicles
                    </a>
                </li>
        
                <li class="@if(Route::currentRouteName()=='investor.investments.index') mm-active @endif" >
                    <a href="{{ route('investor.investments.index') }}" class="@if(Route::currentRouteName()=='investor.investments.index') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>My Investments
                    </a>
                </li>
                <li class="@if(Route::currentRouteName()=='investor.earnings.index') mm-active @endif" >
                    <a href="{{ route('investor.earnings.index') }}" class="@if(Route::currentRouteName()=='investor.earnings.index') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>My Earnings
                    </a>
                </li>

                <li class="@if(in_array(Route::currentRouteName(),['common.password.edit','common.profile.edit'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-user">
                        </i>My Profile
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('common.password.edit') }}" class="@if(Route::currentRouteName()=='common.password.edit') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('common.profile.edit') }}" class="@if(Route::currentRouteName()=='common.profile.edit') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>Edit Profile
                            </a>
                        </li>
                        
                    </ul>
                </li>

            </ul>