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

        <form method="post">
            <div class="recipe-show">
                <p>NEW UPDATE</p>
                <!-- ใช้ for loop นะ -->
                <div class="recipe-card">
                    <div class="recipe image">
                        <!-- สมมติไปก่อนนะ แก้ด้วย -->
                        <img src="{{ asset(uri('https://s359.kapook.com/pagebuilder/158f4b61-fb25-4b81-bb61-3c3346acb0b4.jpg')) }}"
                            alt="" class="recipe-image">
                    </div>

                    <div class="recipe-title">
                        <!-- สมมติไปก่อนนะ แก้ด้วย -->
                        <h2>ข้าวหมูแดงเจ๊เก็ต</h2>
                    </div>

                    <div class="recipe-author">
                        <!-- สมมติไปก่อนนะ แก้ด้วย -->
                        <h4>GET HANDSOME SUD COOL</h4>
                    </div>

                    <div class="recipe-VieweAndLike">
                        <div class="recipe-view">
                            <p>VIEWER:
                            <p> <!-- สมมติไปก่อนนะ แก้ด้วย --></p>
                            </p>
                        </div>
                        <div class="recipe-like">
                            <p>LIKE:
                            <p> <!-- สมมติไปก่อนนะ แก้ด้วย --></p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection