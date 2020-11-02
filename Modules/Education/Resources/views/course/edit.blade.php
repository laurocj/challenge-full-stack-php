@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('courses.update', $course->id) }}" class="card" method="post">
    @method('put')
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('Edit record')}} - {{__('Course')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('courses.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>
    <div class="card-body">
        @input([
            'label' => __('Name'),
            'type' => 'text',
            'name' => 'name',
			"value" => $course->name
        ])
        @input([
            'label' => __('Description'),
            'type' => 'textarea',
            'name' => 'description',
			"value" => $course->description
        ])

    </div>
</form>
@endsection
