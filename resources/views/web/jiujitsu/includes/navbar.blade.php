@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }

    $navBtnUrl = null;
    $navBtnText = null;

    if (request()->is('forums*')) {
        $navBtnUrl = '/forums/create-topic';
        $navBtnText = trans('update.create_new_topic');
    } else {
        $navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null, empty($authUser));

        if (!empty($navbarButton)) {
            $navBtnUrl = $navbarButton->url;
            $navBtnText = $navbarButton->title;
        }
    }
@endphp

<div class="navbar bg-base-100 mb-3">
    <div class="navbar-start">
        {{-- <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a>Item 1</a></li>
                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div> --}}
        <button class="hidden lg:inline-block btn btn-ghost hover:bg-white px-0 mr-3" id="toggleSideMenu">
            <svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 1H0V0H18V1ZM18 6H0V7H18V6ZM18 12H0V13H18V12Z" fill="#030303" />
            </svg>
        </button>
        <button class="inline-block lg:hidden btn btn-ghost hover:bg-white px-0 mr-3" id="toggleSideMenuMobile">
            <svg width="18" height="13" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 1H0V0H18V1ZM18 6H0V7H18V6ZM18 12H0V13H18V12Z" fill="#030303" />
            </svg>
        </button>
        <a href="{{ url('/') }}" class="text-xl font-black">{{ $generalSettings['site_name'] }}</a>
    </div>
    <div class="navbar-center hidden lg:flex w-full max-w-xl justify-center">

        <form action="/search" method="get" class="join w-full">
            <input class="input input-bordered border-borderGray join-item rounded-full w-full shadow-inner"
                placeholder="Search" name="search" />
            <button class="rounded-r-full border border-borderGray px-6 bg-gray hover:bg-borderGray">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17.87 17.17L12.28 11.58C13.35 10.35 14 8.75 14 7C14 3.13 10.87 0 7 0C3.13 0 0 3.13 0 7C0 10.87 3.13 14 7 14C8.75 14 10.35 13.35 11.58 12.29L17.17 17.88L17.87 17.17ZM7 13C3.69 13 1 10.31 1 7C1 3.69 3.69 1 7 1C10.31 1 13 3.69 13 7C13 10.31 10.31 13 7 13Z"
                        fill="#0F0F0F" />
                </svg>
            </button>
            {{-- <button class="rounded-full px-4 bg-gray ml-4 hover:bg-borderGray" type="submit">
                <svg width="14" height="18" viewBox="0 0 14 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7 0C5.34 0 4 1.37 4 3.07V8.93C4 10.63 5.34 12 7 12C8.66 12 10 10.63 10 8.93V3.07C10 1.37 8.66 0 7 0ZM13.5 9H12.5C12.5 12.03 10.03 14.5 7 14.5C3.97 14.5 1.5 12.03 1.5 9H0.5C0.5 12.24 2.89 14.93 6 15.41V18H8V15.41C11.11 14.93 13.5 12.24 13.5 9Z"
                        fill="#0F0F0F" />
                </svg>
            </button> --}}
        </form>

    </div>
    <div class="navbar-end flex">

        @include('web.jiujitsu.includes.shopping-cart-dropdwon')

        @include('web.jiujitsu.includes.top_nav.user_menu')
    </div>
</div>

{{-- @push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>
@endpush --}}
