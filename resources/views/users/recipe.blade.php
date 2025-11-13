@extends('layout.nav')
@section('title', 'RECIPE')
@section('content')
    <div class="container-recipe">
        <form method="post">
            <div class="search-box">
                <input type="text" name="#" class="search-input">
                <input type="image" src="{{ asset('includes/images/search.png') }}" alt="Submit Button" width="20"
                    class="search-bt">
            </div>
        </form>

        <body>
            <h2 class="tap-text">NEW UPDATE</h2>

            <div class="card-container">
                @foreach ($recipes as $recipe)
                    <div class="card">
                        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                        <h3 class="recipe-title">{{ $recipe->title }}</h3>
                        <div class="author">
                            <img src="{{ $recipe->user->profile_image_url }}" alt="author" class="image_author">
                            <p>{{ $recipe->user->display_name }}</p>
                        </div>
                        <div class="like">
                        <img src="{{ asset('includes/images/like.png') }}" alt="like" class="image-like">
                        <p>{{$recipe->likers->count()}}</p>
                        </div>

                        <!-- <p class="recipe-description">{{ $recipe->description }}</p>
                                    <p class="recipe-meal-type">{{ $recipe->meal_type }}</p>
                                    <p class="recipe region">{{ $recipe->region }}</p> -->
                    </div>
                @endforeach
            </div>
        </body>
    </div>
@endsection