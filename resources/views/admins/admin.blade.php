<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* 1. ตั้งค่าพื้นฐาน (Reset & Base) */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Sarabun', sans-serif;
            /* แนะนำให้ใช้ฟอนต์ไทยสวยๆ */
        }

        body {
            background-color: #f4f6f9;
            /* สีพื้นหลังเทาอ่อน สบายตา */
            color: #333;
        }

        /* 2. โครงสร้างหลัก (Layout) */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar (เมนูซ้าย) */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            /* สีกรมท่าเข้ม */
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            font-size: 24px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #4b6584;
        }

        .menu-item {
            padding: 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: #34495e;
            color: white;
        }

        /* Main Content (เนื้อหาขวา) */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            /* ให้เลื่อนลงได้ถ้าเนื้อหายาว */
        }

        .header-title {
            margin-bottom: 25px;
            font-size: 28px;
            color: #2c3e50;
        }

        /* 3. การ์ดและตาราง (Cards & Tables) */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            /* เงาบางๆ ให้ดูลอย */
            margin-bottom: 30px;
            overflow: hidden;
            /* เพื่อให้มุมโค้งไม่ถูกบัง */
        }

        .card-header {
            padding: 15px 20px;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .bg-blue {
            background-color: #3498db;
        }

        .bg-green {
            background-color: #27ae60;
        }

        /* ตัวตาราง */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th {
            background-color: #ecf0f1;
            color: #7f8c8d;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* เอฟเฟกต์เวลาชี้เมาส์ที่แถว */
        .custom-table tr:hover {
            background-color: #f9fbfd;
        }

        /* 4. ปุ่ม (Buttons) */
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-warning {
            background-color: #f1c40f;
            color: #fff;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .btn-warning:hover {
            background-color: #d4ac0d;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .action-group {
            display: flex;
            gap: 10px;
            /* ระยะห่างระหว่างปุ่ม */
            justify-content: center;
        }

        .center-text {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <a href="#" class="menu-item active">แดชบอร์ด</a>
            <a href="#users-section" class="menu-item">จัดการผู้ใช้งาน</a>
            <a href="#recipes-section" class="menu-item">จัดการสูตรอาหาร</a>
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="menu-item"
                    style="background:none; border:none; cursor:pointer; width:100%; text-align:left;">ออกจากระบบ</button>
            </form>
        </aside>

        <main class="main-content">
            <h1 class="header-title">ภาพรวมระบบจัดการ</h1>

            <div id="users-section" class="card">
                <div class="card-header bg-blue">
                    3.1 จัดการบัญชีผู้ใช้งาน และ แจ้งเตือน
                </div>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ชื่อผู้ใช้</th>
                            <th>อีเมล</th>
                            <th>บทบาท</th>
                            <th class="center-text">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->username }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span style="padding: 4px 8px; background: #eee; border-radius: 4px; font-size: 12px;">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <form action="{{ route('admin.notify', $user->user_id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('ยืนยันส่งการแจ้งเตือนตักเตือน?');">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">
                                                ⚠️ แจ้งเตือน
                                            </button>
                                        </form>

                                        
                                        <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST"
                                            onsubmit="return confirm('ยืนยันการลบ?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger">ลบ</button>
                                        </form>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="recipes-section" class="card">
                <div class="card-header bg-green">
                    จัดการสูตรอาหาร
                </div>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">ชื่อสูตรอาหาร</th>
                            <th>เจ้าของสูตร</th>
                            <th>ยอดวิว</th>
                            <th class="center-text">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->title }}</td>
                                <td>{{ $recipe->user->username ?? 'ไม่ระบุ' }}</td>
                                <td>{{ $recipe->view_count }} ครั้ง</td>
                                <td>
                                    <div class="action-group">
                                        <form action="{{ route('admin.recipes.destroy', $recipe->recipe_id) }}"
                                            method="POST" onsubmit="return confirm('ยืนยันการลบสูตรนี้?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger">ลบสูตร</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script>
        function openNotifyModal(userId) {
            // ใส่ Logic เปิด Modal ตรงนี้ หรือใช้ prompt ง่ายๆ ไปก่อน
            let message = prompt("ระบุข้อความแจ้งเตือนถึงผู้ใช้นี้:");
            if (message) {
                // ส่งค่าไปยัง Route ที่เราเตรียมไว้ (ต้องใช้ Form หรือ Ajax)
                alert("กำลังส่งข้อความ: " + message + " ไปยัง User ID: " + userId);
                // window.location.href = "/admin/notify/" + userId + "?msg=" + message; 
            }
        }
    </script>
</body>

</html>