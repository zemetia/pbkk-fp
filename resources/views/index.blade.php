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

            <form action="/q/" method="get" class="flex items-center">
                <!-- @csrf -->
                <input type="text" placeholder="Search" class="border-2 p-1 text-sm align-middle mt-4 px-2 rounded-lg" name="search" />
                <input type="submit" class="p-1 font-bold mt-4 h-[30px] leading-[0px]" value=" ">
            </form>

            <div class="font-semibold">
                <a id="login" href="/login" class="mx-1">SIGN IN</a>
                <a id="register" href="/register" class="ml-4">SIGN UP</a>
            </div>
        </div>
    </div>

    <div class="content w-4/5 mx-auto px-8 flex justify-between">
        <div id="posts" class="posts my-16 py-12 pr-10 border-r border-r-[#ECECEC]">
            <div class="choices max-w-full border-b flex items-center">
                <span class="active py-3 mr-3 border-b border-black">New</span>
            </div>

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

                let page;

                if (!window.location.pathname.split('/')[2]) {
                    page = 1;
                }
                else {
                    page = window.location.pathname.split('/')[2];
                }

                $.ajax({
                    url: '/api/articles/q?page='+ page +'&per_page=5',
                    method: 'GET',
                    success: function(data) {
                        console.log(data);

                        let articles = data.data.data_per_page;
                    
                        for (let i = 0; i < articles.length; i++) {
                            let article = articles[i];

                            if (article.visibility == 'published') {
                                
                                let articleHTML = '<div class="article my-20">';
                                articleHTML += '<a href="/' + article.author.username + '/' + article.url + '">';
                                articleHTML += '<div class="flex justify-between relative min-h-[120px]">';
                                articleHTML += '<div class="information pr-5">';
                                articleHTML += '<h1 id="title" class="text-xl font-bold">' + article.title + '</h1>';
                                articleHTML += '<p id="description" class="min-h-[150px] max-h-[150px] text-sm mt-3 text-ellipsis overflow-hidden">' + article.description + '</p>';
                                articleHTML += '</div>';
                                articleHTML += '<div class="thumbnail w-1/4 overflow-hidden">';
                                articleHTML += '<img src="' + article.image_url + '" alt="' + article.title + '" />';
                                articleHTML += '</div>';
                                articleHTML += '</div>';
                                articleHTML += '</a>';
                                articleHTML += '<div class="flex justify-between items-end">';
                                articleHTML += '<div class="author w-1/2 mt-5">';
                                articleHTML += '<div class="flex items-center justify-start">';
                                articleHTML += '<div class="profile overflow-hidden">';
                                articleHTML += '<img src="' + article.author.photo + '" alt="' + article.author.name + '" />';
                                articleHTML += '</div>';
                                articleHTML += '<span class="name text-sm font-medium pl-2 text-black">' + article.author.name + '</span>';
                                const date = new Date(article.created_at);
                                const dateOnly = date.toISOString().split('T')[0];
                                articleHTML += '<span class="date max-w-[200px] text-sm font-medium text-[717171] mx-5">' + dateOnly + '</span>';
                                articleHTML += '</div>';
                                articleHTML += '</div>';
                                articleHTML += '<div class="post-category flex items-center">';
                                articleHTML += '<div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 h-[32px] text-xs">' + article.tags + '</div>';
                                articleHTML += '</div>';
                                articleHTML += '</div>';
                                articleHTML += '</div>';
                                
                                $('#posts').append(articleHTML);
                            }
                        }

                        if (page-1 == 0) {
                            page = parseInt(page);
                            let articleHTML = '<div class="flex justify-between">';
                            articleHTML += '<div id="prev" class="left-0 invisible"><a href="/page/">Previous page</a></div>';
                            articleHTML += '<div id="next" class="right-0 text-right"><a href="/page/' + (page+1) + '">Older articles</a></div>';
                            articleHTML += '</div>';
                            $('#posts').append(articleHTML);
                        }
                        else {
                            page = parseInt(page);
                            let articleHTML = '<div class="flex justify-between mt-3">';
                            articleHTML += '<div id="prev" class="left-0 text-left"><a href="/page/' + (page-1) + '">Previous page</a></div>';
                            articleHTML += '<div id="next" class="right-0 text-right"><a href="/page/' + (page+1) + '">Older articles</a></div>';
                            articleHTML += '</div>';
                            $('#posts').append(articleHTML);
                            if (articles.length == 0) {
                                let next = document.getElementById('next');
                                next.classList.add('invisible');
                            }
                        }
                    },
                    error: function(error) {
                        // Handle the error if the post deletion fails
                        console.error('Failed to load articles', error);
                    }
                });
            });
            </script>

            <!-- <div class="articles my-12">
                <a href="">
                <div class="flex justify-between relative min-h-[120px]">
                    <div class="information pr-5">
                        <h1 id="title" class="text-xl font-bold">
                            Get to Know About Stellaron Hunters
                        </h1>
                        <p id="description" class="text-sm mt-3 text-ellipsis overflow-hidden">
                            The Stellaron Hunters are a faction in Honkai: Star Rail. Founded and led by Elio, they are a mysterious organization that collect Stellarons. They are said to work against the Interastral Peace Corporation. Their known members are Kafka, Silver Wolf, Blade, and Sam.   
                        </p>
                    </div>
                    <div class="thumbnail w-1/4 overflow-hidden">
                        <img src="images/stellaron hunters.jpg" alt="Stellaron Hunters" />
                    </div>
                </div>
                </a>
                

                <div class="flex justify-between items-end">
                    <div class="author w-1/2 mt-5">
                        <div class="flex items-center justify-start">
                            <div class="profile overflow-hidden">
                                <img src="images/profiles/kafka-3.png" alt="Kafka" />
                            </div>
                            <span class="name font-medium pl-2 text-black">Kafka</span>

                            <span class="date font-medium text-[717171] mx-5">Oct 6, 2023</span>
                        </div>
                    </div>

                    <div class="post-category flex items-center">
                        <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 h-[32px]">
                            History
                        </div>
                    </div>
                </div>
            </div>

            <div class="articles my-12">
                <a href="">
                    <div class="flex justify-between relative min-h-[120px]">
                        <div class="information pr-5">
                            <h1 class="text-xl font-bold">
                                High Cloud Quintet and Its Demise
                            </h1>
                            <p class="text-sm mt-3 text-ellipsis overflow-hidden">
                                The High-Cloud Quintet was a legendary group of five heroes in Xianzhou history. They were led by Jingliu, the previous Sword Champion of The Xianzhou Luofu. However, they disbanded less than a hundred years after their group's formation
                            </p>
                        </div>
                        <div class="thumbnail w-1/4 overflow-hidden">
                            <img src="https://static.wikia.nocookie.net/houkai-star-rail/images/7/7c/Investigation_of_Ancient_Pattern_Rubbings_from_the_Luofu_8.png" alt="High Cloud Quintet" />
                        </div>
                    </div>
                </a>

                <div class="flex justify-between items-end">
                    <div class="author w-1/2 mt-5">
                        <div class="flex items-center justify-start">
                            <div class="profile overflow-hidden">
                                <img src="images/profiles/jing yuan fix.jpg" alt="Jing Yuan" />
                            </div>
                            <span class="name font-medium pl-2 text-black">Jing Yuan</span>

                            <span class="date font-medium text-[717171] mx-5">Oct 2, 2023</span>
                        </div>
                    </div>

                    <div class="post-category flex items-center">
                        <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 h-[32px]">
                            History
                        </div>
                    </div>
                </div>
            </div>

            <div class="articles my-12">
                <a href="">
                    <div class="flex justify-between relative min-h-[120px]">
                        <div class="information pr-5">
                            <h1 class="text-lg font-bold">
                                What is The Greatest Thing Imbibitor Lunae Can Do?
                            </h1>
                            <p class="text-sm mt-3 text-ellipsis overflow-hidden">
                                Imbibitor Lunae is the title used by the Vidyadhara High Elder of The Xianzhou Luofu, successor of the Azure Dragon, Commander of the Clouds and the Rain, and is tasked with watching over the Ambrosial Arbor. After the Vidyadhara joined...
                            </p>
                        </div>
                        <div class="thumbnail w-1/4 overflow-hidden">
                            <img src="https://s1.zerochan.net/Imbibitor.Lunae.600.3989791.jpg" alt="High Cloud Quintet" />
                        </div>
                    </div>
                </a>

                <div class="flex justify-between items-end relative">
                    <div class="author w-1/2 mt-5">
                        <div class="flex items-center justify-start">
                            <div class="profile overflow-hidden">
                                <img src="images/profiles/jing yuan fix.jpg" alt="Jing Yuan" />
                            </div>
                            <span class="name font-medium pl-2 text-black">Jing Yuan</span>

                            <span class="date font-medium text-[717171] mx-5">Oct 2, 2023</span>
                        </div>
                    </div>

                    <div class="post-category flex items-center">
                        <div class="rounded-[15px] bg-[EBEBEB] leading-[32px] w-auto px-3 h-[32px]">
                            Biography
                        </div>
                    </div>
                </div>
            </div> -->
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
