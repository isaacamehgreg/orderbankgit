@if(\auth()->user()->role == 1)
    @include('super_admin_menu')
@elseif(\auth()->user()->role == 2)
    @include('staff_menu')
@elseif(\auth()->user()->role == 3)
    @include('administrative_menu')
@elseif(auth()->user()->role == 4)
    @include('accountant_menu')
@endif
