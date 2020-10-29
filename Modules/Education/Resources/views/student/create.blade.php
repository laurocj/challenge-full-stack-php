@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('students.store') }}" method="post" class="card">
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('New record')}} - {{__('Student')}}</span>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
            <a class="btn btn-danger" href="{{ route('students.index') }}"> {{ __('Back') }}</a>
        </div>
    </div>

    <div class="card-body">
        @input([
            'label' => __('Name'),
            'type' => 'text',
            'placeholder' => 'Informe o nome completo',
            'name' => 'name'
        ])

        @input([
            'label' => __('Email'),
            'type' => 'text',
            'placeholder' => 'Informe apenas um e-mail',
            'name' => 'email'
        ])

        @input([
            'label' => __('RA'),
            'type' => 'text',
            'placeholder' => 'Informe o registro acadêmico',
            'name' => 'academic_record'
        ])

        @input([
            'label' => __('CPF'),
            'type' => 'text',
            'placeholder' => 'Informe o número do documento',
            'name' => 'cpf'
        ])
    </div>
</form>
@endsection
