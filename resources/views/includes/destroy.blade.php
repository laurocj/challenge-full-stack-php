@php
$id = isset($id) ? $id : Str::random(20);
@endphp

<form action="{{ $route }}"
    name="post_{{ $id }}"
    id="post_{{ $id }}"
    method="post"
    style="display:none;">
    @method('DELETE')
    @csrf
</form>
<a href="#" class="btn btn-danger btn-sm"
 onclick="if (confirm(&quot;Deseja mesmo remover esse registro ?&quot;)) { document.post_{{ $id }}.submit(); } event.returnValue = false; return false;">
 <i class="fa fa-trash"></i> {{ __('Delete') }}</a>
