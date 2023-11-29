<html lang='id'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <title>PBKK</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('highlight/styles/lightfair.min.css') }}">
    <script src="{{ asset('highlight/highlight.min.js') }}"></script>
</head>

<body>
    <div class="navbar bg-white mx-auto max-w-full">
        <div class="flex h-full items-center justify-between px-8 w-4/5 mx-auto">
            <h1 class="text-2xl font-bold">
                LOGO
            </h1>
            <div class="font-semibold">
                <a href="" class="px-1"><img src="{{ asset('../images/icons/profile.png') }}"></a>
            </div>
        </div>
    </div>

    <div class="content w-4/5 mx-auto px-8 flex justify-between">
        <div class="side max-w-[20%] my-16 py-12 border-r border-r-[#ECECEC]">
            <div class="profile m-auto">
                <img src="{{ asset('../images/icons/profile-big.png') }}" class="w-[114px] m-auto" alt="profile">
                <h1 class="mt-5 font-bold text-[24px] text-center">
                    Randolvski
                </h1>
            </div>

            <div class="navigation w-3/4 m-auto">
                <ul>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/home.png') }}" class="absolute w-[20px]" alt="dashboard">
                        <a href="/dashboard" class="pl-8">Dashboard</a>
                    </li>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/articles.png') }}" class="absolute w-[20px]" alt="articles">
                        <a href="/dashboard/articles" class="pl-8">Articles</a>
                    </li>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/logout.png') }}" class="absolute w-[20px]" alt="logout">
                        <a href="/logout" class="pl-8">Logout</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="posts font-['Inter'] min-w-[80%] my-16 py-12 px-10">
            <h2 class="text-md font-medium">Welcome back,</h2>
            <h1 class="text-xl font-bold">Randolvski</h1>
        </div>
    </div>

    
    <script>
    $.ajaxSetup({
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('accessToken')
        }
    });

    // AJAX request to `/dashboard` can be made here
    $.get('/api/test', function(data) {
        console.log(data);
    });
    </script>

    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
</body>
</html>