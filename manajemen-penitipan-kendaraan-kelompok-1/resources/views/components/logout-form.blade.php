@props(['route', 'guard' => null])

<form action="{{ $route }}" method="POST" class="d-none" id="logout-form{{ $guard ? '-' . $guard : '' }}">
    @csrf
</form>
 
<a class="dropdown-item" href="{{ $route }}"
   onclick="document.getElementById('logout-form{{ $guard ? '-' . $guard : '' }}').submit(); return false;">
    Logout
</a> 