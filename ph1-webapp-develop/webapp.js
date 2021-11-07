const headerButton = document.getElementById('header-button');
const fullOverlay = document.getElementById('fullOverlay');
const exit = document.getElementById('exit');
const time = document.getElementById('time');
const date = document.getElementById('date');
const post = document.getElementById('post-button');
const animationFilter=document.getElementById('animation-filter');
const animationText=document.getElementById('animation-text')
//ラベルクリック時checked==trueならば青色をつける
for (let i = 1; i <= 12; i++) {
    document.getElementById(`label${i}`).addEventListener('click', function () {
        if (document.getElementById(`checkbox${i}`).checked == true) {
            document.getElementById(`my-checkbox${i}`).classList.add('color-blue');
        } else if (document.getElementById(`checkbox${i}`).checked == false) {
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
        }
    })
}
//右上の記録・投稿ボタン押すとオーバーレイ表示する
headerButton.addEventListener('click', function () {
    fullOverlay.removeAttribute('hidden');
})
//×ボタン押すとオーバーレイが消えると同時に入力内容リセットされる
exit.addEventListener('click', function () {
    fullOverlay.setAttribute('hidden', "");
    comment.value = "";
    time.value = "";
    date.value = "";
    for (let i = 1; i <= 12; i++) {
        if (document.getElementById(`checkbox${i}`).checked) {
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
            document.getElementById(`checkbox${i}`).checked = false;
        }
    }
});
//ツイートボタン押してるかつ投稿ボタン押してるとツイートするロード画面始まる
//ロード完了と出てから消える入力内容も消える
function tweetPage(){
    if (document.getElementById('checkbox12').checked) {
        let comment = document.getElementById('comment').value;
        window.open("https://twitter.com/intent/tweet?text=" + comment);
    }
}
function startLoading(){
    animationFilter.removeAttribute("hidden");
    animationText.innerText="Loading ...";
}
function hideLoading(){
    animationFilter.setAttribute("hidden","")
}
function stopLoading(){
    animationText.innerText="Loading Complete!";
    tweetPage();
    setTimeout(hideLoading,1000);
    comment.value = "";
    time.value = "";
    date.value = "";
    for (let i = 1; i <= 12; i++) {
        if (document.getElementById(`checkbox${i}`).checked) {
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
            document.getElementById(`checkbox${i}`).checked = false;
        }
    }
}
post.addEventListener('click', function () {
    
    setTimeout(startLoading,1000);
    setTimeout(stopLoading,3000);
    
});
