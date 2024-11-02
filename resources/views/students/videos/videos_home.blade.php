<x-layout>
    <a href="{{ route('students.home') }}">Voltar</a><br><br>
    

    <div class="container">
        <h1>Videos</h1>

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
                </li>
            @endforeach
        </ul>

</x-layout>