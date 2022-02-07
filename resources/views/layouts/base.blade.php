<!DOCTYPE html>
<html lang="en">
@extends('layouts.head')

<body>
    {{-- @extends('idiomas') --}}

    <div class="container pt-5">
        @yield('idiomas')

        @yield('content')
    </div>
</body>

</html>
