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

    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

</head>

<body>
    <div class="navbar bg-white mx-auto max-w-full">
        <div class="flex h-full items-center justify-between px-8 w-4/5 mx-auto">
            <h1 class="text-2xl font-bold">
            <a href="/">
                Home
                </a>
            </h1>
            <div class="font-semibold">
                <a id="login" href="/login" class="mx-1">SIGN IN</a>
                <a id="register" href="/register" class="ml-4">SIGN UP</a>
            </div>
        </div>
    </div>

    <div class="content w-4/5 mx-auto px-8 flex justify-between">
        <div id="posts" class="posts my-16 py-12 pr-10 border-r border-r-[#ECECEC]">


            <script>
            $(document).ready(function() {
                $.ajax({
                    url: '/api/me',
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                        // other headers if needed...
                    },
                    success: function(data) {
                        let login = document.getElementById('login');
                        login.classList.add('invisible');
                        
                        let register = document.getElementById('register');
                        register.href = "/u/" + data.data.username;
                        register.textContent = "PROFILE"
                        // Handle the successful response
                        console.log(data);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                        // return window.location.href = '/404';
                    }
                });

                let username = window.location.pathname.split('/')[1];
                let url = window.location.pathname.split('/')[2];

                $.ajax({
                    url: '/api/user/' + username + '/' + url,
                    type: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                        // other headers if needed...
                    },
                    success: function(data) {
                        console.log('success');
                        // Handle the successful response
                        console.log(data);

                        let articleHTML = '<div class="articleBegin">';
                        articleHTML += '<h1 class="title text-xl font-bold">' + data.data.title + '</h1>';
                        date = new Date(data.data.created_at);
                        const dateOnly = date.toISOString().split('T')[0];
                        articleHTML += '<h3 class="text-sm text-gray-500 my-5">' + data.data.author.name + ' - ' + dateOnly +'</h3>';
                        articleHTML += '<div class="aspect-video border-2 border-red relative overflow-hidden">';
                        articleHTML += '<img src="'+ data.data.image_url +'" alt="'+ data.data.title +'" class="w-full absolute">';
                        articleHTML += '</div>';

                        articleHTML += '<div class="mt-5">';
                        articleHTML += data.data.content;
                        articleHTML += '</div>';
                        articleHTML += '</div>';

                        $('#posts').append(articleHTML);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                        // return window.location.href = '/404';
                    }
                });
            });
            </script>
        </div>

        <div class="side my-16 py-12 pl-10">
            <h1 class="py-3">Recommended topics</h1>
            <div class="category flex flex-wrap min-h-[60px] gap-3 flex-row content-start">
                <a href="#" class="max-h-[32px]">
                    <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 text-center h-[32px] inline-block text-xs">
                        History
                    </div>
                </a>
                <a href="#" class="max-h-[32px]">
                    <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 text-center h-[32px] inline-block text-xs">
                        Biography
                    </div>
                </a>
                <a href="#" class="max-h-[32px]">
                    <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 text-center h-[32px] inline-block text-xs">
                        Theory
                    </div>
                </a>
                <a href="#" class="max-h-[32px]">
                    <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 text-center h-[32px] inline-block text-xs">
                        Gameplay
                    </div>
                </a>
                <a href="#" class="max-h-[32px]">
                    <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 text-center h-[32px] inline-block text-xs">
                        Leaks
                    </div>
                </a>
            </div>
            <h1 class="pt-5">
                <a href="#" class="text-xs text-[432DB7]">
                    More topics
                </a>
            </h1>

            <h1 class="py-1 mt-5">People to follow</h1>
            <div class="people flex min-h-[75px] items-center">
                <div class="profile w-[40px] h-[40px] overflow-hidden rounded-full relative">
                    <img src="images/profiles/kafka-3.png" alt="Kafka" class="absolute">
                </div>
                <div class="info px-3 max-w-[240px] min-h-[60px] self-end">
                    <h1 class="text-sm font-medium pt-1">Kafka</h1>
                    <h2 class="text-xs font-thin text-[808080]">Member of Stellaron Hunters</h2>
                </div>
            </div>

            <div class="people flex min-h-[75px] items-center">
                <div class="profile w-[40px] h-[40px] overflow-hidden rounded-full relative">
                    <img src="images/profiles/jing yuan fix.jpg" alt="Jing Yuan" class="absolute">
                </div>
                <div class="info px-3 max-w-[240px] min-h-[60px] self-end">
                    <h1 class="text-sm font-medium pt-1">Jing Yuan</h1>
                    <h2 class="text-xs font-thin text-[808080]">Arbiter-Generals of the Xianzhou Alliance's Cloud Knights</h2>
                </div>
            </div>

            <div class="people flex min-h-[75px] items-center">
                <div class="profile w-[40px] h-[40px] overflow-hidden rounded-full relative">
                    <img src="https://i.pinimg.com/736x/47/71/a0/4771a0fcd92112e2782fdc08d5a9558e.jpg" alt="Caelus" class="absolute">
                </div>
                <div class="info px-3 max-w-[240px] min-h-[60px] self-end">
                    <h1 class="text-sm font-medium pt-1">Caelus</h1>
                    <h2 class="text-xs font-thin text-[808080]">Trailblazer, Member of Astral Express Crew</h2>
                </div>
            </div>

            <h1 class="pt-5">
                <a href="#" class="text-xs text-[432DB7]">
                    More topics
                </a>
            </h1>
        </div>
    </div>

    <!--
    <code-block language="html" label="example.html" controls>
        <textarea>
<script>
    console.log(true);
</script>
</textarea>
    </code-block>
    <div id="test-markdown-view">
        Server-side output Markdown text 
        <textarea id='md'>### Hello world!</textarea>
    </div>
    <div id='content'></div>
    <script>
        let markdown = $('#md');
        markdown.keyup(() => {
            var data = marked.parse(markdown.val());
            document.getElementById('content').innerHTML = data;
            hljs.highlightAll();
            console.log(data);

        });
        document.addEventListener('DOMContentLoaded', () => {
            hljs.highlightAll();
        })
    </script> -->

    <script>
        $(document).ready(function() {
        let jwt = localStorage.getItem('accessToken');
        let tokens = jwt.split(".");

        console.log(JSON.parse(atob(tokens[0])));
        console.log(JSON.parse(atob(tokens[1])));

        const identity = JSON.parse(atob(tokens[1])).user_id;
        let username = window.location.pathname.split('/')[2];
        
        $.ajax({
            url: '/api/me',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                // other headers if needed...
            },
            success: function(data) {
                // let name = document.getElementById('profileName');
                // name.textContent = data.data.name;

                // let mainProfile = document.getElementById('mainProfile');
                // mainProfile.href = "/u/" + data.data.username;

                // const usernameReal = data.data.username;
                // if (username != data.data.username) {
                //     let logout = document.getElementById('logout');
                //     logout.classList.add('invisible');

                //     let writeDiv = document.getElementById('writeDiv');
                //     writeDiv.classList.add('invisible');
                // }
                // Handle the successful response
                console.log(data);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                // return window.location.href = '/404';
            }
        });
    });
    </script>
</body>

</html>
