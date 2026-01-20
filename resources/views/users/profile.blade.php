@extends('layout.nav')
@section('title', 'PROFILE')
@section('content')

<div class="profile-container">
    <div class="profile">
        <img src="{{ $user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}"
            style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
        <h1>{{ $user->display_name ?? $user->username }}</h1>
    </div>

    <div class="profile-content">
        <ul class="profile-nav">
            <li class="tab-link active" onclick="openTab(event, 'writing')">งานเขียนของฉัน</li>
            <li class="tab-link" onclick="openTab(event, 'history')">ประวัติการเข้าชม</li>
            <li class="tab-link" onclick="openTab(event, 'notification')">การแจ้งเตือน</li>
            <li class="tab-link" onclick="openTab(event, 'edit-profile')">แก้ไขข้อมูลส่วนตัว</li>
        </ul>
        <hr>
        
        <div class="pro-edit">
            
            <div id="writing" class="tab-content" style="display: block;">
                <div class="my-recipe" data-aos="fade-up">
                    @if(isset($recipe) && count($recipe) > 0)
                        @foreach ($recipe as $recipes)
                        <div class="recipe-item-container">
                            <a href="{{ route('recipe.detail', $recipes->recipe_id) }}" style="text-decoration: none;">
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
                                </div>
                            </a>
                            <div class="bt-form">
                                <form action="{{ route('edit', $recipes->recipe_id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="bt-edit">แก้ไข</button>
                                </form>
                                <form action="{{ route('delete', $recipes->recipe_id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="bt-del">ลบ</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p style="color: white;">ยังไม่มีงานเขียน</p>
                    @endif
                </div>
            </div>

            <div id="history" class="tab-content" style="display: none;">
                <h2 style="color:white;">ประวัติการเข้าชม</h2>
                <p style="color:silver;">รายการที่คุณเคยเปิดดู...</p>
                </div>

            <div id="notification" class="tab-content" style="display: none;">
                <h2 style="color:white;">การแจ้งเตือน</h2>
                <p style="color:silver;">ยังไม่มีการแจ้งเตือนใหม่</p>
            </div>

            <div id="edit-profile" class="tab-content" style="display: none;">
                <div class="edit-profile-wrapper">
                    
                    <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="profile-upload-section">
                            <div class="profile-img-container">
                                <img id="preview-image" src="{{ $user->profile_image_url ?? 'https://png.pngtree.com/png-vector/20191110/ourmid/pngtree-avatar-icon-profile-icon-member-login-vector-isolated-png-image_1978396.jpg' }}" alt="Profile">
                                
                                <label for="profile_image" class="camera-icon">
                                    <i class="fa fa-camera"></i> 📷
                                </label>
                                <input type="file" id="profile_image" name="profile_image" style="display: none;" onchange="previewImage(event)">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>DISPLAY NAME</label>
                                <input type="text" name="display_name" value="{{ $user->display_name }}" placeholder="Enter your display name">
                            </div>

                            <div class="form-group">
                                <label>PASSWORD</label>
                                <input type="password" name="password" placeholder="*****************">
                            </div>

                            <div class="form-group">
                                <label>E-MAIL</label>
                                <input type="email" name="email" value="{{ $user->email }}" placeholder="example@email.com">
                            </div>

                            <div class="form-group full-width">
                                <label>DESCRIPTION</label>
                                <textarea name="bio" rows="4" placeholder="ADD DESCRIPTION">{{ $user->bio }}</textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">SAVE</button>
                            <button type="button" class="btn-cancel" onclick="location.reload()">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS เดิมของคุณ */
    .bt-del { background-color: #fe7762ff; height: 50px; width: 100px; border-radius: 10px; border:none; cursor:pointer;}
    .bt-edit { background-color: #fecd62ff; height: 50px; width: 100px; border-radius: 10px; border:none; cursor:pointer;}
    
    .recipe-item-container {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 20px;
        gap: 10px;
    }

    .bt-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: center;
    }

    .profile-container {
        font-family: "Krub", sans-serif;
        background-color: #7a7a7a50;
        width: 80%;
        min-height: 80vh; /* ปรับให้สูงเต็มจอหน่อย */
        margin: 50px auto;
        padding: 20px 50px;
        border-radius: 10px;
    }

    .profile-nav li {
        list-style: none;
        font-size: 24px; /* ปรับลดขนาดลงหน่อย */
        margin-top: 20px;
        color: silver; /* สีตอนยังไม่เลือก */
        cursor: pointer; /* เมาส์เป็นรูปมือ */
        transition: 0.3s;
    }

    /* สีตอนเอาเมาส์ชี้ หรือตอนเลือกอยู่ */
    .profile-nav li:hover, .profile-nav li.active {
        color: #fecd62ff; 
        font-weight: bold;
    }

    .profile { display: flex; flex-direction: row; align-items: center; gap: 20px; }
    .profile h1 { color: white; }
    .profile-content { display: flex; flex-direction: row; gap: 40px; /* เพิ่มระยะห่างระหว่างเมนูขวาเนื้อหา */ }
    
    hr { margin: 0 20px; border: 1px solid #555; height: auto;} /* ปรับเส้นคั่น */

    .pro-edit { 
        width: 100%; /* ให้เนื้อหากินพื้นที่ที่เหลือ */
    }

    .my-recipe-card {
        background-color: rgba(33, 33, 33, 1);
        width: 600px; /* ปรับขนาดให้พอดี */
        height: 200px;
        border-radius: 10px;
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    .my-recipe-card h1 { color: white; font-size: 20px; }
    .my-recipe-card img { width: 200px; height: 200px; object-fit: cover; border-radius: 10px 0 0 10px; }
    .my-recipe-info { color: whitesmoke; padding: 10px; }
    
    /* Animation พื้นฐาน */
    .tab-content {
        animation: fadeEffect 0.5s;
    }
    @keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }

    /* Container หลักของฟอร์ม */
.edit-profile-wrapper {
    /* background: rgba(0, 0, 0, 0.99); พื้นหลังสีดำจางๆ */
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    /* max-width: 800px; */
    margin-top: 20px;
}

/* --- ส่วนอัพโหลดรูป --- */
.profile-upload-section {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.profile-img-container {
    position: relative;
    width: 120px;
    height: 120px;
}

.profile-img-container img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.camera-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.8);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 18px;
    transition: 0.3s;
}

.camera-icon:hover {
    background: #fff;
    transform: scale(1.1);
}

/* --- จัดวางฟอร์ม --- */
.form-grid {
    display: grid;
    grid-template-columns: 1fr; /* ค่าเริ่มต้น 1 คอลัมน์ */
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    color: #ccc;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 8px;
    letter-spacing: 1px;
}

/* สไตล์ Input ให้เหมือนในรูป (โปร่งแสง) */
.form-group input, 
.form-group textarea {
    background-color: rgba(255, 255, 255, 0.15); /* พื้นหลังโปร่งแสง */
    border: none;
    border-radius: 5px;
    padding: 12px 15px;
    color: white;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: 0.3s;
}

.form-group input:focus, 
.form-group textarea:focus {
    background-color: rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.2);
}

/* ทำให้ Bio กว้างเต็มบรรทัด */
.full-width {
    grid-column: 1 / -1;
}

/* --- ปุ่ม Save / Cancel --- */
.form-actions {
    display: flex;
    justify-content: flex-end; /* ชิดขวา */
    gap: 15px;
    margin-top: 30px;
}

.btn-save {
    background-color: #6aaa64; /* สีเขียว */
    color: white;
    border: none;
    padding: 10px 40px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.btn-save:hover {
    background-color: #588f54;
}

.btn-cancel {
    background-color: #ff7b7b; /* สีแดงอมชมพู */
    color: white;
    border: none;
    padding: 10px 40px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.btn-cancel:hover {
    background-color: #e06060;
}

/* ปรับ placeholder ให้สีจางลง */
::placeholder {
    color: rgba(255, 255, 255, 0.4);
}
</style>

<script>
    function openTab(evt, tabName) {
        // 1. ซ่อนเนื้อหาทั้งหมด (ที่มี class="tab-content")
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // 2. เอาสถานะ active ออกจากปุ่มเมนูทั้งหมด
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // 3. แสดงเนื้อหาของ Tab ที่ถูกเลือก และใส่ class active ให้ปุ่มที่กด
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview-image');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    }   
</script>

@endsection