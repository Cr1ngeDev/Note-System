document.addEventListener('DOMContentLoaded', function () {
    const lockIcon1 = document.getElementById('firstLock');
    const unLock1 = document.getElementById('firstUnlock');
    const lockIcon3 = document.getElementById('thirdLock');
    const unLock3 = document.getElementById('thirdUnlock');

    function toggleIcons(event) {
        const clickedIcon = event.currentTarget;

        switch (clickedIcon) {
            case lockIcon1:
                toggleIcon(lockIcon1, unLock1);
                document.getElementById('email').disabled = false;
                break;
            case lockIcon3:
                toggleIcon(lockIcon3, unLock3);
                document.getElementById('first_name').disabled = false;
                document.getElementById('last_name').disabled = false;
                break;
            case unLock1:
                toggleIcon(unLock1, lockIcon1);
                document.getElementById('email').disabled = true;
                break;
            case unLock3:
                toggleIcon(unLock3, lockIcon3);
                document.getElementById('first_name').disabled = true;
                document.getElementById('last_name').disabled = true;
                break;
        }
    }

    function toggleIcon(lockIcon, unlockIcon) {
        lockIcon.style.display = 'none';
        unlockIcon.style.display = 'block';
    }

    lockIcon1.addEventListener('click', toggleIcons);
    lockIcon3.addEventListener('click', toggleIcons);
    unLock1.addEventListener('click', toggleIcons);
    unLock3.addEventListener('click', toggleIcons);
});

// для модального окна

function openModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    modal.style.animation = "fadeIn 0.5s";
    fetchData();
}
// Закрыть модальное окно
function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
function showDropdown() {
    document.getElementById("Dropdown").classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
function fetchData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'app/Kernel/Services/getCheckCode.php', true);
    var labelElement = document.getElementById('checkCode');
    xhr.onreadystatechange = function (){
        if(xhr.readyState === 4 && xhr.status === 200){
            if(labelElement){
                var regex = /"(.*?)"/;
                var result = xhr.responseText.match(regex);
                labelElement.innerHTML = result[1];
            }
        }
    }
    var codeValue = labelElement.innerHTML;
    xhr.send('code=' + encodeURIComponent(codeValue));
}