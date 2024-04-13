@props(['as' => 'Link'])

<{{ $as }} {{ $attributes->class('block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-zinc-950 hover:text-white focus:outline-none focus:bg-gray-100 transition duration-210 ease-in-out') }}>{{ $slot }}</{{ $as }}>
