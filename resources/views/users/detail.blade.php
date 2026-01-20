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
                    <p>Meal Type : {{$recipe->category->category_name}}</p>
                    <p>Region / Culture : {{$recipe->region->region_name}}</p>
                </div>
                <div class="second-description">
                    <p>{{$recipe->description}}</p>
                </div>
                <div class="third-description">
                   <div class="author">
                        <a href="{{ route('user.profile', $recipe->user->user_id) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                            
                            <img src="{{ $recipe->user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}" 
                                alt="author" 
                                class="image_author">
                                
                            <p>{{ $recipe->user->display_name ?? $recipe->user->username }}</p>
                        
                        </a>
                    </div>
                    <div class="view-like-box">
                        <div class="viewer">
                            <p>ยอดเข้าชม : {{$recipe->view_count}}</p>
                        </div>
                        <form action="{{ route('like', $recipe->recipe_id) }}" method="POST">
                            @csrf
                            <div class="like">
                                <button type="submit" class="like-button">
                                    @if (auth()->check() && $recipe->isLikedBy(auth()->user()))
                                        <img src="{{ asset('includes/images/like.png') }}" alt="like" class="image-like">
                                    @else
                                        <img src="{{ asset('includes/images/unlike.png') }}" alt="unlike" class="image-like">
                                    @endif
                                </button>
                                <span class="count-like">{{ $recipe->likes->count() }}</span>
                            </div>
                        </form>
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
                <!--ingredients  -->
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

                <!-- procedure -->
                <div id="procedure" class="tab-content" style="white-space: pre-line;">
                    <p class="text-procedure">{{$recipe->instructions}}</p>
                </div>

                <!-- comments -->
                <div id="comments" class="tab-content">
                    <div class="comment-layout-container">

                        {{-- ================= ฝั่งซ้าย: แสดงรายการคอมเมนต์ ================= --}}
                        <div class="left-comment-list">
                            <h3 class="comment-header-text">COMMENTS</h3>

                            <div class="comment-scroll-area">
                                @if($recipe->comments->count() > 0)
                                    {{-- วนลูปเฉพาะคอมเมนต์หลัก (ที่ไม่มี parent_id) --}}
                                    @foreach($recipe->comments->whereNull('parent_id') as $comment)
                                        <div class="comment-wrapper">

                                            {{-- 1. ตัวคอมเมนต์หลัก --}}
                                            <div class="comment-item">
                                                {{-- Avatar --}}
                                                <div class="comment-avatar">
                                                    @if($comment->user->profile_image_url)
                                                        <img src="{{ $comment->user->profile_image_url }}" alt="user"
                                                            class="avatar-img">
                                                    @else
                                                        <div class="default-avatar-icon">
                                                            <svg viewBox="0 0 24 24" fill="white" width="30" height="30">
                                                                <path
                                                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="comment-content">
                                                    <span class="comment-username">{{ $comment->user->display_name }}</span>
                                                    <div class="comment-bubble">
                                                        <p>"{{ $comment->comment_text }}"</p>
                                                    </div>

                                                    {{-- ปุ่มกดตอบกลับ --}}
                                                    @auth
                                                        <button class="btn-reply-toggle"
                                                            onclick="toggleReply('{{ $comment->comment_id }}')">
                                                            ตอบกลับ
                                                        </button>
                                                    @endauth
                                                </div>
                                            </div>

                                            {{-- 2. พื้นที่แสดงคอมเมนต์ลูก (Reply) --}}
                                            @if($comment->replies && $comment->replies->count() > 0)
                                                <div class="replies-container">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="comment-item reply-item">
                                                            <div class="comment-avatar sm">
                                                                @if($reply->user->profile_image_url)
                                                                    <img src="{{ $reply->user->profile_image_url }}" class="avatar-img sm">
                                                                @else
                                                                    <div class="default-avatar-icon sm"><svg viewBox="0 0 24 24" fill="white"
                                                                            width="20" height="20">
                                                                            <path
                                                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                                        </svg></div>
                                                                @endif
                                                            </div>
                                                            <div class="comment-content">
                                                                <span class="comment-username sm">{{ $reply->user->display_name }}</span>
                                                                <div class="comment-bubble reply-bubble">
                                                                    <p>{{ $reply->comment_text }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- 3. ฟอร์มตอบกลับ (ซ่อนอยู่) --}}
                                            <div id="reply-form-{{ $comment->comment_id }}" class="reply-form-box"
                                                style="display: none;">
                                                <form action="{{ route('comment.store', $recipe->recipe_id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->comment_id }}">
                                                    <textarea name="comment_text" class="reply-input"
                                                        placeholder="ตอบกลับคุณ {{ $comment->user->display_name }}..."></textarea>
                                                    <div style="text-align: right; margin-top: 5px;">
                                                        <button type="submit" class="btn-send-reply">ส่ง</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <p style="color: #aaa;">ยังไม่มีความคิดเห็น</p>
                                @endif
                            </div>
                        </div>

                        {{-- ================= ฝั่งขวา: ฟอร์มเพิ่มคอมเมนต์หลัก ================= --}}
                        <div class="right-comment-form">
                            <h3 class="comment-header-text">ADD COMMENT</h3>
                            @auth
                                <form action="{{ route('comment.store', $recipe->recipe_id) }}" method="POST" class="post-form">
                                    @csrf
                                    {{-- ไม่ต้องส่ง parent_id เพราะเป็นคอมเมนต์หลัก --}}
                                    <textarea name="comment_text" class="comment-input-area"
                                        placeholder="แสดงความคิดเห็น..."></textarea>
                                    <button type="submit" class="btn-post-comment">POST</button>
                                </form>
                            @else
                                <div class="guest-notice">
                                    <p>กรุณา <a href="{{ route('signIn') }}" style="color: #dea01e;">เข้าสู่ระบบ</a>
                                        เพื่อคอมเมนต์</p>
                                </div>
                            @endauth
                        </div>
                    </div>
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

        function toggleReply(id) {
            let form = document.getElementById('reply-form-' + id);
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

@endsection