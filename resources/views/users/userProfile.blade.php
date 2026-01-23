@extends('layout.nav')
@section('title', $user->display_name)

@section('content')

    <div class="profile-page-bg"
        style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');">

        <div class="profile-overlay-container">

            <div class="profile-header">

                <div class="profile-avatar-wrapper">
                    <img src="{{ $user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}"
                        alt="Profile Image">
                </div>

                <div class="profile-info-section">

                    <div class="profile-name-row">
                        <h1 class="display-name">{{ $user->display_name ?? $user->username }}</h1>

                        @if(Auth::id() !== $user->user_id)
                            <form action="{{ route('follow.toggle', $user->user_id) }}" method="POST">
                                @csrf
                                @if($isFollowing)
                                    <button type="submit" class="btn-follow following">FOLLOWING</button>
                                @else
                                    <button type="submit" class="btn-follow">FOLLOW</button>
                                @endif
                            </form>
                        @endif
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-label">COMPOSITIONS :</span>
                            <span class="stat-value">{{ $recipeCount }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">FOLLOWER :</span>
                            <span class="stat-value">{{ $followerCount }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">LIKE :</span>
                            <span class="stat-value">{{ $totalLikes }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="profile-tabs">
                <div class="tab-item active">COMPOSITIONS</div>
            </div>

            <div class="profile-content-body">
                @if($recipes->count() > 0)
                    <div class="recipe-grid">
                        @foreach($recipes as $recipe)
                            <a href="{{ route('recipe.detail', $recipe->recipe_id) }}" class="recipe-card-link">
                                <div class="recipe-card">
                                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                                    <div class="recipe-card-info">
                                        <h3>{{ $recipe->title }}</h3>
                                        <div class="card-stats">
                                            <span>👁 {{ $recipe->view_count }}</span>
                                            <span>❤️ {{ $recipe->likes_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="no-content">ยังไม่มีผลงานเขียน</p>
                @endif
            </div>

        </div>
    </div>

    <style>
        /* 1. Background Setup */
        .profile-page-bg {
            position: relative;
            width: 100%;
            min-height: 100vh;
            /* เต็มจอแนวตั้ง */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* ภาพนิ่งเวลาเลื่อน */
        }

        /* 2. Main Overlay (Glass Effect) */
        .profile-overlay-container {
            background: rgba(0, 0, 0, 0.75);
            /* สีดำโปร่งแสง 75% */
            backdrop-filter: blur(5px);
            /* เบลอฉากหลังเล็กน้อย */
            min-height: 100vh;
            width: 100%;
            padding: 100px 10% 50px 10%;
            /* เว้นขอบซ้ายขวา 10% */
            box-sizing: border-box;
            color: white;
            font-family: 'Krub', sans-serif;
        }

        /* 3. Header Layout */
        .profile-header {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 30px;
            margin-bottom: 50px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            /* เส้นคั่นบางๆ */
        }

        /* Avatar */
        .profile-avatar-wrapper {
            width: 150px;
            height: 150px;
            flex-shrink: 0;
        }

        .profile-avatar-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        /* Info Section */
        .profile-info-section {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-name-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .display-name {
            font-size: 32px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        /* ปุ่ม Follow (สีฟ้าตามรูป) */
        .btn-follow {
            background-color: #3b8ac4;
            /* สีฟ้า */
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 20px;
            /* ขอบมนเป็นแคปซูล */
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(59, 138, 196, 0.4);
        }

        .btn-follow:hover {
            background-color: #2a6da0;
        }

        .btn-follow.following {
            background-color: #555;
            /* ถ้าติดตามแล้วให้ปุ่มเป็นสีเทา */
            box-shadow: none;
        }

        /* Stats Row */
        .profile-stats {
            display: flex;
            gap: 40px;
        }

        .stat-item {
            font-size: 14px;
            color: #ccc;
        }

        .stat-label {
            font-weight: 300;
            margin-right: 5px;
        }

        .stat-value {
            font-weight: bold;
            color: white;
            font-size: 16px;
        }

        /* 4. Tabs */
        .profile-tabs {
            margin-bottom: 30px;
        }

        .tab-item {
            display: inline-block;
            font-size: 16px;
            font-weight: 500;
            color: white;
            padding-bottom: 10px;
            border-bottom: 2px solid white;
            /* ขีดเส้นใต้ Active */
            cursor: pointer;
        }

        /* 5. Recipe Grid (Content) */
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            /* Grid อัตโนมัติ */
            gap: 20px;
        }

        .recipe-card-link {
            text-decoration: none;
            color: white;
        }

        .recipe-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: 0.3s;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
        }

        .recipe-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .recipe-card-info {
            padding: 10px;
        }

        .recipe-card-info h3 {
            font-size: 16px;
            margin: 0 0 10px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-stats {
            display: flex;
            gap: 10px;
            font-size: 12px;
            color: #bbb;
        }

        .no-content {
            color: #888;
            font-style: italic;
        }
    </style>
@endsection