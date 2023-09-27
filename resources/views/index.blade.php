<html lang='id'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compitable" content="ie=edge">
    <title>PBKK</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('highlight/styles/lightfair.min.css') }}">
    <script src="{{ asset('highlight/highlight.min.js') }}"></script>
    <script></script>
</head>
<style>
    h1 {
        font-size: 40px;
        color: red;
    }

    /* pre {
        background-color: black;
        color: white;
    } */
</style>

<body>
    <h1 class="text-2xl underline text-red-400 p-5 bg-blue-300">
        Tailwind
    </h1>
    <code-block language="html" label="example.html" controls>
        <textarea>
<script>
    console.log(true);
</script>
</textarea>
    </code-block>
    <div id="test-markdown-view">
        <!-- Server-side output Markdown text -->
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
    </script>
</body>

</html>
