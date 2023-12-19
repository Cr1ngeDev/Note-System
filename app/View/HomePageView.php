<?php require 'templates/header.html' ?>
<?php require 'templates/nav.php'; ?>
<?php require 'templates/banner.php' ?>
        <main>
            <?php if (empty($all_notes)): ?>
                    <div class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                            <div class="text-center">
                                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Your
                                            notes not
                                            found</h1>
                                    <p class="mt-6 text-base leading-7 text-gray-600">You can create new one. Click
                                            below.</p>
                                    <div class="mt-10 flex items-center justify-center gap-x-6">
                                            <a href="/create"
                                               class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create
                                                    note</a>
                                    </div>
                            </div>
                    </div>
            <?php else: ?>
                    <section class="bg-white dark:bg-gray-900">
                            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 ">
                                    <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                                                    Your notes</h2>
                                            <p class="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">
                                                    Explore the
                                                    whole collection of open-source web components and elements built
                                                    with the
                                                    utility classes from Tailwind</p>
                                    </div>
                                        <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
                                            <?php foreach ($all_notes as $note): ?>
                                                    <div class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                                                            <div class="p-5">
                                                                    <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                                            <p><?=htmlspecialchars($note['note_name'])?></p>
                                                                    </h3>
                                                                    <span class="text-gray-500 dark:text-gray-400">Created at: <?=$note['createdAt'] ?? 'recently'?></span>
                                                                    <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                                                                        <?=htmlspecialchars(getFirstSentence($note['text']) . '...')?></p>
                                                                    <a style="text-decoration: underline; color: dodgerblue"
                                                                       href="/note/<?=$note['id'] ?? null?>">Show note...</a>
                                                            </div>
                                                    </div>
                                            <?php endforeach; ?>
                                        </div>
                            </div>
                    </section>

            <?php endif; ?>
        </main>

<?php require 'templates/footer.html' ?>