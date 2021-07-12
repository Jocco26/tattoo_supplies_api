<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <script>window.laravel = { csrfToken: '{{ csrf_token() }}'}</script>
    <title>Product Category</title>
</head>
<body>
    @foreach ($category as $category)
        <div>
            {{ $category->name }}
        </div>
    @endforeach
</body>
</html>