
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Investor Menu</li>
                <li class="@if(Route::currentRouteName()=='admin.dashboard') mm-active @endif" >
                    <a href="{{ route('admin.dashboard') }}"  class="@if(Route::currentRouteName()=='admin.dashboard') mm-active @endif">
                        <i class="metismenu-icon lnr-pie-chart">
                        </i>Dashboard
                    </a>
                </li>
                <li  class="@if(in_array(Route::currentRouteName(),['admin.investmentvehicles.create','admin.investmentvehicles.index'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-bus">
                        </i>Investment Vehicles
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.investmentvehicles.create') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Add Investment Vehicle
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.investmentvehicles.index') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>All Investment Vehicles
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="@if(in_array(Route::currentRouteName(),['admin.users.create','admin.users.index'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-users">
                        </i>Users
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.users.create') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Add User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.users.index') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>All Users
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="@if(in_array(Route::currentRouteName(),['admin.investments.create','admin.investments.index'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-chart-bars">
                        </i>Investments
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.investments.create') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Add Investment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.investments.index') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>All Investments
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.earnings') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>Earnings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.leads') mm-active @endif">
                        <i class="metismenu-icon lnr-star">
                        </i>Leads
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName()=='admin.settings') mm-active @endif">
                        <i class="metismenu-icon lnr-cog">
                        </i>Settings
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