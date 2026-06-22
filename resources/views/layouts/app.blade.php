<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Temukan produk berkualitas tinggi dan terbaru di {{ $settings['shop_name'] ?? 'Nia Store' }}. Belanja mudah, cepat, dan terpercaya.">
    <meta name="keywords" content="toko online, e-commerce, produk murah, produk premium, nia store">
    <meta name="author" content="{{ $settings['shop_name'] ?? 'Nia Store' }}">
    <title>@yield('title', 'Toko Online Premium') - {{ $settings['shop_name'] ?? 'Nia Store' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Boxicons CDN (Icons) -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @yield('content')
</body>
</html>
