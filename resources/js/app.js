require('./bootstrap');

let btn = document.querySelector('#leaveCom').addEventListener('click', openCommentForm);
function openCommentForm(e) {
    e.preventDefault();
    let form = document.querySelector('#comment');
    form.classList.toggle('d-none');
    //form.addEventListener('submit', )
}