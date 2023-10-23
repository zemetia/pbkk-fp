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
                <a href="" class="mx-1">SIGN IN</a>
                <a href="" class="ml-4">SIGN UP</a>
            </div>
        </div>
    </div>

    <div class="content w-4/5 mx-auto px-8 flex justify-between">
        <div class="posts my-16 py-12 pr-10">
            <div class="choices max-w-full border-b flex items-center">
                <span class="active py-3 mr-3 border-b border-black">Trending</span>
                <span class="py-3">New</span>
            </div>

            <div class="articles my-16">
                <div class="flex justify-between">
                    <div class="information pr-5">
                        <h1 class="text-xl font-bold">
                            Get to Know About Stellaron Hunters
                        </h1>
                        <p class="text-sm mt-3">
                            The Stellaron Hunters are a faction in Honkai: Star Rail. Founded and led by Elio, they are a mysterious organization that collect Stellarons. They are said to work against the Interastral Peace Corporation.    
                        </p>
                    </div>
                    <div class="thumbnail w-1/4 overflow-hidden">
                        <img src="images/stellaron hunters.jpg" alt="Stellaron Hunters" />
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="author w-1/2 mt-5">
                    <span class="name font-medium pl-10 text-black pt-1">Kafka</span>
                        <div class="profile overflow-hidden">
                            <img src="images/profiles/kafka-3.png" alt="Kafka" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="articles my-16">

            </div>
        </div>

        <div class="side my-16 py-12">

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
</body>

</html>
