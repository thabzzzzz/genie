<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-maintheme ">
    <div>
        @isset($logo)
            {{ $logo }}
        @else
            <Link href="/">
                <x-application-logo class="w-24 h-20 fill-current text-gray-500" />
            </Link>
        @endisset
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-maintheme overflow-hidden border border-black">        {{ $slot }}
    </div>
</div>
