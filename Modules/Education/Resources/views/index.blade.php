@extends($_keyLayout)

@section($_keyContent)
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('education.name') !!}
    </p>
@endsection
