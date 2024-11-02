<x-layout>
    <a href="{{ route('teachers.home') }}">Voltar</a><br><br>
    

    <div class="container">
        <h1>Your Videos</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('teachers.videos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="video_name">Video Name</label>
                <input type="text" name="video_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="video_url">Video URL</label>
                <input type="url" name="video_url" class="form-control" required>
                @error('video_url')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Video</button>
        </form>

        <h2 class="mt-4">Existing Videos</h2>
        <ul class="list-group mt-3">
            @foreach($videos as $video)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="d-flex flex-column">
                        <span>
                            {{ $video->video_name }}
                        </span>
                        <br>
                        <iframe 
                            width="200" 
                            height="113" 
                            src="https://www.youtube.com/embed/{{ \App\Services\VideoService::extractYoutubeId($video->video_url) }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    <form action="{{ route('teachers.videos.delete', $video->video_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>

</x-layout>