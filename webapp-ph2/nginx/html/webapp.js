const headerButton = document.getElementById('header-button');
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
const month=document.getElementById('month');
const year=document.getElementById('year');
var now=new Date();
var innerhtmlMonth=month.innerHTML;
var innerhtmlYear=year.innerHTML;
var submitData=[];
var checkedContents=[];
var checkedLanguage;
//ラベルクリック時checked==trueならば青色をつける
for (let i = 1; i <= 11; i++) {
    document.getElementById(`label${i}`).addEventListener('click', function () {
        if (document.getElementById(`checkbox${i}`).checked == true) {
            document.getElementById(`my-checkbox${i}`).classList.add('color-blue');
            document.getElementById(`label${i}`).style.backgroundColor = "#e7f5ff";
        } else if (document.getElementById(`checkbox${i}`).checked == false) {
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
            document.getElementById(`label${i}`).style.backgroundColor = "rgb(215,215,215)";
        }
    })
}
document.getElementById(`label12`).addEventListener('click', function () {
    if (document.getElementById(`checkbox12`).checked == true) {
        document.getElementById(`my-checkbox12`).classList.add('color-blue');
    } else if (document.getElementById(`checkbox12`).checked == false) {
        document.getElementById(`my-checkbox12`).classList.remove('color-blue');
    }
})
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
    window.location.href=`http://localhost:8080/webapp.php?month=${innerhtmlMonth-0}&year=${innerhtmlYear-0}`;
});
//ツイートボタン押してるかつ投稿ボタン押してるとツイートするロード画面始まる
//ロード完了と出てから消える入力内容も消える
function tweetPage() {
    if (document.getElementById('checkbox12').checked) {
        let comment = document.getElementById('comment').value;
        window.open("https://twitter.com/intent/tweet?text=" + comment);
    }
}
function startLoading() {
    animationFilter.removeAttribute("hidden");
    animationText.innerText = "Loading ...";
}
function hideLoading() {
    animationFilter.setAttribute("hidden", "")
}
function stopLoading() {
    animationText.innerText = "Loading Complete!";
    tweetPage();
    setTimeout(hideLoading, 1000);
    comment.value = "";
    time.value = "";
    date.value = "";
    for (let i = 1; i <= 12; i++) {
        if (document.getElementById(`checkbox${i}`).checked) {
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
            document.getElementById(`checkbox${i}`).checked = false;
        }
    }
    fullOverlay.setAttribute("hidden", "");
}
pcPost.addEventListener('click', function () {
//データ送信
    setTimeout(startLoading, 1000);
    setTimeout(stopLoading, 3000);
    // submitData={
    //     date:date.value,
    //     month:date.value,
    //     year:date.value,
    //     content:checkedContents,
    //     language:checkedLanguage,
    //     hours:time.value,
    //     comment:comment.value,
    //     share:document.getElementById('checkbox12').checked
    // }
    console.log(date.value);
});
//スマホで画面下部のボタン押すとオーバーレイ表示する
smartphoneButton.addEventListener('click', function () {
    fullOverlay.removeAttribute('hidden')
    smartphoneButton.id = "smartphone-post-button";
    //IDが変わったボタンを押すとロード画面に入る
    const smartphonePostButton = document.getElementById('smartphone-post-button');
    smartphonePostButton.addEventListener('click', function () {
        setTimeout(startLoading, 1000);
        setTimeout(stopLoading, 3000);
        // submitData={
        //     date:date.value,
        //     month:date.value,
        //     year:date.value,
        //     content:checkedContents,
        //     language:checkedLanguage,
        //     hours:time.value,
        //     comment:comment.value,
        //     share:document.getElementById('checkbox12').checked
        // }
        smartphonePostButton.id = "smartphoneButton";
    })
    //PCでやると一度ボタンクリックした後カーソル動かしただけでクリックした判定になってしまう。だけどスマホなら平気なのかも
});
previousMonth.addEventListener('click', function () {
    innerhtmlMonth--;
    if (innerhtmlMonth == 0) {
        innerhtmlMonth = innerhtmlMonth + 12;
        innerhtmlYear--;
    };
    window.location.href=`http://localhost:8080/webapp.php?month=${innerhtmlMonth-0}&year=${innerhtmlYear-0}`;
});
if(innerhtmlMonth-0>=now.getMonth()+1){
    nextMonth.style.display='none';
    nextMonth.style.pointerEvents='none';
}
nextMonth.addEventListener('click', function () {
    innerhtmlMonth++;
    if (innerhtmlMonth == 13) {
        innerhtmlMonth = innerhtmlMonth - 12;
        innerhtmlYear++;
    };
    window.location.href=`http://localhost:8080/webapp.php?month=${innerhtmlMonth-0}&year=${innerhtmlYear-0}`;
});
