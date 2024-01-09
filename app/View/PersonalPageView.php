<?php require 'templates/header.html' ?>
<?php require 'templates/nav.php' ?>
<?php require 'templates/banner.php' ?>
<main>
        <section class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto mt-10 max-w-screen-sm text-center lg:mb-16 mb-8">
                        <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                                Personal settings</h2>
                        <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">You can change your personal
                                settings.
                                Before start, click lock icon.</p>
                </div>
                <div class="md:flex">
                        <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                                <li>
                                        <button id="profileTab" onclick="openTab(event, 'personalInfo')"
                                                class="custom-button"
                                                aria-current="page">
                                                <svg class="icon" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                                </svg>
                                                Profile Information
                                        </button>
                                </li>
                                <li>
                                        <button id="passTab"
                                                onclick="openTab(event, 'changePass')"
                                                class="custom-button">
                                                <svg class="icon"
                                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor" viewBox="0 0 18 18">
                                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                                </svg>
                                                Change password
                                        </button>
                                </li>
                                <li>
                                        <button id="deleteTab"
                                                onclick="openTab(event, 'Delete Account')"
                                                class="custom-button">
                                                <svg class="icon"
                                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                                                </svg>
                                                Delete an account
                                        </button>
                                </li>
                        </ul>
                        <div id="personalInfo"
                             class="custom-box">
                                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Profile</h3>
                                        <p class="mb-2">Here you can find your email, name, surname.</p>
                                        <p>If you want to change your data, first you should unlock an input field.</p>
                                </div>
                                <form style="margin-top: 20px" action="" method="post"
                                      id="settingsForm">
                                        <div class="relative z-0 w-full mb-5 group"
                                             style="display: flex; align-items: center">
                                                <input style="margin-right: 5px" disabled type="email"
                                                       value="<?= $userInput['email'] ?? $userData['email'] ?>"
                                                       name="email" id="email"
                                                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                                                <label for="floating_email" style="font-size: 18px"
                                                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                                                        address</label>
                                                <svg id="firstLock" class="lockIcon" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                                <svg id="firstUnlock" class="unlockIcon"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                        </div>
                                        <div style="display: flex; align-items: center"
                                             class="grid md:grid-cols-2 md:gap-6">
                                                <div class="relative z-0 w-full mb-5 group">
                                                        <input disabled type="text"
                                                               value="<?= $userInput['firstname'] ?? htmlspecialchars($userData['firstname']) ?>"
                                                               name="first_name" id="first_name"
                                                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                               placeholder=" " required/>
                                                        <label for="floating_first_name" style="font-size: 18px"
                                                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                                                                name</label>
                                                </div>
                                                <div class="relative z-0 w-full mb-5 group">
                                                        <input disabled type="text"
                                                               value="<?= $userInput['lastname'] ?? htmlspecialchars($userData['lastname']) ?>"
                                                               name="last_name" id="last_name"
                                                               class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                                               placeholder=" " required/>
                                                        <label for="floating_last_name" style="font-size: 18px"
                                                               class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                                                                name</label>
                                                </div>
                                                <svg id="thirdLock" class="lockIcon" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                     style="width: 3em">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                                <svg id="thirdUnlock" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="unlockIcon"
                                                     style="width: 3em">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                                                </svg>
                                                <input type="hidden" value="<?= $_SESSION['TOKEN'] ?? '' ?>"
                                                       name="token">
                                        </div>
                                        <button type="submit" name="editForm" style="margin-bottom: 10px; float: right"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Save changes
                                        </button>
                                </form>
                        </div>
                        <div id="changePass"
                             class="custom-box">
                                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center; gap: 20px">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Change
                                                Password</h3>
                                        <p class="mb-2">Before changing your password, have a pen and notepad ready
                                                :).</p>
                                        <p>If you are ready, click the button below</p>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px">
                                                <a href="http://notesystem.loc/reset/send-email" type="submit"
                                                   id="delete"
                                                   name="resetPassword"
                                                   class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                        Reset password
                                                </a>
                                        </div>
                                </div>
                        </div>
                        <div id="Delete Account"
                             class="custom-box">
                                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center; gap: 20px">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Delete
                                                account</h3>
                                        <p class="mb-2">Before deleting your account, <span
                                                        style="font-weight: 800; text-decoration: underline">ask yourself if yourself
                                                        several
                                                        times</span> are you ready to do this.</p>
                                        <p>If so, click the button bellow and follow the instructions.</p>
                                        <div style="display: flex; justify-content: space-between">
                                                <button onclick="openModal()" type="submit" id="delete"
                                                        name="generateCode"
                                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                        Delete my account
                                                </button>
                                        </div>
                                        <div id="myModal" class="modal">
                                                <form class="form" action="" method="post" name="deleteForm">
                                                        <div class="modal-content">
                                                                <span class="close"
                                                                      onclick="closeModal()">&times;</span>
                                                                <div style="display: flex; justify-content: center; flex-direction: column;">
                                                                        <p style="font-weight: bold; font-size: 20px; color: #1f2937">
                                                                                Are you
                                                                                sure you want to
                                                                                delete
                                                                                your account?</p>
                                                                        <p style="color: #1f2937">Please write this
                                                                                below</p>
                                                                        <div style="align-items: center">
                                                                                <label for="small-input" id="checkCode"
                                                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-black"></label>
                                                                                <input type="text" id="small-input"
                                                                                       name="code"
                                                                                       class="block w-full p-2 mb-5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                        </div>
                                                                        <button type="submit" name="delete"
                                                                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                                                I agree to delete my account
                                                                        </button>
                                                                </div>
                                                        </div>
                                                        <input type="hidden" value="<?= $_SESSION['TOKEN'] ?? '' ?>"
                                                               name="token">
                                                </form>
                                        </div>
                                </div>
                        </div>
                </div>
                <div style="margin-left: 25%; margin-right: 25%;">
                    <?php if ($errors): ?>
                            <div class="flex items-center p-4 mt-5 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                 role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                         viewBox="0 0 20 20">
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
</main>
</body>
</html>

