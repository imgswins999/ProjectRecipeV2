@extends('layout.nav')

@section('content')
    <div class="container">
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" width="100%">

        <h1>{{ $recipe->title }}</h1>

        <p>เขียนโดย: {{ $recipe->user->display_name ?? 'ไม่ระบุ' }}</p>

        <h3>ส่วนผสม</h3>
        <p>{!! nl2br(e($recipe->ingredients)) !!}</p>

        <h3>วิธีทำ</h3>
        <p>{!! nl2br(e($recipe->instructions)) !!}</p>
    </div>
@endsection