@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('courses.store') }}" method="post" class="card">
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('New record')}} - {{__('Course')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('courses.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>

    <div class="card-body">
        @input([
            'label' => __('Name'),
            'type' => 'text',
            'name' => 'name'
        ])
        @input([
            'label' => __('Description'),
            'type' => 'textarea',
            'name' => 'description'
        ])

    </div>
</form>
@endsection
