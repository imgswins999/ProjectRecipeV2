@extends('layout.nav')
@section('title', 'PROFILE')
@section('content')

    <div class="profile-container">
        <div class="profile">
            <img src="{{ $user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}"
                style="width:100px; border-radius:50%">
            <h1>{{ $user->display_name ?? $user->username }}</h1>
        </div>

        <div class="profile-content">
            <ul class="profile-nav">
                <li class="tab-link active" data-tab="writing">งานเขียนของฉัน</li>
                <li class="tab-link" data-tab="history">ประวัติการเข้าชม</li>
                <li class="tab-link" data-tab="notification">การแจ้งเตือน</li>
                <li class="tab-link" data-tab="edit-profile">แก้ไขข้อมูลส่วนตัว</li>
            </ul>
            <hr>
            <div class="pro-edit">
                <div id='writing' class="tab-content-active">
                    <div class="my-recipe" data-aos="fade-up">
                        @foreach ($recipe as $recipes)
                            <a href="{{ route('recipe.detail', $recipes->recipe_id) }}">
                                <div class="my-recipe-card">
                                    <div class="card-img">
                                        <img src="{{ $recipes->image_url }}" alt="{{$recipes->title}}">
                                    </div>
                                    <div class="my-recipe-info">
                                        <div class="my-title">
                                            <h1>{{$recipes->title}}</h1>
                                        </div>
                                        <div class="my-view">
                                            <p>ยอดเข้าชม : {{ $recipes->view_count }}</p>
                                        </div>
                                        <div class="my-like">
                                            <p>คนถูกใจ : {{$recipes->likers->count()}}</p>
                                        </div>
                                        <div class="date">
                                            <p>{{$recipes->created_at}}</p>
                                        </div>
                                    </div>
                                   <form action="{{ route('edit', $recipes->recipe_id) }}" method="post">
                                         @csrf
                                    <button type="submit" class="bt-delete">กูจะแก้ไขมันเอง
                                       
                                    </button></form>
                                </div>
                            </a>
                        @endforeach
                    </div>

                
                </div>
            </div>
        </div>
    </div>

    <style>
        .bt-delete{
           margin: 0 0 0 auto;
           background-color: #f66d6dff;
           height: 50px;
           width: 100px;
        }
        .profile-container {
            font-family: "Krub", sans-serif;
            font-style: normal;
            font-weight: normal;
            background-color: #7a7a7a50;
            width: 80%;
            height: max-content;
            margin: 50px auto;
            padding: 20px 50px;
            border-radius: 10px;
           
        }
        .profile-nav li {
            list-style: none;
            font-size: 30px;
            margin-top: 20px;
            color: whitesmoke;
        }
        .profile {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;
        }

        /* แยก h1 ออกมา */
        .profile h1 {
            color: white;
        }

        .profile-content {
            display: flex;
            flex-direction: row;
            
        }
        hr{
            margin: 0 50px;
        }
        .pro-edit{
            margin: 0 auto 0 0;
        }
        .pro-edit a {
            text-decoration: none;
        }
        
        .my-recipe{
            display: flex;
            flex-direction: column;
            justify-content: left;
        }
        .my-recipe-card {
            margin-bottom: 20px;
            background-color: rgba(33, 33, 33, 1);
            width: 700px;
            height: 200px;
            border-radius: 10px;
            display: flex;
            flex-direction: row;
            gap: 10px;
        }

        /* แยก h1 ออกมา */
        .my-recipe-card h1 {
            color: white;
            font-size: 20px;
        }

        /* แยก img ออกมา */
        .my-recipe-card img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .my-recipe-info{
            color: whitesmoke;
        }
    </style>
@endsection