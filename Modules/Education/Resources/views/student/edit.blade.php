@extends($_keyLayout)

@section($_keyContent)
<form action="{{ route('students.update', $student->id) }}" class="card" method="post">
    @method('put')
    @csrf
    <div class="card-header d-flex justify-content-between">
        <span class="h2 my-auto">{{__('Edit record')}} - {{__('Student')}}</span>
        <div class="col-md-auto">
            <a class="btn btn-danger" href="{{ route('students.index') }}"> {{ __('Back') }}</a>
            <button type="submit" class="btn btn-success">{{ __("Save") }}</button>
        </div>
    </div>
    <div class="card-body">
            @input([
                'label' => __('Name'),
                'type' => 'text',
                'placeholder' => 'Informe o nome completo',
                'name' => 'name',
                'value' => $student->name
            ])

            @input([
                'label' => __('Email'),
                'type' => 'text',
                'placeholder' => 'Informe apenas um e-mail',
                'name' => 'email',
                'value' => $student->email
            ])

            @input([
                'label' => __('RA'),
                'type' => 'text',
                'placeholder' => 'Informe o registro acadêmico',
                'name' => 'academic_record',
                'value' => $student->academic_record
            ])

            @input([
                'label' => __('CPF'),
                'type' => 'text',
                'placeholder' => 'Informe o número do documento',
                'name' => 'cpf',
                'value' => $student->cpf
            ])
    </div>
</form>
@endsection
