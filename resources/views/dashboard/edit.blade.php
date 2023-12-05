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
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a id="mainProfile" href="" class="px-1"><img src="{{ asset('../images/icons/profile.png') }}"></a>
            </div>
        </div>
    </div>

    <div class="content w-4/5 mx-auto px-8 flex justify-between">
        <div class="side max-w-[20%] my-16 py-12 border-r border-r-[#ECECEC]">
            <div class="profile m-auto">
                <img src="{{ asset('../images/icons/profile-big.png') }}" class="w-[114px] m-auto" alt="profile">
                <h1 id="profileName" class="mt-5 font-bold text-[24px] text-center">
                    
                </h1>
            </div>

            <div class="navigation w-3/4 m-auto">
                <ul>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/home.png') }}" class="absolute w-[20px]" alt="dashboard">
                        <a id="mainProfile2" href="" class="pl-8">Profile</a>
                    </li>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/articles.png') }}" class="absolute w-[20px]" alt="articles">
                        <a id="linkArticle" href="" class="pl-8">Articles</a>
                    </li>
                    <li id="logout" class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/logout.png') }}" class="absolute w-[20px]" alt="logout">
                        <button id="logoutButton" class="pl-8">Logout</button>
                    </li>
                    <script>
                        $(document).ready(function() {
                            $('#logoutButton').click(function() {
                            // Remove the bearer token
                            $.ajaxSetup({
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader('Authorization', null);
                                }
                            });
                            localStorage.removeItem('accessToken');
                            // Redirect the user to the login page or perform any other necessary actions
                            window.location.href = '/login';
                            });
                        });
                    </script>
                </ul>
            </div>
        </div>

        <div class="posts font-['Inter'] min-w-[80%] my-16 py-12 px-10">
            <form action="" method="post" class="w-4/5" id="writePost">
                <h1 class="text-2xl mb-5">Edit article</h1>
                <label for="title">Title</label>
                <input type="text" class="w-full p-1 border border-[#cbccd3] rounded-sm mb-3" name="title" id="title" placeholder="Title">
                <label for="description">Description</label>
                <input type="text" class="w-full p-1 border border-[#cbccd3] rounded-sm mb-3" name="description" id="description" placeholder="History">
                
                <label for="content">Content</label>
                <textarea id="editor" name="content">
                
                </textarea>
                <script>
                    ClassicEditor
                    .create( document.querySelector( '#editor' ), {
                        ui: {
                            poweredBy: {
                                position: 'inside',
                                side: 'left',
                                label: 'This is'
                            }
                        }
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
                </script>

                <label for="image">Image URL</label>
                <input type="text" class="w-full p-1 border border-[#cbccd3] rounded-sm mb-3" name="image" id="image" placeholder="url/1.png">

                <label for="visibility">Visbility</label>
                <select id="visibility" name="visibility">
                    <option value="published">Published</option>
                    <option value="private">Private</option>
                    <option value="unlisted">Unlisted</option>
                    <option value="draf">Draf</option>
                </select>

                <button type="submit" class="w-[80px] h-[40px] rounded-md mt-3 bg-[#888888] text-[#ffffff] cursor-pointer hover:bg-[#777777]" value="Submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let username = window.location.pathname.split('/')[1];
            console.log(username);
            let url_id = window.location.pathname.split('/')[2];

            $('#writePost').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData();
                formData.append('visibility', $('#visibility').val());
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append('content', $('#editor').val());
                formData.append('image_url', $('#image').val());

                $.ajax({
                    url: '/api/user/' + username + '/' + url_id + '/update',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                        // other headers if needed...
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: "Edit article success"
                        });
                    },
                    error: function(error) {
                        console.log(error);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                                toast.getElement().querySelector('.swal2-title').style.color = '#000';
                                toast.getElement().querySelector('.swal2-timer-progress-bar').style.backgroundColor = '#333';
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: "Error, please try again",
                        });
                    }
                });
            });
        });
    </script>

    <script>
    $(document).ready(function() {
        let jwt = localStorage.getItem('accessToken');
        let tokens = jwt.split(".");

        console.log(JSON.parse(atob(tokens[0])));
        console.log(JSON.parse(atob(tokens[1])));

        const identity = JSON.parse(atob(tokens[1])).user_id;

        let username = window.location.pathname.split('/')[1];
        let articleUrl = window.location.pathname.split('/')[2];
        
        console.log(username, articleUrl);

        $.ajax({
            url: '/api/me',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                // other headers if needed...
            },
            success: function(data) {
                if (username != data.data.username) {
                    return window.location.href = '/403';
                }

                let name = document.getElementById('profileName');
                name.textContent = data.data.name;

                let mainProfile = document.getElementById('mainProfile');
                mainProfile.href = "/u/" + data.data.username;

                let mainProfile2 = document.getElementById('mainProfile2');
                mainProfile2.href = "/u/" + data.data.username;

                let linkArticle = document.getElementById('linkArticle');
                linkArticle.href = "/u/" + data.data.username + "/articles";
                // Handle the successful response
                console.log(data);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                // return window.location.href = '/404';
            }
        });

        $.ajax({
            url: '/api/user/' + username + '/' + articleUrl,
            type: 'GET',
            success: function(data) {
                console.log(data);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText, status, error);

                $.ajax({
                    url: '/api/user/' + username,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.data.articles);

                        let found = false;

                        for (let i = 0; i < data.data.articles.data.length; i++) {
                            if (data.data.articles.data[i][0].url == articleUrl) {
                                found = true;
                            }
                        }

                        if (!found) {
                            return window.location.href = '/404';
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText, status, error);
                    }
                });

                // return window.location.href = '/404';
            }
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

</body>
</html>