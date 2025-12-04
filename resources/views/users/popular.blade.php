@extends('layout.nav')
@section('title','POPULAR')
@section('content')
    <div class="container-recipe">
        <form action="search.popular" method="get" role="search">
            <div class="search-box">
            <input type="text" name="keyword" class="search-input" required value="{{ $keyword ?? ''}}">
            <input type="image" src="{{ asset('includes/images/search.png') }}" alt="Submit Button" width="20"
                class="search-bt">
            </div>
        </form>

        <div class="filter-buttons mb-4">
       <!-- routeไปcontrollerไปฟังค์ชั้น -->
        <a href="{{ route('popular', ['filter' => 'day']) }}" 
           class="btn  ">
           ยอดนิยมวันนี้
        </a>

        <a href="{{ route('popular', ['filter' => 'month']) }}"
           class="btn ">
           ยอดนิยมเดือนนี้
        </a>

        <a href="{{ route('popular', ['filter' => 'year']) }}"
           class="btn">
           ยอดนิยมปีนี้
        </a>

        <a href="{{ route('popular', ['filter' => 'all-time']) }}"
           class="btn  ">
           ยอดนิยมตลอดกาล
        </a>
        </div>

        <div class="row">
            @forelse ($popularRecipes as $recipe)
                <div class="col-md-4 mb-4">
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
                                ยอดวิว **{{ number_format($views) }}** ครั้ง 
                                </p>
                            <p class="text-muted small">โดย {{ $recipe->user->username ?? 'ผู้ใช้ไม่ทราบชื่อ' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>ไม่พบสูตรอาหารยอดนิยมในช่วงเวลานี้</p>
            @endforelse
        </div>
        
       
@endsection 
