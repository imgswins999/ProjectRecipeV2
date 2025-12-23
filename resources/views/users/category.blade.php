@extends('layout.nav')
@section('title', 'CATEGORY')
@section('content')
    <div class="container-category">
        <div class="row"></div>
        <form action="#" method="get" role="search">
            <div class="search-box">
                <input type="text" name="keyword" class="search-input" required value="{{ $keyword ?? ''}}">
                <input type="image" src="{{ asset('includes/images/search.png') }}" alt="Submit Button" width="20"
                    class="search-bt">
            </div>
        </form>
        <!-- ค้นหาหมวดหมู่ประเภทของอาหาร -->
        <div class="search-select">
            <form action="{{ route('categoryfilter') }}" method="get">
                <select name="category_filter" id="category_filter" class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="search-bt-category"> 🔍</button>
            </form>
            <!-- ค้นหาหมวดหมู่ประเทศ -->
            <form action="{{ route('RegionFilter') }}" method="get">
                <select name="region_filter" id="region_filter" class="form-select mb-2">
                    @foreach ($regiones as $regions)
                        <option value="{{ $regions->region_id }}">{{ $regions->region_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="search-bt-category"> 🔍</button>
            </form>
        </div>



        <div class="row-category">
            @foreach ($recipes as $recipe)
                <div class="category-card">
                    <div class="card">
                        <!-- รูป -->
                        <img src="{{ $recipe->image_url }}" class="card-img-top" alt="{{ $recipe->title }}">
                        <!-- ชื่อ -->
                        <h5>{{ $recipe->title }}</h5>
                        <!-- หมวดหมู่ -->
                        <h5>{{ $recipe->category->category_name ?? 'ไม่มีหมวดหมู่' }}</h5>
                        <!-- ประเทศ -->
                        <h5>{{ $recipe->region->region_name ?? 'ไม่มีประเทศ' }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection