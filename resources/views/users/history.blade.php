@extends('layout.nav')
@section('title', 'PROFILE')

@section('content')
    <div class="history-page-wrapper">
        <div class="history-container">
            <header class="history-header">
                <div class="header-content">
                    <span class="gold-subtitle">Your Culinary Journey</span>
                    <h3>VIEWING HISTORY</h3>
                    <div class="header-line"></div>
                    <p>สูตรอาหารที่คุณเคยเข้าชม คัดสรรมาเพื่อแรงบันดาลใจครั้งใหม่ของคุณ</p>
                </div>
            </header>

            @if($histories->isEmpty())
                <div class="no-history-card">
                    <div class="icon-box">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <p>ยังไม่มีประวัติการเข้าชมในตอนนี้</p>
                    <a href="{{ route('recipe') }}" class="btn-gold-outline">สำรวจเมนูอาหาร</a>
                </div>
            @else
                <div class="history-grid">
                    @foreach($histories as $history)
                        <div class="history-card">
                            <div class="card-media">
                                <img src="{{ $history->recipe->image_url }}" alt="{{ $history->recipe->title }}">
                                <div class="card-overlay">
                                    <span class="time-badge">
                                        <i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($history->viewed_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <span class="category-tag">{{ $history->recipe->category->category_name ?? 'เมนูแนะนำ' }}</span>
                                <h4>{{ $history->recipe->title }}</h4>

                                <div class="chef-info">
                                    <div class="avatar-circle">
                                        <img src="{{ $history->recipe->user->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($history->recipe->user->username) . '&background=D4AF37&color=fff' }}"
                                            alt="Chef">
                                    </div>
                                    <span>โดย {{ $history->recipe->user->display_name ?? $history->recipe->user->username }}</span>
                                </div>

                                <div class="card-action">
                                    <a href="{{ route('recipe.detail', $history->recipe_id) }}" class="btn-revisit">
                                        <span>ดูสูตรอาหารอีกครั้ง</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <style>
        /* นำเข้าฟอนต์ที่ดูทันสมัย */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Poppins:wght@500;700&display=swap');

        :root {
            --gold: #D4AF37;
            --gold-light: #f1d592;
            --dark-bg: #0f0f0f;
            --card-bg: #1a1a1a;
            --text-muted: #a0a0a0;
        }

        .history-page-wrapper {
            /* background: var(--dark-bg);
            background-image: radial-gradient(circle at 50% -20%, #252525 0%, var(--dark-bg) 80%); */
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .history-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        /* Header Styling */
        .history-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .gold-subtitle {
            color: var(--gold);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 4px;
            font-weight: 600;
            display: block;
            margin-bottom: 10px;
        }

        .history-header h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 42px;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }

        .header-line {
            width: 60px;
            height: 3px;
            background: var(--gold);
            margin: 20px auto;
        }

        .history-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        /* Grid & Cards */
        .history-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .history-card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .history-card:hover {
            transform: translateY(-10px);
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        .card-media {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .history-card:hover .card-media img {
            transform: scale(1.1);
        }

        .card-overlay {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .time-badge {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            color: #fff;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 11px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Card Content */
        .card-body {
            padding: 25px;
        }

        .category-tag {
            color: var(--gold);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .card-body h4 {
            color: #fff;
            font-size: 20px;
            margin: 10px 0 20px 0;
            line-height: 1.4;
        }

        .chef-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--gold);
        }

        .chef-info span {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Button Styling */
        .btn-revisit {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 12px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            transition: color 0.3s;
        }

        .btn-revisit:hover {
            color: var(--gold);
        }

        .btn-revisit i {
            transition: transform 0.3s ease;
        }

        .btn-revisit:hover i {
            transform: translateX(5px);
        }
    </style>
@endsection