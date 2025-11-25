@extends('layout.nav')
@section('title', $recipe->title)
@section('content')
    <div class="detail-container">
        <div class="head-detail-container">
            <div class="head-image-detail">
                <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="head-image">
            </div>
            <div class="detail-all-description">
                <div class="frist-description">
                    <h1>{{$recipe->title}}</h1>
                    <p>Meal Type : {{$recipe->meal_type}}</p>
                    <p>Region / Culture : {{$recipe->region}}</p>
                </div>
                <div class="second-description">
                    <p>{{$recipe->description}}</p>
                </div>
                <div class="third-description">
                    <div class="author">
                        <img src="{{ $recipe->user->profile_image_url }}" alt="author" class="image_author">
                        <p>{{ $recipe->user->display_name }}</p>
                    </div>
                    <div class="view-like-box">
                        <div class="viewer">
                            <p>ยอดเข้าชม : {{$recipe->view_count}}</p>
                        </div>
                        <div class="like">
                            <img src="{{ asset('includes/images/like.png') }}" alt="like" class="image-like">
                            <p>{{$recipe->likers->count()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-container">
            <div class="tab-headers">
                <span class="tab-link active" data-tab="ingredients">Ingredients</span>
                <span class="tab-link" data-tab="procedure">Procedure</span>
                <span class="tab-link" data-tab="comments">Comments</span>
            </div>

            <div class="tab-content-container">
                <div id="ingredients" class="tab-content active">
                    <div class="ingredients-list">
                        {{-- หัวข้อตาราง --}}
                        <div class="ingredients-header">
                            <span class="name-col">INGREDIENTS</span>
                            <span class="ratio-col">RATIO</span>
                        </div>

                        {{-- วนลูปดึงข้อมูลจากความสัมพันธ์ ingredients() --}}
                        @foreach ($recipe->ingredientsList as $index => $ing)
                            <div class="ingredient-item">
                                {{-- ชื่อวัตถุดิบ (ซ้าย) --}}
                                <div class="ingredient-name">
                                    <span class="name-col">
                                        {{ $index + 1 }}. {{ $ing->ingredient_name }}
                                    </span>
                                </div>


                                {{-- ปริมาณและหน่วย (ขวา) --}}
                                <div class="ratio">
                                    <span class="ratio-col">
                                        @if($ing->amount)
                                            {{ rtrim(rtrim($ing->amount, '0'), '.') }}
                                        @endif
                                        {{ $ing->unit }}
                                    </span>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="procedure" class="tab-content">
                    {{$recipe->instructions}}
                </div>
                <div id="comments" class="tab-content">
                    ความคิดเห็น...
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', function () {
                    // 1. ลบคลาส active ออกจากแท็บ header และเนื้อหาเดิม
                    document.querySelector('.tab-link.active').classList.remove('active');
                    document.querySelector('.tab-content.active').classList.remove('active');

                    // 2. หา ID ของเนื้อหาที่ต้องเปิด
                    const targetTab = this.getAttribute('data-tab');

                    // 3. เพิ่มคลาส active ให้กับแท็บ header ที่ถูกคลิก
                    this.classList.add('active');

                    // 4. เพิ่มคลาส active ให้กับเนื้อหาเป้าหมาย
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });
    </script>

@endsection