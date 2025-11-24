@extends('layout.nav')

@section('content')
    <div class="container">
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" width="50%">
        <p>เขียนโดย: {{ $recipe->user->display_name ?? 'ไม่ระบุ' }}</p>

        <h3>ส่วนผสม</h3>
        <p>{{ $recipe->ingredients}}</p>

        <h3>วิธีทำ</h3>
        <p>{{ $recipe->instructions}}</p>
    </div>
@endsection