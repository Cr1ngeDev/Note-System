<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Register</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
              crossorigin="anonymous">
</head>
<body>
<section style="background: linear-gradient(45deg, #ffffff, #d8c0e5, #b88cd9);" class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                        <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
                             alt="logo">
                        Note System
                </a>
                <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-black">
                                        Create and account
                                </h1>
                                <form class="space-y-4 md:space-y-6" action="" method="post">
                                        <div>
                                                <label for="firstname"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                                                        first name</label>
                                                <input type="text" value="<?= $userInput['firstname'] ?? '' ?>"
                                                       name="firstname" id="firstname"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       placeholder="John" required>
                                        </div>
                                        <div>
                                                <label for="lastname"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                                                        last name</label>
                                                <input type="text" value="<?= $userInput['lastname'] ?? '' ?>"
                                                       name="lastname" id="lastname"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       placeholder="Doe" required>
                                        </div>
                                        <div>
                                                <label for="email"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Your
                                                        email</label>
                                                <input type="email" value="<?= $userInput['email'] ?? '' ?>"
                                                       name="email" id="email"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       placeholder="name@company.com" required="">
                                        </div>
                                        <div>
                                                <label for="password"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Password</label>
                                                <input type="password" name="password" id="password"
                                                       placeholder="••••••••"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required="">
                                        </div>
                                        <div>
                                                <label for="confirm-password"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Confirm
                                                        password</label>
                                                <input type="password" name="confirm-password"
                                                       id="confirm-password" placeholder="••••••••"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required="">
                                        </div>
                                        <button style="background-color: #d08eb0;" type="submit"
                                                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                Create an account
                                        </button>
                                        <p class="text-sm font-light text-black-500 dark:text-black-400">
                                                Already have an account? <a href="/login"
                                                                            class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login
                                                        here</a>
                                        </p>
                                </form>
                        </div>
                </div>
            <?php if ($errors): ?>
                    <div class="flex items-center p-4 mt-5 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                         role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                    <span class="font-medium">Wait-wait-wait!</span> <?= $errors[0] ?>
                            </div>
                    </div>
            <?php endif; ?>
        </div>
</section>
</body>
</html>