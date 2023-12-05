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
                let name = document.getElementById('profileName');
                name.textContent = data.data.name;

                let mainProfile = document.getElementById('mainProfile');
                mainProfile.href = "/u/" + data.data.username;

                const usernameReal = data.data.username;
                if (username != data.data.username) {
                    let logout = document.getElementById('logout');
                    logout.classList.add('invisible');

                    let writeDiv = document.getElementById('writeDiv');
                    writeDiv.classList.add('invisible');
                }
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

    
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="navbar bg-white mx-auto max-w-full">
        <div class="flex h-full items-center justify-between px-8 w-4/5 mx-auto">
            <h1 class="text-2xl font-bold">
                <a href="/">
                LOGO
                </a>
            </h1>
            <div class="font-semibold">
                <a id="mainProfile" href="" class="mx-1"><img src="{{ asset('../images/icons/profile.png') }}"></a>
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
                        <a href="/u/{{Route::current()->parameter('username')}}" class="pl-8">Profile</a>
                    </li>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/articles.png') }}" class="absolute w-[20px]" alt="articles">
                        <a href="/u/{{Route::current()->parameter('username')}}/articles" class="pl-8">Articles</a>
                    </li>
                    <li id="logout" class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/logout.png') }}" class="absolute w-[20px]" alt="logout">
                        <a href="/logout" class="pl-8">Logout</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="posts font-['Inter'] min-w-[80%] my-16 py-12 px-10">
            <div id="writeDiv" class="float-right mb-5">
                <a href="/write" class="text-right text-sm text-[#5E5E5E] relative w-10 pl-6 hover:text-[#000000]">
                    <img src="{{ asset('images/icons/write.png') }}" alt="article" class="w-[20px] absolute text-right align-middle">
                    Write an article
                </a>
            </div>
            <table id="articles" class="w-full rounded-sm mt-3 table-fixed text-[#616161]">
                <tr class="bg-slate-900 text-[#ECECEC] text-left h-12 text-sm">
                    <th class="w-[50px] text-center">ID</th>
                    <th class="w-[150px]">Date</th>
                    <th class="w-[250px]">Title</th>
                    <th class="w-[110px]">Author</th>
                    <th class="w-[110px]">Status</th>
                    <th class="w-[180px]">Action</th>
                </tr>

                <script>
                $(document).ready(function() {
                    let jwt = localStorage.getItem('accessToken');
                    let tokens = jwt.split(".");

                    console.log(JSON.parse(atob(tokens[0])));
                    console.log(JSON.parse(atob(tokens[1])));

                    const identity = JSON.parse(atob(tokens[1])).user_id;
                    let username = window.location.pathname.split('/')[2];

                    console.log(username);

                    $.ajax({
                        url: '/api/user/' + username,
                        type: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                            // other headers if needed...
                        },
                        success: function(data) {
                            // Handle the successful response
                            let name = document.getElementById('profileName');
                            name.textContent = data.data.name;

                            console.log(data.data.articles.data.length)

                            for (let i = 0; i < data.data.articles.data.length; i++) {
                                
                                const tableRow = document.createElement('tr');
                                tableRow.classList.add('odd:bg-white', 'even:bg-[#eeeeee]', 'text-sm', 'h-9', 'hover:text-black');

                                const cell1 = document.createElement('td');
                                cell1.classList.add('text-center');
                                cell1.textContent = i+1;

                                const cell2 = document.createElement('td');
                                cell2.textContent = data.data.articles.data[i][0].created_at;

                                const cell4 = document.createElement('td');
                                cell4.classList.add('truncate');
                                cell4.textContent = data.data.articles.data[i][0].title;

                                const cell5 = document.createElement('td');
                                cell5.textContent = data.data.name;

                                const cellVisibility = document.createElement('td');
                                cellVisibility.textContent = data.data.articles.data[i][0].visibility;

                                const cell6 = document.createElement('td');
                                cell6.classList.add('flex', 'justify-start', 'h-9', 'gap-3', 'items-center');

                                const editButton = document.createElement('div');
                                editButton.classList.add('pl-5');
                                editButton.innerHTML = '<div class="relative"><a id="edit'+i+'" href="/' + username + '/' + data.data.articles.data[i][0].url + '/edit" class="pl-5"><img src="{{ asset("../images/icons/update.png") }}" alt="Edit" class="absolute top-[0.7px] w-[18px]"> Edit</a></div>';

                                const deleteButton = document.createElement('div');
                                deleteButton.classList.add('pl-5');
                                deleteButton.innerHTML = '<button id="delete'+i+'" class="relative"><img src="{{ asset("../images/icons/delete.png") }}" alt="Delete" class="absolute w-[18px] right-[43px]"> Delete</button>';

                                cell6.appendChild(editButton);
                                cell6.appendChild(deleteButton);

                                tableRow.appendChild(cell1);
                                tableRow.appendChild(cell2);
                                tableRow.appendChild(cell4);
                                tableRow.appendChild(cell5);
                                tableRow.appendChild(cellVisibility);
                                tableRow.appendChild(cell6);

                                document.getElementById('articles').appendChild(tableRow);
                                if (identity != data.data.id) {
                                    let logout = document.getElementById('logout');
                                    logout.classList.add('invisible');

                                    let writeArticle = document.getElementById('writeDiv');
                                    writeArticle.classList.add('invisible');

                                    let editButton = document.getElementById('edit'+i);
                                    editButton.classList.add('invisible');

                                    let deleteButton = document.getElementById('delete'+i);
                                    deleteButton.classList.add('invisible');

                                    console.log('this used is logged in')
                                }
                                else {
                                    logout.classList.remove('invisible');
                                    logout.classList.add('visible');
                                    editButton.classList.add('visible');
                                    deleteButton.classList.add('visible');
                                }
                                $('#delete'+i).click(function() {
                                    // Make an AJAX request to delete the post
                                    $.ajax({
                                        url: '/api/user/' + data.data.username + '/' + data.data.articles.data[i][0].url, // Replace with the actual post URL
                                        method: 'DELETE',
                                        headers: {
                                            'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                                            // other headers if needed...
                                        },
                                        success: function(response) {
                                            // Handle the successful deletion of the post
                                            console.log('Post deleted successfully');
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
                                                title: "Post deleted successfully",
                                            });
                                        },
                                        error: function(error) {
                                            // Handle the error if the post deletion fails
                                            console.error('Failed to delete post:', error);
                                        }
                                    });
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error(xhr.responseText);
                            return window.location.href = '/404';
                        }
                    });
                });
                </script>
            </table>
        </div>
    </div>

</body>
</html>