@extends($_keyLayout)

@section($_keyContent)
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span class="h2 my-auto">{{ __('Course')}}</span>
            <a href="{{ route('courses.create') }}" class="btn btn-outline-secondary">{{__('New record')}}</a>
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
                        @foreach($courses as $course)
                        <tr>
                            <th scope="row">{{$course->id}}</th>
                            <td>{{$course->name}}</td>
                            <td>
                                @destroy(['route' => route('courses.destroy',$course->id)])
                                <a href="{{route('courses.edit',$course->id)}}" class='btn btn-primary btn-sm'><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                                <a href="{{route('teams.index',['course_id' => $course->id])}}" class='btn btn-success btn-sm'><i class="fas fa-users"></i> {{ __('Turmas') }}</a>
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
                    {!! $courses->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
