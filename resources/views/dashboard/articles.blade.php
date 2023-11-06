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
                <a href="" class="mx-1"><img src="{{ asset('../images/icons/profile.png') }}"></a>
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
            <div class="float-right mb-5">
                <a href="/dashboard/articles/write" class="text-right text-sm text-[#5E5E5E] relative w-10 pl-6 hover:text-[#000000]">
                    <img src="{{ asset('images/icons/write.png') }}" alt="article" class="w-[20px] absolute text-right align-middle">
                    Write an article
                </a>
            </div>
            <table class="w-full rounded-sm mt-3 table-fixed text-[#616161]">
                <tr class="bg-slate-900 text-[#ECECEC] text-left h-12 text-sm">
                    <th class="w-[50px] text-center">ID</th>
                    <th class="w-[130px]">Date</th>
                    <th class="w-[105px]">Category</th>
                    <th class="w-[250px]">Title</th>
                    <th class="w-[110px]">Author</th>
                    <th class="w-[160px]">Action</th>
                </tr>
                <tr class="odd:bg-white even:bg-[#eeeeee] text-sm h-9 hover:text-black">
                    <td class="text-center">1</td>
                    <td>10/6/2023</td>
                    <td>History</td>
                    <td class="truncate">Get to Know About Stellaron Hunters</td>
                    <td>Kafka</td>
                    <td class="flex justify-start h-9 gap-3 items-center">
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/update.png') }}" alt="Edit" class="absolute top-[0.7px] w-[18px]">
                                Edit
                            </a>
                        </div>
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="absolute w-[18px]">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="odd:bg-white even:bg-[#eeeeee] text-sm h-9 hover:text-black">
                    <td class="text-center">2</td>
                    <td>10/2/2023</td>
                    <td>History</td>
                    <td class="truncate">High Cloud Quintet and Its Demise</td>
                    <td>Jing Yuan</td>
                    <td class="flex justify-start h-9 gap-3 items-center">
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/update.png') }}" alt="Edit" class="absolute top-[0.7px] w-[18px]">
                                Edit
                            </a>
                        </div>
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="absolute w-[18px]">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="odd:bg-white even:bg-[#eeeeee] text-sm h-9 hover:text-black">
                    <td class="text-center">3</td>
                    <td>10/2/2023</td>
                    <td>Biography</td>
                    <td class="truncate">What is The Greatest Thing Imbibitor Lunae Can Do?</td>
                    <td>Jing Yuan</td>
                    <td class="flex justify-start h-9 gap-3 items-center">
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/update.png') }}" alt="Edit" class="absolute top-[0.7px] w-[18px]">
                                Edit
                            </a>
                        </div>
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="absolute w-[18px]">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <tr class="odd:bg-white even:bg-[#eeeeee] text-sm h-9 hover:text-black">
                    <td class="text-center">4</td>
                    <td>10/2/2023</td>
                    <td>Biography</td>
                    <td class="truncate">What is The Greatest Thing Imbibitor Lunae Can Do?</td>
                    <td>Jing Yuan</td>
                    <td class="flex justify-start h-9 gap-3 items-center">
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/update.png') }}" alt="Edit" class="absolute top-[0.7px] w-[18px]">
                                Edit
                            </a>
                        </div>
                        <div class="relative">
                            <a href="" class="pl-5">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Delete" class="absolute w-[18px]">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>