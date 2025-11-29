<!DOCTYPE html>
<html lang="en">

<head>
    <title>Instagram Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h1>Latest Instagram Posts</h1>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($posts as $post)
            <div style="border: 1px solid #ccc; padding: 10px; width: 300px;">

                {{-- CAROUSEL ALBUM --}}
                @if($post['media_type'] == 'CAROUSEL_ALBUM' && !empty($post['children']))
                    <div id="carousel-{{ $post['id'] }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($post['children'] as $index => $child)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    @if($child['media_type'] == 'IMAGE')
                                        <img src="{{ $child['media_url'] }}" class="d-block w-100"
                                             alt="Carousel image">
                                    @elseif($child['media_type'] == 'VIDEO')
                                        <video class="d-block w-100" controls>
                                            <source src="{{ $child['media_url'] }}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button"
                                data-bs-target="#carousel-{{ $post['id'] }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                                data-bs-target="#carousel-{{ $post['id'] }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                {{-- SINGLE IMAGE / VIDEO --}}
                @elseif($post['media_type'] == 'IMAGE')
                    <img src="{{ $post['media_url'] }}" alt="{{ $post['caption'] ?? 'Instagram Post' }}"
                         style="width: 100%; height: auto;">
                @elseif($post['media_type'] == 'VIDEO')
                    <video controls style="width: 100%; height: auto;">
                        <source src="{{ $post['media_url'] }}" type="video/mp4">
                    </video>
                @endif

                <p><strong>Description</strong><br>
                    {{ \Illuminate\Support\Str::limit($post['caption'] ?? '', 50) }}
                </p>

                <p><a href="{{ $post['permalink'] }}" target="_blank">View on Instagram</a></p>
                <small>{{ \Carbon\Carbon::parse($post['timestamp'])->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
