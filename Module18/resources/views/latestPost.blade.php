<!DOCTYPE html>
<html>
<head>
    <title>Latest Posts for Each Category</title>
</head>
<body>
    <h1>Latest Posts for Each Category</h1>
    <ul>
        @foreach($categories as $category)
            @php
                $latestPost = $category->latestPost();
            @endphp

            @if($latestPost)
                <li>
                    <strong>Category:</strong> {{ $category->name }}<br>
                    <strong>Latest Post:</strong> {{ $latestPost->title }}<br>
                    <strong>Content:</strong> {{ $latestPost->content }}
                </li>
            @endif
        @endforeach
    </ul>
</body>
</html>
