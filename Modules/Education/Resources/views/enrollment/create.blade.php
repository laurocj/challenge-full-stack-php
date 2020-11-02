@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('enrollments.store') }}" method="post" class="card">
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('New record')}} - {{__('Enrollment')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('enrollments.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>

    <div class="card-body">
        @check([
            'label' => __('Active'),
            'type' => 'checkbox',
            'name' => 'active'
        ])
        @select([
            'label' => __('Team'),
            'name' => 'team_id',
            'url_search' => route('teams.search')
        ])
        @select([
            'label' => __('Student'),
            'name' => 'student_id',
            'url_search' => route('students.search')
        ])

    </div>
</form>
@endsection
