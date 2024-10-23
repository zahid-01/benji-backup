@if (!empty($authUser))
    <div class="border-r border-black h-full">&nbsp;</div>
    @if ($authUser->role->name == 'teacher')
        <a href="{{ url('panel/webinars/new') }}" class="btn btn-link hover:opacity-60 no-underline hover:no-underline text-black">
            Create a Course
        </a>
    @endif

    <details class="dropdown dropdown-end">
        <summary tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
                <img src="{{ $authUser->getAvatar() }}" alt="{{ $authUser->full_name }}">
                {{-- <span class="font-16 user-name ml-10 text-dark-blue text-sm">{{ $authUser->full_name }}</span> --}}
            </div>
        </summary>

        <div class="dropdown-content z-50 bg-white shadow-2xl w-64 p-4">

            <div class="dropdown-user-avatar flex items-center rounded-sm">
                <div class="w-14 h-14 rounded-full relative">
                    <img src="{{ $authUser->getAvatar() }}" class="img-cover rounded-full"
                        alt="{{ $authUser->full_name }}">
                </div>

                <div class="ml-2">
                    <div class="text-sm font-bold text-black">{{ $authUser->full_name }}</div>
                    <span class="mt-5 text-slate-500 text-sm">{{ $authUser->role->caption }}</span>
                </div>
            </div>

            <ul class="my-2">
                @if ($authUser->isAdmin())
                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ getAdminPanelUrl() }}"
                            class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/dashboard.svg" class="icons">
                            <span class="ml-2">{{ trans('panel.dashboard') }}</span>
                        </a>
                    </li>

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ getAdminPanelUrl('/settings') }}"
                            class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/settings.svg" class="icons">
                            <span class="ml-2">{{ trans('panel.settings') }}</span>
                        </a>
                    </li>
                @else
                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel" class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/dashboard.svg" class="icons">
                            <span class="ml-2">{{ trans('panel.dashboard') }}</span>
                        </a>
                    </li>


                    <li class="navbar-auth-user-dropdown-item">
                        <a href="{{ $authUser->isUser() ? '/panel/webinars/purchases' : '/panel/webinars' }}"
                            class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/my_courses.svg" class="icons">
                            <span class="ml-2">{{ trans('update.my_courses') }}</span>
                        </a>
                    </li>

                    @if (!$authUser->isUser())
                        <li class="navbar-auth-user-dropdown-item">
                            <a href="/panel/financial/sales"
                                class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                                <img src="/assets/default/img/icons/user_menu/sales_history.svg" class="icons">
                                <span class="ml-2">{{ trans('financial.sales_history') }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel/support"
                            class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/support.svg" class="icons">
                            <span class="ml-2">{{ trans('panel.support') }}</span>
                        </a>
                    </li>

                    @if (!$authUser->isUser())
                        <li class="navbar-auth-user-dropdown-item">
                            <a href="{{ $authUser->getProfileUrl() }}"
                                class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                                <img src="/assets/default/img/icons/user_menu/profile.svg" class="icons">
                                <span class="ml-2">{{ trans('public.profile') }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="navbar-auth-user-dropdown-item">
                        <a href="/panel/setting"
                            class="flex items-center w-full py-3 text-slate-500 text-sm bg-transparent">
                            <img src="/assets/default/img/icons/user_menu/settings.svg" class="icons">
                            <span class="ml-2">{{ trans('panel.settings') }}</span>
                        </a>
                    </li>
                @endif

                <li class="navbar-auth-user-dropdown-item">
                    <a href="/logout" class="flex items-center w-full py-3 text-danger text-sm bg-transparent">
                        <img src="/assets/default/img/icons/user_menu/logout.svg" class="icons">
                        <span class="ml-2">{{ trans('auth.logout') }}</span>
                    </a>
                </li>

            </ul>

        </div>
    </details>
@else
    <div class="flex">
        <a href="/login" class="btn btn-ghost">{{ trans('auth.login') }}</a>
        <a href="/register" class="btn btn-primary shadow-lg">{{ trans('auth.sign_up') }}</a>
    </div>
@endif
