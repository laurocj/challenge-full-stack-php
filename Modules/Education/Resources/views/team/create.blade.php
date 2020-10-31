@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('teams.store') }}" method="post" class="card">
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('New record')}} - {{__('Team')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('teams.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>

    <div class="card-body">
        @check([
            'label' => __('Active'),
            'type' => 'checkbox',
            'name' => 'active'
        ])
        @input([
            'label' => __('Name'),
            'type' => 'text',
            'name' => 'name'
        ])
        @input([
            'label' => __('Shift'),
            'type' => 'text',
            'name' => 'shift'
        ])
        @input([
            'label' => __('Start date'),
            'type' => 'date',
            'name' => 'start_date'
        ])
        @input([
            'label' => __('End date'),
            'type' => 'date',
            'name' => 'end_date'
        ])

        @select([
            'label' => __('Course'),
            'name' => 'course_id',
            'url_search' => route('courses.search')
        ])

    </div>
</form>
@endsection


