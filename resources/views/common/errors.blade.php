@if (count($errors) > 0)
{{-- フォームエラーリスト --}}
<div class="alert alert-danger">
    <storong>エラーが起こってます。</storong>

    <br><br>

    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

