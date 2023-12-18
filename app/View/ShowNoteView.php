<?php require 'templates/header.html' ?>
<?php require 'templates/nav.php'; ?>
<?php require 'templates/banner.php' ?>

        <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
                <div style="display: flex; flex-direction: column; align-content: center; flex-wrap: wrap" class="px-4 mx-auto max-w-screen-xl">
                        <article
                                class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                                <header class="mb-4 lg:mb-6 not-format">
                                        <address class="flex items-center mb-6 not-italic">
                                                <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                                        <img class="mr-4 w-16 h-16 rounded-full"
                                                             src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                                                             alt="Jese Leos">
                                                        <div>
                                                                <a href="#" rel="author"
                                                                   class="text-xl font-bold text-gray-900 dark:text-white">Jese
                                                                        Leos</a>
                                                                <p class="text-base text-gray-500 dark:text-gray-400">
                                                                        Graphic Designer, educator & CEO Flowbite</p>
                                                                <p class="text-base text-gray-500 dark:text-gray-400">
                                                                        <time pubdate datetime="2022-02-08"
                                                                              title="February 8th, 2022"><?=$noteData['createdAt'] ?? 'recently'?>
                                                                        </time>
                                                                </p>
                                                        </div>
                                                </div>
                                        </address>
                                        <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                                                <?=$noteData['note_name'] ?? ''?></h1>
                                </header>
                                <p class="lead dark:text-white"><?=$noteData['text'] ?? ''?></p>
                        </article>
                        <div style="display: flex; flex: 1; justify-content: space-between; align-items: center; margin-top: 15px">
                                <a href="#" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Edit</a>
                                <a href="/delete?id=<?=$noteData['id']?>" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete note</a>
                        </div>
                </div>
        </main>
<?php require 'templates/footer.html' ?>