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
            <form action="{{ route('category') }}" method="get" class="d-flex gap-2">

                <select name="category_filter" id="category_filter" class="form-select">
                    <option value="">เลือกประเภทอาหารทั้งหมด</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" {{ request('category_filter') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>

                <select name="region_filter" id="region_filter" class="form-select">
                    <option value="">เลือกประเทศทั้งหมด</option>
                    @foreach ($regiones as $regions)
                        <option value="{{ $regions->region_id }}" {{ request('region_filter') == $regions->region_id ? 'selected' : '' }}>
                            {{ $regions->region_name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="search-bt-category"> 🔍</button>
            </form>
        </div>



          <div class="card-container" data-aos="fade-up">
            @foreach ($recipes as $recipe)
               <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                        <div class="card">
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="author">
                                <img src="{{ $recipe->user->profile_image_url }}" alt="author" class="image_author">
                                <p>{{ $recipe->user->display_name }}</p>
                            </div>

                            <div class="view-like-box">
                                <div class="viewer">
                                    <p>ยอดเข้าชม : {{$recipe->view_count}}</p>
                                </div>
                                <div class="like">
                                    <img src="{{ asset('includes/images/rating.png') }}" alt="like" class="image-like">
                                    <p>{{$recipe->likers->count()}}</p>
                                </div>
                            </div>
                        </div>
                    </a>
            @endforeach
        </div>
    </div>
@endsection