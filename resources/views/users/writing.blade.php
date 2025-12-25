@extends('layout.nav')
@section('title', content: 'WRITING')
@section('content')
    <div class="insert-container">
        <h1 style="color:white">เพิ่มสูตรอาหาร</h1>
        <div class="first-insert">
            <div class="upload-container">
                <input type="file" id="file-upload" accept="image/*" hidden />
                <label for="file-upload" class="custom-upload" id="drop-area">
                    <div id="upload-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                    </div>
                    <img id="image-preview" src="" alt="Preview" style="display: none;" />
                </label>
            </div>

            <div class="name-type-region-des-container">

                <!-- กล่องใส่ชื่อ -->
                <div class="name-container">
                    <input type="text" placeholder="ชื่อสูตรอาหาร" class="writing-name-input">
                </div>

                <!-- กล่องใส่ ประเภท ประเทศ คำอธิบาย -->
                <div class="type-region-container">
                    <!-- ปรเภท -->
                    <div class="type-container">
                        <select name="category_id" id="category_id" class="type-input">
                            <option value="" disabled selected>เลือกประเภทของอาหาร</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- ประเทษ -->
                    <div class="region-container">
                        <select name="region_id" id="region_id" class="type-input">
                            <option value="" disabled selected>ประเทศ</option>
                            @foreach($regions as $reg)
                                <option value="{{ $reg->region_id }}">{{ $reg->region_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- คำอธืบาย -->
                <div class="des-container">
                    <textarea class="des-input" placeholder="คำอธิบาย"></textarea>
                </div>
            </div>
        </div>

        <h1 style="margin-bottom:0px;color:white;margin-left:30px">วัตถุดิบและอัตราส่วน</h1>

        <div class="second-container">
            <div class="ingredient-container">
                <input type="text" id="ing-input" placeholder="วัตถุดิบ" class="ingredient-input">
            </div>
            <div class="ratio-container">
                <input type="number" step="0.01" id="amount-input" placeholder="จำนวน" class="ratio-input">
            </div>
            <div class="unit-container">
                <input type="text" id="unit-input" placeholder="หน่วย (เช่น กรัม)" class="ratio-input">
            </div>
            <button type="button" id="add-btn" class="glow-button">
                <span class="plus-icon">+</span>
            </button>
        </div>

        <h1 style="margin-bottom:10px;color:white;margin-left:30px">รายการ</h1>

        <div id="list-container" class="list-box">
            <p id="empty-msg" style="color: #888;">ยังไม่มีรายการวัตถุดิบ</p>
        </div>

        <h1 style="margin-bottom:10px;color:white;margin-left:30px">ขั้นตอนการทำ</h1>
        <div class="procedure-container">
            <textarea class="procedure-input" placeholder="ใส่ขั้นตอนการทำ..."></textarea>
        </div>

        <div class="action-buttons">
            <button type="button" class="btn cancel">CANCEL</button>
            <button type="button" class="btn post" >POST</button>
        </div>
    </div>


    <style>
        .action-buttons {
            display: flex;
            justify-content: flex-end;

            gap: 20px;
            margin: 20px 30px;
        }

        .btn {
            border: none;
            padding: 12px 40px;

            border-radius: 30px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 150px;
        }

        .btn.cancel {
            background-color: #ff7f7f;
        }

        .btn.cancel:hover {
            background-color: #ff6666;
        }

        .btn.post {
            background-color: #66bb6a;
        }

        .btn.post:hover {
            background-color: #57a05b;
        }
    </style>

    <script>
        // ส่วนจัดการรูปภาพ
        const fileInput = document.getElementById('file-upload');
        const imagePreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // ส่วนจัดการเพิ่มวัตถุดิบลงรายการ
        const ingInput = document.getElementById('ing-input');
        const amountInput = document.getElementById('amount-input');
        const unitInput = document.getElementById('unit-input');
        const addBtn = document.getElementById('add-btn');
        const listContainer = document.getElementById('list-container');
        const emptyMsg = document.getElementById('empty-msg');

        addBtn.addEventListener('click', function () {
            const ingredient = ingInput.value.trim();
            const amount = amountInput.value.trim();
            const unit = unitInput.value.trim();

            if (!ingredient || !amount || !unit) {
                alert("กรุณากรอกให้ครบทั้ง วัตถุดิบ, จำนวน และหน่วย");
                return;
            }

            if (emptyMsg) {
                emptyMsg.style.display = 'none';
            }

            const newItem = document.createElement('div');
            newItem.classList.add('list-item');
            // ตกแต่ง list-item ให้ดูเป็นระเบียบ (สไตล์ชั่วคราวเพื่อให้ปุ่มลบอยู่ขวาสุด)
            newItem.style = "display:flex; justify-content:space-between; align-items:center; background:#f4f4f4; padding:10px; border-radius:8px; margin-bottom:10px; color:#333;";

            newItem.setAttribute('data-name', ingredient);
            newItem.setAttribute('data-amount', amount);
            newItem.setAttribute('data-unit', unit);

            newItem.innerHTML = `
                                <span><strong>${ingredient}</strong> : ${amount} ${unit}</span>
                                <button type="button" class="delete-btn" style="background:#ff4d4d; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;" onclick="this.parentElement.remove(); if(document.querySelectorAll('.list-item').length === 0) document.getElementById('empty-msg').style.display='block';">ลบ</button>
                            `;

            listContainer.appendChild(newItem);

            // ล้างค่าในช่องกรอก
            ingInput.value = '';
            amountInput.value = '';
            unitInput.value = '';
            ingInput.focus();
        });

        // ส่วนปุ่ม POST สำหรับส่งข้อมูลเข้าฐานข้อมูล
        document.querySelector('.btn.post').addEventListener('click', function () {
            // 1. ตรวจสอบว่ากรอกหัวข้อสูตรอาหารหรือยัง
            const title = document.querySelector('.writing-name-input').value.trim();
            if (!title) {
                alert("กรุณาใส่ชื่อสูตรอาหาร");
                return;
            }

            // 2. รวบรวมข้อมูลวัตถุดิบจาก list-item ทั้งหมด
            const ingredientData = [];
            const items = document.querySelectorAll('.list-item');

            if (items.length === 0) {
                alert("กรุณาเพิ่มวัตถุดิบอย่างน้อย 1 รายการ");
                return;
            }

            items.forEach(item => {
                ingredientData.push({
                    name: item.getAttribute('data-name'),
                    amount: item.getAttribute('data-amount'),
                    unit: item.getAttribute('data-unit')
                });
            });

            // 3. เตรียมส่งข้อมูลแบบ FormData (รองรับไฟล์รูปภาพ)
            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', document.querySelector('.des-input').value);
            formData.append('instructions', document.querySelector('.procedure-input').value);
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('region_id', document.getElementById('region_id').value);

            // ส่งวัตถุดิบเป็น JSON String เพื่อไปถอดรหัสใน Controller
            formData.append('ingredients_json', JSON.stringify(ingredientData));

            if (fileInput.files[0]) {
                formData.append('image', fileInput.files[0]);
            }

            // 4. ส่งไปที่ Backend
            // หมายเหตุ: ต้องตรวจสอบใน routes/web.php ว่ามี ->name('recipes.store') หรือยัง
            fetch("{{ route('recipes.store') }}", {
                method: "POST",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
                .then(async response => {
                    const resData = await response.json();
                    if (response.ok && resData.success) {
                        alert("บันทึกสูตรอาหารเรียบร้อย!");
                        window.location.href = "/recipe "; // เปลี่ยนเป็น Path ของหน้ารวมสูตรอาหารของคุณ
                    } else {
                        alert("เกิดข้อผิดพลาด: " + (resData.message || "ไม่สามารถบันทึกได้"));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้");
                });
        });

        // ปุ่ม CANCEL สำหรับล้างข้อมูลทั้งหมด
        document.querySelector('.btn.cancel').addEventListener('click', function () {
            if (confirm("ต้องการยกเลิกการเขียนสูตรอาหารใช่หรือไม่? ข้อมูลจะถูกล้างทั้งหมด")) {
                location.reload();
            }
        });
    </script>
@endsection