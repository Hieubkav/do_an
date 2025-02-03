@extends('layouts.main')

@section('content')
<form method="POST" action="{{route('momo_process')}}">
    @csrf
    <!-- Thêm các trường dữ liệu cần thiết ở đây -->
    <button type="submit">Thanh toán qua MoMo</button>
</form>
@endsection