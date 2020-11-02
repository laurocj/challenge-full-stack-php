@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('enrollments.update', $enrollment->id) }}" class="card" method="post">
    @method('put')
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('Edit record')}} - {{__('Enrollment')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('enrollments.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>
    <div class="card-body">
        @check([
            'label' => __('Active'),
            'type' => 'checkbox',
            'name' => 'active',
			"value" => $enrollment->active,
			"attributes" => "checked=".$enrollment->active
        ])
        @input([
            'label' => __('Date'),
            'type' => 'input',
            'name' => 'date',
            'attributes' => 'readonly',
			"value" => $enrollment->date
        ])
        @select([
            'label' => __('Team'),
            'name' => 'team_id',
            "value" => $enrollment->team_id,
            'options' => [$enrollment->team_id => $enrollment->team->name],
            'url_search' => route('teams.search')
        ])
        @select([
            'label' => __('Student'),
            'name' => 'student_id',
            "value" => $enrollment->student_id,
            'options' => [$enrollment->student_id => $enrollment->student->name],
            'attributes' => 'readonly'
        ])

    </div>
</form>
@endsection
