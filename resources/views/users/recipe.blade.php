@extends('layout.nav')
@section('title', 'RECIPE')
@section('content')
    <div class="container-recipe">
        <form action="search" method="get" role="search">
            <div class="search-box">
                <input type="text" name="keyword" class="search-input" required value="{{ $keyword ?? ''}}">
                <input type="image" src="{{ asset('includes/images/search.png') }}" alt="Submit Button" width="20"
                    class="search-bt">
            </div>
        </form>

        <!-- if search เจอ -->
        @if($newRecipes->isNotEmpty())
            <!-- NEW UPDATE -->
            <h2 class="tap-text">NEW UPDATE</h2>

            <div class="card-container" data-aos="fade-up">
                @foreach ($newRecipes as $recipe)
                    <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                        <div class="card">
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="author">
                                <img src="{{ $recipe->user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg'  }}" alt="author" class="image_author">
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

            <!-- POPULAR -->
            <h2 class="tap-text">POPULAR</h2>

            <div class="card-container" data-aos="fade-up">
                @foreach ($popularRecipes as $recipe)
                    <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                        <div class="card">
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="author">
                                <img src="{{ $recipe->user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}" alt="author" class="image_author">
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

            <!-- POPULAR -->
            <h2 class="tap-text">MOST LIKE</h2>

            <div class="card-container" data-aos="fade-up">
                @foreach ($mostLikedRecipes as $recipe)
                    <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                        <div class="card">
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="author">
                                <img src="{{ $recipe->user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}" alt="author" class="image_author">
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

            <!-- ALL -->

            <h2 class="tap-text-all"  data-aos="fade-up">สูตรอาหารทั้งหมด</h2>

            <div class="card-container" data-aos="fade-up">
                @foreach ($allRecipes as $recipe)
                    <a href="{{ route('recipe.detail', $recipe->recipe_id) }}">
                        <div class="card">
                            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                            <h3 class="recipe-title">{{ $recipe->title }}</h3>
                            <div class="author">
                                <img src="{{ $recipe->user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}" alt="author" class="image_author">
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






        @else
            <div class="not-found-message" style="text-align: center; margin-top: 50px; color: gray;">
                <h2>ไม่พบสูตรอาหารที่ค้นหา: "{{ $keyword }}"</h2>
                <p>ลองค้นหาด้วยคำอื่น หรือดูเมนูแนะนำ</p>
            </div>
        @endif



    </div>


   

@endsection