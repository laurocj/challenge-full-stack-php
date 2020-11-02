@extends($_keyLayout)

@section($_keyContent)
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span class="h2 my-auto">{{ __('Students')}}</span>
            <a href="{{ route('students.create') }}" class="btn btn-outline-secondary">{{__('New record')}}</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-5 col-xl-3">

                </div>
                <div class="col-12 col-sm">
                    <form class="navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="{{ __('Search') }}"
                                aria-label="{{ __('Search') }}" aria-describedby="button-search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive mt-3 border-top">
                <table class="table table-bordere table-striped table-index">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <th scope="row">{{$student->id}}</th>
                            <td>{{$student->name}}</td>
                            <td>
                                @destroy(['route' => route('students.destroy',$student->id)])
                                <a href="{{route('students.edit',$student->id)}}" class='btn btn-primary btn-sm'><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 col-md-5">

                </div>
                <div class="col-sm-12 col-md-7 d-flex justify-content-center">
                    {!! $students->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
