const headerButton = document.getElementById('header-button');
const smartphoneButton = document.getElementById('smartphone-button');
const fullOverlay = document.getElementById('fullOverlay');
const exit = document.getElementById('exit');
const time = document.getElementById('time');
const date = document.getElementById('date');
const pcPost = document.getElementById('post-button');
const animationFilter = document.getElementById('animation-filter');
const animationText = document.getElementById('animation-text')
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

    setTimeout(startLoading, 1000);
    setTimeout(stopLoading, 3000);
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
        smartphonePostButton.id = "smartphoneButton";
    })
    //PCでやると一度ボタンクリックした後カーソル動かしただけでクリックした判定になってしまう。だけどスマホなら平気なのかも
});
const previousMonth = document.getElementById('previous-month');
const nextMonth = document.getElementById('next-month');
const yearMonth = document.getElementById('year-month');
// const today= test;
// var todayDate;
// var todayMonth;
// var todayYear;
// var paramArray;
// const test = new Date();
// const todayDate= test.getDate();
// const todayMonth = test.getMonth()+1;
// const todayYear = test.getFullYear();
// const request={
//     date:todayDate,
//     month:todayMonth,
//     year:todayYear
// };

// window.onload=function(){
//     yearMonth.innerHTML= `${todayYear}年${todayMonth}月`;
//     fetch('request.php', { // 第1引数に送り先
//         method: 'POST', // メソッド指定
//         headers: { 'Content-Type': 'application/json' }, // jsonを指定
//         body: JSON.stringify(request) // json形式に変換して添付
//     })
//     .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
//     .then(res => {
//         console.log(res); // 返ってきたデータ
//     });
// }
const month=document.getElementById('month');
const year=document.getElementById('year');
todayMonth=month.innerHTML;
todayYear=year.innerHTML;
previousMonth.addEventListener('click', function () {
    todayMonth--;
    if (todayMonth == 0) {
        todayMonth = todayMonth + 12;
        todayYear--;
    };
    window.location.href=`http://localhost:8080/webapp.php?month=${todayMonth-0}&year=${todayYear-0}`;
});
nextMonth.addEventListener('click', function () {
    todayMonth++;
    if (todayMonth == 13) {
        todayMonth = todayMonth - 12;
        todayYear++;
    };
    window.location.href=`http://localhost:8080/webapp.php?month=${todayMonth-0}&year=${todayYear-0}`;
});
