@if (session('alert_type'))
<div class="col-12">
    @switch(session('alert_type'))
        @case('error')
            <div class="alert alert-danger lert-dismissible fade show" role="alert">
                {{ session('alert_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
        @case('success')
            <div class="alert alert-success lert-dismissible fade show" role="alert">
                {{ session('alert_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
        @case('warning')
            <div class="alert alert-warning lert-dismissible fade show" role="alert">
                {{ session('alert_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @break
    @endswitch
</div>
@endif
