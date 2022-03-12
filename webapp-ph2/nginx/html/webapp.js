const headerPostButton = document.getElementById('header-post-button');
const headerDeleteButton = document.getElementById('header-delete-button');
const smartphoneButton = document.getElementById('smartphone-button');
const fullOverlay = document.getElementById('fullOverlay');
const exit = document.getElementById('exit');
const time = document.getElementById('time');
const date = document.getElementById('date');
const pcPost = document.getElementById('post-button');
const animationFilter = document.getElementById('animation-filter');
const animationText = document.getElementById('animation-text')
const previousMonth = document.getElementById('previous-month');
const nextMonth = document.getElementById('next-month');
const yearMonth = document.getElementById('year-month');
const month = document.getElementById('month');
const year = document.getElementById('year');
const postForm=document.getElementById('post-form');
const deleteForm=document.getElementById('delete-form');
var now = new Date();
var innerhtmlMonth = month.innerHTML;
var innerhtmlYear = year.innerHTML;
var chosenDate;
var chosenMonth;
var chosenYear;
var submitData = [];
var checkedContents = [];
var checkedLanguage;
var writtenHours;
var writtenComment;
var boolShare;
var tmp;
//ラベルクリック時checked==trueならば青色をつける
for (let i = 1; i <= 11; i++) {
    document.getElementById(`label${i}`).addEventListener('click', function () {
        if (i >= 4 && i <= 11 && document.getElementById(`checkbox${i}`).checked == false) {
            for(let tmp=4;tmp<=11;tmp++){
                //言語は一つしか選べないように
                document.getElementById(`checkbox${tmp}`).checked = false;
                document.getElementById(`my-checkbox${tmp}`).style.color = "black";
                document.getElementById(`label${tmp}`).style.backgroundColor = "rgb(215,215,215)";
            }
        }
        if (document.getElementById(`checkbox${i}`).checked == false) {
            document.getElementById(`my-checkbox${i}`).style.color = 'black';
            document.getElementById(`label${i}`).style.backgroundColor = "rgb(215,215,215)";
        } else if (document.getElementById(`checkbox${i}`).checked == true) {
            document.getElementById(`my-checkbox${i}`).style.color = "blue";
            document.getElementById(`label${i}`).style.backgroundColor = "#e7f5ff";
        }
    })
};
document.getElementById(`label12`).addEventListener('click', function () {
    if (document.getElementById(`checkbox12`).checked == true) {
        document.getElementById(`my-checkbox12`).style.color = "blue";
    } else if (document.getElementById(`checkbox12`).checked == false) {
        document.getElementById(`my-checkbox12`).style.color = "black";
    }
});
//右上の記録・投稿ボタン押すとオーバーレイ表示する
headerPostButton.addEventListener('click', function () {
    fullOverlay.removeAttribute('hidden');
    postForm.removeAttribute('hidden');
});
//右上の投稿削除
headerDeleteButton.addEventListener('click',function(){
    fullOverlay.removeAttribute('hidden');
    deleteForm.removeAttribute('hidden');
})
// for(let i=0;i<=4;i++){
//     document.getElementById(`delete-request-${i}`).addEventListener('click',function(){
//         deleteForm.addEventListener('submit',function(){
//             document.getElementById(`delete-status-${i}`).innerHTML='申請済み';
//         });
//     })
// }
//×ボタン押すとオーバーレイが消えると同時に入力内容リセットされる
exit.addEventListener('click', function () {
    fullOverlay.setAttribute('hidden', "");
    comment.value = "";
    time.value = "";
    reset();
    window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
});
//ツイートボタン押してるかつ投稿ボタン押してるとツイートするロード画面始まる
//ロード完了と出てから消える入力内容も消える
function tweetPage() {
    if (document.getElementById('checkbox12').checked) {
        let comment = document.getElementById('comment').value;
        window.open("https://twitter.com/intent/tweet?text=" + comment);
    }
};
function startLoading() {
    animationFilter.removeAttribute("hidden");
    animationText.innerText = "Loading ...";
};
function hideLoading() {
    animationFilter.setAttribute("hidden", "")
};
function stopLoading() {
    animationText.innerText = "Loading Complete!";
    tweetPage();
    setTimeout(hideLoading, 1000);
    comment.value = "";
    time.value = "";
    fullOverlay.setAttribute("hidden", "");
    reset();
};
function reset() {
    for (let i = 1; i <= 12; i++) {
        if (document.getElementById(`checkbox${i}`).checked) {
            document.getElementById(`my-checkbox${i}`).style.color = "black";
            document.getElementById(`label${i}`).style.backgroundColor = "rgb(215,215,215)"
            document.getElementById(`checkbox${i}`).checked = false;
        }
    }
};
pcPost.addEventListener('click', function () {
if(time.innerHTML!=''){
    startLoading();
    stopLoading();
    //データすぐ送られるのにアニメーション待つ必要ない
}
});
//スマホで画面下部のボタン押すとオーバーレイ表示する
smartphoneButton.addEventListener('click', function () {
    fullOverlay.removeAttribute('hidden');
    postForm.removeAttribute('hidden');
    smartphoneButton.id = "smartphone-post-button";
    //IDが変わったボタンを押すとロード画面に入る
    const smartphonePostButton = document.getElementById('smartphone-post-button');
    smartphonePostButton.addEventListener('click', function () {
        // sendData().then(startLoading()).then(stopLoading()).then(function(){
            // window.location.reload(true);
            if(time.innerHTML!=''){
                startLoading();
                stopLoading();
                smartphonePostButton.id="smartphoneButton";
            }
        // });
    });
    //PCでやると一度ボタンクリックした後カーソル動かしただけでクリックした判定になってしまう。だけどスマホなら平気なのかも
});
previousMonth.addEventListener('click', function () {
    innerhtmlMonth--;
    if (innerhtmlMonth == 0) {
        innerhtmlMonth = innerhtmlMonth + 12;
        innerhtmlYear--;
    };
    window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
});
if (innerhtmlMonth - 0 >= now.getMonth() + 1 && innerhtmlYear - 0 >= now.getFullYear()) {
    nextMonth.style.display = 'none';
    nextMonth.style.pointerEvents = 'none';
};
nextMonth.addEventListener('click', function () {
    innerhtmlMonth++;
    if (innerhtmlMonth == 13) {
        innerhtmlMonth = innerhtmlMonth - 12;
        innerhtmlYear++;
    };
    window.location.href = `http://localhost:8080/webapp.php?month=${innerhtmlMonth - 0}&year=${innerhtmlYear - 0}`;
});
