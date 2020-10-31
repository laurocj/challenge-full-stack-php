<nav class="h-100 menu px-0 border">
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action {{ Route::is('students.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('students.*') ? 'true' : 'false' }}"
            href="{{ route('students.index') }}">{{ __('Students') }}</a>

        <a class="list-group-item list-group-item-action {{ Route::is('courses.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('courses.*') ? 'true' : 'false' }}"
            href="{{ route('courses.index') }}">{{ __('Courses') }}</a>

        <a class="list-group-item list-group-item-action {{ Route::is('teams.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('teams.*') ? 'true' : 'false' }}"
            href="{{ route('teams.index') }}">{{ __('Teams') }}</a>

    </div>
</nav>
