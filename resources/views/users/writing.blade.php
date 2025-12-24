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
                        <select name="" id="" class="type-input">
                            <option value="" disabled selected>เลือกประเภทของอาหาร</option>
                        </select>
                    </div>

                    <!-- ประเทษ -->
                    <div class="region-container">
                        <select name="" id="" class="type-input">
                            <option value="" disabled selected>ประเทศ</option>
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
                <input type="text" id="ratio-input" placeholder="อัตราส่วน ex. 1 กรัม / 2 ช้อนชา" class="ratio-input">
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
            <button type="button" class="btn post">POST</button>
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
        const fileInput = document.getElementById('file-upload');
        const imagePreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');

        fileInput.addEventListener('change', function () {
            const file = this.files[0]; // ดึงไฟล์ที่เลือกออกมา

            if (file) {
                const reader = new FileReader();

                // เมื่ออ่านไฟล์เสร็จ
                reader.onload = function (e) {
                    imagePreview.src = e.target.result; // ใส่ URL ของรูปใน src
                    imagePreview.style.display = 'block'; // แสดงรูป
                    placeholder.style.display = 'none'; // ซ่อนไอคอน
                }

                reader.readAsDataURL(file); // สั่งให้อ่านไฟล์เป็น Data URL
            }
        });

        // 
        // 
        // 1. ดึงตัวละคร (Element) มาจากหน้าเว็บ
        const ingInput = document.getElementById('ing-input');
        const ratioInput = document.getElementById('ratio-input');
        const addBtn = document.getElementById('add-btn');
        const listContainer = document.getElementById('list-container');
        const emptyMsg = document.getElementById('empty-msg');

        // 2. สั่งให้ปุ่มทำงานเมื่อถูกคลิก
        addBtn.addEventListener('click', function () {
            const ingredient = ingInput.value.trim(); // ดึงค่าวัตถุดิบ
            const ratio = ratioInput.value.trim();    // ดึงค่าอัตราส่วน

            // ตรวจสอบว่ากรอกข้อมูลครบไหม
            if (ingredient === "" || ratio === "") {
                alert("กรุณากรอกข้อมูลให้ครบทั้ง 2 ช่อง");
                return;
            }

            // ซ่อนข้อความ "ยังไม่มีรายการ" ถ้ามี
            if (emptyMsg) {
                emptyMsg.style.display = 'none';
            }

            // 3. สร้างก้อน HTML รายการใหม่ (List Item)
            const newItem = document.createElement('div');
            newItem.classList.add('list-item');

            // ใส่เนื้อหาข้างใน (ชื่อวัตถุดิบ + อัตราส่วน + ปุ่มลบ)
            newItem.innerHTML = `
                                                <span><strong>${ingredient}</strong> : ${ratio}</span>
                                                <button class="delete-btn" onclick="this.parentElement.remove()">ลบ</button>
                                            `;

            // 4. เอาไปแปะใส่ในกล่องรายการ
            listContainer.appendChild(newItem);

            // 5. ล้างค่าในช่องกรอกให้ว่าง เตรียมรับค่าใหม่
            ingInput.value = '';
            ratioInput.value = '';

            // โฟกัสกลับไปที่ช่องแรกเพื่อให้พิมพ์ต่อได้เลย
            ingInput.focus();
        });
    </script>
@endsection