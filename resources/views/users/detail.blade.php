@extends('layout.nav')

@section('content')
    <div class="container">
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" width="100%">
<!-- nl2br: ใน Database ของคุณ ข้อมูลในช่อง instructions (เช่น 1. หมักไก่ 2. เจียวหอม...) มันถูกเก็บเป็น Text ยาวๆ ฟังก์ชัน {!! nl2br(e(...)) !!} จะช่วยแปลงการ "กด Enter" ใน Database ให้แสดงเป็นการ "ขึ้นบรรทัดใหม่" บนหน้าเว็บครับ ไม่งั้นมันจะต่อกันเป็นพืด -->
        <h1>{{ $recipe->title }}</h1>

        <p>เขียนโดย: {{ $recipe->user->display_name ?? 'ไม่ระบุ' }}</p>

        <h3>ส่วนผสม</h3>
        <p>{!! nl2br(e($recipe->ingredients)) !!}</p>

        <h3>วิธีทำ</h3>
        <p>{!! nl2br(e($recipe->instructions)) !!}</p>
    </div>
@endsection