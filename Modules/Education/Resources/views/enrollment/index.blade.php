@extends($_keyLayout)

@section($_keyContent)
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span class="h2 my-auto">{{ __('Enrollment')}}</span>
            <a href="{{ route('enrollments.create') }}" class="btn btn-outline-secondary">{{__('New record')}}</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-5 col-xl-3">

                </div>
                <div class="col-12 col-sm">
                    <form class="navbar-search">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="{{ __('Search') }}"
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
                            <th scope="col">{{ __('Student') }}</th>
                            <th scope="col">{{ __('Team') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr>
                            <th scope="row">{{$enrollment->id}}</th>
                            <td>{{$enrollment->student->name}}</td>
                            <td>{{$enrollment->team->name}}</td>
                            <td>
                                @destroy(['route' => route('enrollments.destroy',$enrollment->id)])
                                <a href="{{route('enrollments.edit',$enrollment->id)}}" class='btn btn-primary btn-sm'><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
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
                    {!! $enrollments->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
