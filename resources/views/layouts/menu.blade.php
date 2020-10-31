<nav class="h-100 menu px-0 border">
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action {{ Route::is('students.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('students.*') ? 'true' : 'false' }}"
            href="{{ route('students.index') }}">{{ __('Student') }}</a>

    </div>
</nav>
