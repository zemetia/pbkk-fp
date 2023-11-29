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
</head>

<body class="login max-h-full max-w-full overflow-hidden">

    <div class="navbarl flex items-center pt-8 px-24 justify-between max-w-full h-[61px] border-2">
        <div class="text-md font-medium">
            <a href='/'>Home</a>
        </div>
        <div class="text-md font-medium">
            <a href='/register'>Register</a>
        </div>
    </div>

    <div class="contentl absolute w-[400px] h-[500px] m-auto">
        <h1 class="font-bold text-[#334d5d] text-[32px]">Login</h1>
        <h2 class="text-md text-[#4c7c86]">Express your creativity</h2>
        <form class="mt-5" action="" method="post" id="loginForm">
            @csrf
            <label class="text-[#4c7c86]" for="email">Email</label>
            <input class="w-full h-[40px] bg-[#334d5d] px-3 pb-1 align-middle text-[#ebeee3] rounded rounded-sm my-2 mb-5" placeholder="randolvski@mail.com" type="text" name="email" id="email" />
            <label class="text-[#4c7c86]" for="password">Password</label>
            <input class="w-full h-[40px] bg-[#334d5d] px-3 pb-1 align-middle text-[#ebeee3] rounded rounded-sm my-2 mb-5" placeholder="randolvski" type="password" name="password" id="password" />
            <button class="m-auto mt-3 w-full px-5 py-2 pb-3 rounded rounded-sm bg-[#a8c0be] cursor-pointer" type="submit" value="Login" id="submit">Login</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData();
                formData.append('email', $('#email').val());
                formData.append('password', $('#password').val());

                $.ajax({
                    url: '/api/login_user',
                    method: 'POST',
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
                            title: "Signed in successfully"
                        });
                        localStorage.setItem('accessToken', response.data.token);
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
                                toast.getElement().querySelector('.swal2-title').style.color = '#000';
                                toast.getElement().querySelector('.swal2-timer-progress-bar').style.backgroundColor = '#333';
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: "Error, please check your credentials",
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

</body>
</html>