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
    
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

    <script>
        let jwt = localStorage.getItem('accessToken');
        let tokens = jwt.split(".");

        console.log(JSON.parse(atob(tokens[0])));
        console.log(JSON.parse(atob(tokens[1])));

        const identity = JSON.parse(atob(tokens[1])).user_id;
    </script>
</head>

<body>
    <div class="navbar bg-white mx-auto max-w-full">
        <div class="flex h-full items-center justify-between px-8 w-4/5 mx-auto">
            <h1 class="text-2xl font-bold">
                <a href="/">
                Home</a>
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
                        <a href="/u/{{Route::current()->parameter('username')}}" class="pl-8">Profile</a>
                    </li>
                    <li class="mt-5 pl-5">
                        <img src="{{ asset('images/icons/articles.png') }}" class="absolute w-[20px]" alt="articles">
                        <a href="/u/{{Route::current()->parameter('username')}}/articles" class="pl-8">Articles</a>
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

        <div class="posts font-['Inter'] min-w-[80%] my-20 py-12 px-10">
            <h1 id="username" class="text-xl font-bold"></h1>
            <h1 id="email" class="mt-1 text-sm"></h1>
            <h1 id="authored" class="mt-3 text-sm"></h1>
            <h1 id="follower" class="mt-3 text-sm"></h1>
            <h1 id="following" class="mt-3 text-sm"></h1>
            <form id="followButton" action="" method="POST">
                @csrf
                <button type="submit" class="flex text-sm cursor-pointer mt-3 w-[75px] h-[30px] border-2 border-[#858585] rounded-[10px] justify-center items-center hover:opacity-[0.6]">
                    Follow
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

    <script>
    $(document).ready(function() {
        let username = window.location.pathname.split('/')[2];
        
        $.ajax({
            url: '/api/user/' + username,
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                // other headers if needed...
            },
            success: function(data) {
                let name = document.getElementById('profileName');
                name.textContent = data.data.name;

                let username = document.getElementById('username');
                username.textContent = data.data.username;

                let email = document.getElementById('email');
                email.textContent = data.data.email;

                let authored = document.getElementById('authored');
                authored.textContent = "Authored " + data.data.count.authored + " articles";
                
                let follower = document.getElementById('follower');
                follower.textContent = "Follower: " + data.data.count.follower;

                let following = document.getElementById('following');
                following.textContent = "Following: " + data.data.count.following;

                let followButton = document.getElementById('followButton');

                let mainProfile = document.getElementById('mainProfile');
                mainProfile.href = "/u/" + data.data.username;
                // Handle the successful response

                if (!identity) {
                    logout.classList.add('invisible');

                    followButton.classList.add('visible');

                    mainProfile.classList.add('invisible');
                }
                else {
                    if (identity != data.data.id) {
                        let logout = document.getElementById('logout');
                        logout.classList.add('invisible');

                        followButton.classList.add('visible');

                        console.log('this used is logged in');
                    }
                    else {
                        logout.classList.remove('invisible');
                        logout.classList.add('visible');
                        followButton.classList.remove('visible');
                        followButton.classList.add('invisible');
                    }
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
                return window.location.href = '/404';
            }
        });
    });

    $(document).ready(function() {
        let username = window.location.pathname.split('/')[2];
        $('#followButton').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            $.ajax({
                url: '/api/user/' + username + '/follow',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    // other headers if needed...
                },
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
                        title: "Followed"
                    });
                    // window.location.href = '/dashboard'; // Redirect to dashboard
                },
                error: function(error) {
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
                        icon: "error",
                        title: "Error, please try again",
                    });
                }
            });
        });
    });
    </script>
</body>
</html>