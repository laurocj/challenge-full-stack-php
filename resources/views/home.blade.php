@extends('layouts.app-internal')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Student consultation') }}</div>

            <div class="card-body">

                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="{{ __('Search') }}"
                                aria-label="{{ __('Search') }}" aria-describedby="button-search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="button-search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <button class="btn btn-outline-secondary">
                            {{ __("Register student") }}
                        </button>
                    </div>
                </div>

                {{ __('You are logged in!') }}
            </div>
        </div>
    </div>
</div>
@endsection
