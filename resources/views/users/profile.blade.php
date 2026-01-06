@extends('layout.nav')
@section('title', content: 'PROFILE')
@section('content')

    <div class="profile-container">
        <div class="profile">
            <img src="{{ $user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}"
                style="width:100px;border-radius:50%">
            <h1>{{$user->display_name ?? $user->username }}</h1>
        </div>
    </div>

    <style>
        .profile-container {
            background-color: #7a7a7a50;
            width: 80%;
            height: max-content;
            margin: 50px auto;
            padding: 20px 50px;
            border-radius: 10px;

        }

        .profile {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 20px;

            h1{
                color: white;
            }
        }
    </style>
@endsection