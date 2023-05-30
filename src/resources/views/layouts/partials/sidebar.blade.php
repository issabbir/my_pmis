<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header ">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand mt-0" href="@if(Auth::user()->user_name == '000001') /cdb @else /dashboard  @endif "><img src="/app-assets/images/logo/cpa-logo.png" alt="users view avatar" class="img-fluid"/></a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content mt-1">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">

            <li class="nav-item sidebar-group-active">
                <a href="{{env('DASHBOARD_URL')}}"><i class="bx bx-home" data-icon="users"></i><span class="menu-item" data-i18n="Invoice List">Dashboard</span></a>
            </li>
{{--            @dd($menus)--}}
{{--            @php--}}
{{--             $pmis_menus=[1,2,3,4,5,6,7,8,9,10,11,16]--}}
{{--                @endphp--}}
              @foreach($menus as $menu)
                @if ($menu->module->enabled == 'Y' && (in_array($menu->menu_id,$access_menus)))
                    <li class="nav-item open sidebar-group-active open ok {{  trim(Route::currentRouteName()) === trim($menu->menu_name) ? 'sidebar-group-active open ok' : 'none' }}"><a href=""><i class="menu-livicon" data-icon="notebook"></i><span class="menu-item" data-i18n="Invoice List">{{$menu->menu_name}}</span></a>
                    <ul class="menu-content">
                        @foreach($menu->sub_menus as $submenu)
                                @if (Auth::user()->hasGrantAll() || in_array($submenu->submenu_id,$menu->role_submenus))
                                    <li class="is-shown">
                                        <a href="{{$submenu->route_name}}" @if ($submenu->route_name) title="{{$submenu->submenu_name}}" class="link_item" @endif><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Third Level">{{$submenu->submenu_name}}</span></a>
                                        @if (count($submenu->submenus)>0)
                                            <ul class="menu-content">
                                                @foreach($submenu->submenus as $smenu)
                                                    @if (Auth::user()->hasGrantAll() || in_array($smenu->submenu_id,$menu->role_submenus))
                                                        <li><a href="{{$smenu->route_name}}" class="link_item" title="{{$smenu->submenu_name}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item">{{$smenu->submenu_name}}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                        @endforeach
                    </ul>
                @endif
              @endforeach
        </ul>
    </div>
</div>

