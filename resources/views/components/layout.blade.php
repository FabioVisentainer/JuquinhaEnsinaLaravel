<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/skillos.png') }}" type="image/png">
    <title>Juquinha Ensina</title>
    <!-- incluindo stilos importados -->
    @vite('resources/css/app.css') 
    @vite('resources/js/app.js')
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">  --}}
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@100;300;400;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="body">



    @if (session('status'))
        <div>{{session('status')}}</div>
    @endif

    {{ $slot }}
        

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
           <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>


</body>
</html>