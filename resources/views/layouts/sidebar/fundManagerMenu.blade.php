
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Fund MAnager Menu</li>
                <li class="@if(Route::currentRouteName()=='fm.dashboard') mm-active @endif" >
                    <a href="{{ route('fm.dashboard') }}"  class="@if(Route::currentRouteName()=='fm.dashboard') mm-active @endif">
                        <i class="metismenu-icon lnr-pie-chart">
                        </i>Dashboard
                    </a>
                </li>
                

                <li class="@if(Route::currentRouteName()=='fm.investment-vehicles.index') mm-active @endif" >
                    <a href="{{ route('fm.investment-vehicles.index') }}" class="@if(Route::currentRouteName()=='fm.investment-vehicles.index') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>Investment Funds
                    </a>
                </li>
                <li class="@if(in_array(Route::currentRouteName(),['fm.investors.create','fm.investors.index'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-users">
                        </i>Investors
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('fm.investors.create') }}" class="@if(Route::currentRouteName()=='fm.investors.create') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Add Investor
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fm.investors.index') }}" class="@if(Route::currentRouteName()=='fm.investors.index') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>All Investors
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="@if(in_array(Route::currentRouteName(),['fm.investments.create','fm.investments.index'])) mm-active @endif">
                    <a href="#">
                        <i class="metismenu-icon lnr-chart-bars">
                        </i>Investments
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('fm.investments.create') }}" class="@if(Route::currentRouteName()=='fm.investments.create') mm-active @endif">
                                <i class="metismenu-icon"></i>
                                Add Investment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('fm.investments.index') }}" class="@if(Route::currentRouteName()=='fm.investments.index') mm-active @endif">
                                <i class="metismenu-icon">
                                </i>All Investments
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="@if(Route::currentRouteName()=='fm.earnings.index') mm-active @endif" >
                    <a href="{{ route('fm.earnings.index') }}" class="@if(Route::currentRouteName()=='fm.earnings.index') mm-active @endif">
                        <i class="metismenu-icon lnr-cart">
                        </i>Earnings
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