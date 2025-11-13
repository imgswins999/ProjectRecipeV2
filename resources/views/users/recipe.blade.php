@extends('layout.nav')
@section('title', 'RECIPE')
@section('content')
    <div class="container-recipe">

        <form method="post">
            <div class="search-box">
                <input type="text" name="#" class="search-input">
                <input type="image" src="{{ asset('includes/images/search.png') }}" alt="Submit Button" width="20"
                    class="search-bt">
            </div>
        </form>
<head>
    <meta charset="UTF-8">
    <title>รายการอาหาร</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .card h3 {
            margin: 8px 0 5px;
            font-size: 18px;
            color: #222;
        }
        .card p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }
     </style>
</head>
<body>
    <h2>รายการอาหาร</h2>

    <div class="card-container">
        @foreach ($recipes as $recipe)
        <div class="card">
            <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
            <h3>{{ $recipe->title }}</h3>
            <p>{{ $recipe->description }}</p>
            <p>{{ $recipe->meal_type }}</p>
            <p>{{ $recipe->region }}</p>
        </div>
        @endforeach
    </div>
</body>
    </div>
@endsection