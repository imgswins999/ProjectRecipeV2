@extends('layout.nav')
@section('title', 'POPULAR')
@section('content')
    <div class="container-popular">
      
        <h1 style="color:white;text-align: center;margin-top:50px">POPUALR</h1>
        <div class="filter-buttons mb-4">
            {{-- ปุ่มยอดนิยมวันนี้ --}}
            <a href="{{ route('popular', ['filter' => 'day']) }}"
                class="btn {{ ($currentFilter ?? '') == 'day' ? 'active' : '' }}">
                ยอดนิยมวันนี้
            </a>

            {{-- ปุ่มยอดนิยมเดือนนี้ --}}
            <a href="{{ route('popular', ['filter' => 'month']) }}"
                class="btn {{ ($currentFilter ?? '') == 'month' ? 'active' : '' }}">
                ยอดนิยมเดือนนี้
            </a>

            {{-- ปุ่มยอดนิยมปีนี้ --}}
            <a href="{{ route('popular', ['filter' => 'year']) }}"
                class="btn {{ ($currentFilter ?? '') == 'year' ? 'active' : '' }}">
                ยอดนิยมปีนี้
            </a>

            {{-- ปุ่มยอดนิยมตลอดกาล --}}
            <a href="{{ route('popular', ['filter' => 'all-time']) }}"
                class="btn {{ ($currentFilter ?? '') == 'all-time' ? 'active' : '' }}">
                ยอดนิยมตลอดกาล
            </a>
        </div>

        <div class="row-popular">
            @foreach ($popularRecipes as $recipe )
                <div class="popular-card">
                    <div class="card">
                        {{-- ลิงก์ไปยังหน้ารายละเอียดเพื่อกระตุ้นการนับวิว --}}
                        <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                            <img src="{{ $recipe->image_url }}" class="card-img-top" alt="{{ $recipe->title }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->title }}</h5>

                            @php
                                // ดึงยอดวิวที่เกี่ยวข้องกับ filter ปัจจุบัน
                                $views = ($currentFilter === 'all-time')
                                    ? $recipe->view_count
                                    : ($recipe->views_count ?? 0); 
                            @endphp

                            <p class="card-text">
                                ยอดวิว {{ number_format($views) }} ครั้ง
                            </p>
                            <p class="text-muted small">โดย {{ $recipe->user->username ?? 'ผู้ใช้ไม่ทราบชื่อ' }}</p>

                        </div>
                    </div>
                </div>
           @endforeach
        </div>


@endsection