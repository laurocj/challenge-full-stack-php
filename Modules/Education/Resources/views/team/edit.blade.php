@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('teams.update', $team->id) }}" class="card" method="post">
    @method('put')
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('Edit record')}} - {{__('Team')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('teams.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>
    <div class="card-body">
        @check([
            'label' => __('Active'),
            'type' => 'checkbox',
            'name' => 'active',
			"value" => $team->active,
			"elements" => "checked=".$team->active
        ])
        @input([
            'label' => __('Name'),
            'type' => 'text',
            'name' => 'name',
			"value" => $team->name
        ])
        @input([
            'label' => __('Shift'),
            'type' => 'text',
            'name' => 'shift',
			"value" => $team->shift
        ])
        @input([
            'label' => __('Start date'),
            'type' => 'date',
            'name' => 'start_date',
			"value" => $team->start_date
        ])
        @input([
            'label' => __('End date'),
            'type' => 'date',
            'name' => 'end_date',
			"value" => $team->end_date
        ])
        @select([
            'label' => __('Course'),
            'name' => 'course_id',
            'url_search' => route('courses.search'),
            'value' => $team->course_id,
            "options" => [$team->course_id => $team->course->name]
        ])

    </div>
</form>
@endsection
