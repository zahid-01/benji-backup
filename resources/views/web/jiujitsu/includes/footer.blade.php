@php
    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)
            ->sortBy('order')
            ->toArray();
    }

    $footerColumns = getFooterColumns();
@endphp
<div class="bg-blue text-white">
    <div class="container mx-auto pt-20 px-20">
        <footer class="flex pb-4">
            <div class="flex w-full lg:w-1/2">
                <div class="w-full lg:w-1/2">
                    <h3 class="font-bold mb-6">About Us</h3>
                    <p class="text-sm font-light max-w-[200px]">
                        MyJiuJitsu.com is a web-based Jiu Jitsu marketplace & community, where
                        instructors can connect with students through instructional courses. Users can purchase and
                        watch
                        these video instructionals, and interact with their instructors and other students through their
                        courses and discussion sections.
                    </p>
                </div>
                <nav class="w-full lg:w-1/2">
                    <div class="flex flex-col mx-16">
                        <h3 class="font-bold mb-6">About Us</h3>
                        <a href="#" class="hover:text-primary text-sm font-light">Login</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Register</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Blog</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Contact Us</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Certificate</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Validation</a>
                        <a href="#" class="hover:text-primary text-sm font-light">Terms & Rules</a>
                        <a href="#" class="hover:text-primary text-sm font-light">About us</a>
                    </div>
                </nav>
            </div>
            <div class="w-full lg:w-1/2 text-right">
                <a href="<?php echo url("/") ?>" class="text-xl font-black">{{ $generalSettings['site_name'] }}</a>
            </div>
        </footer>
        @if (getOthersPersonalizationSettings('platform_phone_and_email_position') == 'footer')

            <div class="flex justify-between py-4 border-t border-slate-500">
                <a href="<?php echo url("/") ?>" class="text-xl font-black">{{ $generalSettings['site_name'] }}</a>
                <div class="flex">
                    @if (!empty($generalSettings['site_phone']))
                        <div class="flex text-sm">
                            <i data-feather="phone" width="20" height="20" class="mr-3"></i>
                            {{ $generalSettings['site_phone'] }}
                        </div>
                    @endif

                    @if (!empty($generalSettings['site_email']))
                        <div class="border-left mx-5 mx-lg-15 h-100"></div>
                        <div class="flex text-sm">
                            <i data-feather="mail" width="20" height="20" class="mr-3"></i>
                            {{ $generalSettings['site_email'] }}
                        </div>
                    @endif
                </div>
            </div>

        @endif
    </div>
    <div class="bg-black/20">
        <div class="container mx-auto px-20 ">
            <footer class="footer py-4">
                <aside class="items-center grid-flow-col">
                    {{ trans('update.platform_copyright_hint') }}
                </aside>
                <nav class="md:place-self-center md:justify-self-end">
                    <div class="grid grid-flow-col gap-4">
                        @if (!empty($socials) and count($socials))
                            @foreach ($socials as $social)
                                <a href="{{ $social['link'] }}" target="_blank" class="w-6">
                                    <img src="{{ $social['image'] }}" alt="{{ $social['title'] }}" class="mr-15">
                                </a>
                            @endforeach
                        @endif
                    </div>
                </nav>
            </footer>
        </div>
    </div>
</div>

{{-- <footer class="footer bg-secondary relative user-select-none"> --}}
{{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <div class=" footer-subscribe block d-mflex items-center justify-between">
                    <div class="grow">
                        <strong>{{ trans('footer.join_us_today') }}</strong>
                        <span class="block mt-5 text-white">{{ trans('footer.subscribe_content') }}</span>
                    </div>
                    <div class="subscribe-input bg-white p-10 grow mt-6 mt-md-0">
                        <form action="/newsletters" method="post">
                            {{ csrf_field() }}

                            <div class="form-group flex items-center m-0">
                                <div class="w-full">
                                    <input type="text" name="newsletter_email" class="form-control border-0 @error('newsletter_email') is-invalid @enderror" placeholder="{{ trans('footer.enter_email_here') }}"/>
                                    @error('newsletter_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary rounded-pill">{{ trans('footer.join') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $columns = ['first_column','second_column','third_column','forth_column'];
    @endphp

    <div class="container">
        <div class="row">

            @foreach ($columns as $column)
                <div class="col-6 col-md-3">
                    @if (!empty($footerColumns[$column]))
                        @if (!empty($footerColumns[$column]['title']))
                            <span class="header block text-white font-bold">{{ $footerColumns[$column]['title'] }}</span>
                        @endif

                        @if (!empty($footerColumns[$column]['value']))
                            <div class="mt-4">
                                {!! $footerColumns[$column]['value'] !!}
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach

        </div>

        <div class="mt-14 border-blue py-25 flex items-center justify-between">
            <div class="footer-logo">
                <a href="/">
                    @if (!empty($generalSettings['footer_logo']))
                        <img src="{{ $generalSettings['footer_logo'] }}" class="img-cover" alt="footer logo">
                    @endif
                </a>
            </div>
            <div class="footer-social">
                @if (!empty($socials) and count($socials))
                    @foreach ($socials as $social)
                        <a href="{{ $social['link'] }}">
                            <img src="{{ $social['image'] }}" alt="{{ $social['title'] }}" class="mr-15">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @if (getOthersPersonalizationSettings('platform_phone_and_email_position') == 'footer')
        <div class="footer-copyright-card">
            <div class="container flex items-center justify-between py-15">
                <div class="text-sm text-white">{{ trans('update.platform_copyright_hint') }}</div>

                <div class="flex items-center justify-center">
                    @if (!empty($generalSettings['site_phone']))
                        <div class="flex items-center text-white text-sm">
                            <i data-feather="phone" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_phone'] }}
                        </div>
                    @endif

                    @if (!empty($generalSettings['site_email']))
                        <div class="border-left mx-5 mx-lg-15 h-100"></div>

                        <div class="flex items-center text-white text-sm">
                            <i data-feather="mail" width="20" height="20" class="mr-10"></i>
                            {{ $generalSettings['site_email'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif --}}

{{-- </footer> --}}
