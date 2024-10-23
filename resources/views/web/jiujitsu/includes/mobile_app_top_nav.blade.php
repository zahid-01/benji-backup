
<div class="top-navbar flex border-bottom">
    <div class="container flex justify-between flex-col flex-lg-row">
        <a class="navbar-brand navbar-order mr-0 flex items-center justify-center" href="/">
            @if(!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="site logo">
            @endif
        </a>

        <div class="top-contact-box border-bottom flex flex-col flex-md-row items-center justify-center">
            <div class="flex items-center justify-center">
                @if(!empty($generalSettings['site_phone']))
                    <span class="flex items-center py-10 py-lg-0 text-dark-blue text-sm">
                        <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                        {{ $generalSettings['site_phone'] }}
                    </span>
                @endif

                @if(!empty($generalSettings['site_email']))
                    <div class="border-left mx-5 mx-lg-15 h-100"></div>

                    <span class="flex items-center py-10 py-lg-0 text-dark-blue text-sm">
                        <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                        {{ $generalSettings['site_email'] }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
