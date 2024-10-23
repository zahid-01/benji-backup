<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">

@php
$rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

$isRtl = (in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages) or !empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1);
@endphp

<head>
    @include('web.jiujitsu.includes.metas')
    <title>
        {{ $pageTitle ?? '' }}{{ !empty($generalSettings['site_name']) ? ' | ' . $generalSettings['site_name'] : '' }}
    </title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-slate-400">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-xl font-black text-center">myJiujitsu.com <br><span class="text-base">is in Beta</span></h1>
            <h2 class="my-4 text-center">Enter Password to enter</h2>
            <form action="{{ route('unlock') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" required name="password" id="password" autocomplete="current-password" placeholder="Enter password" class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                @error('password')
                <div class="text-red-500 mb-4 text-sm">{{ $message }}</div>
                @enderror
                <div class="flex justify-center">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>