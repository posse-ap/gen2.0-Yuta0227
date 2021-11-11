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
})
var hourBargraphCtx = document.getElementById("hour-bargraph").getContext('2d');
var gradient = hourBargraphCtx.createLinearGradient(15,0, 15, 300);
//今はバーグラフの左上を基準にしたのグラデーション。各バーを基準にしたグラデーション。数値が12じゃないときグラデーション崩れる
gradient.addColorStop(0, '#137DC4');
gradient.addColorStop(0.9, '#38C7F9');

var myChart = new Chart(hourBargraphCtx, {
    type: "bar",    // ★必須　グラフの種類
    data: {
        labels: ["2", "4", "6", "8", "10", "12", "14", "16", "18", "20", "22", "24", "26", "28", "30"],  // Ｘ軸のラベル
        datasets: [
            {
                label: "Data",                            // 系列名
                data: [12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12],                 // ★必須　系列Ａのデータ
                backgroundColor: gradient,                  // 棒の塗りつぶし色
                borderColor: gradient,                         // 棒の枠線の色
                borderWidth: 1,                              // 枠線の太さ
            }
        ]
    },

    options: {                       // オプション
        responsive: true,  // canvasサイズ自動設定機能を使わない。HTMLで指定したサイズに固定
        title: {                           // タイトル
            display: false,                     // 表示設定
            fontSize: 18,                      // フォントサイズ
            fontFamily: "sans-serif",
            text: 'タイトル'                   // タイトルのラベル
        },
        legend: {                          // 凡例
            display: false                     // 表示の有無
            // position: 'bottom'              // 表示位置
        },
        scales: {                          // 軸設定
            xAxes: [                           // Ｘ軸設定
                {
                    display: true,                // 表示の有無
                    barPercentage: 0.8,           // カテゴリ幅に対する棒の幅の割合
                    //categoryPercentage: 0.8,    // 複数棒のスケールに対する幅の割合
                    scaleLabel: {                 // 軸ラベル
                        display: false,                // 表示設定
                        labelString: '横軸ラベル',    // ラベル
                        fontColor: "#97b9d1",             // 文字の色
                        fontSize: 16                  // フォントサイズ
                    },
                    gridLines: {                   // 補助線
                        display: false               // 補助線なし
                    },
                    ticks: {                      // 目盛り
                        fontColor: "#97b9d1",             // 目盛りの色
                        fontSize: 14                  // フォントサイズ
                    },
                }
            ],
            yAxes: [                           // Ｙ軸設定
                {
                    display: true,                 // 表示の有無
                    scaleLabel: {                  // 軸ラベル
                        display: false,                 // 表示の有無
                        labelString: '縦軸ラベル',     // ラベル
                        fontFamily: "sans-serif",      // フォントファミリー
                        fontColor: "#97b9d1",             // 文字の色
                        fontSize: 16                   // フォントサイズ
                    },
                    gridLines: {                   // 補助線
                        display: false,            // 補助線なし
                        color: "rgba(0, 0, 255, 0.2)", // 補助線の色
                        zeroLineColor: "black"         // y=0（Ｘ軸の色）
                    },
                    ticks: {                       // 目盛り
                        min: 0,                        // 最小値
                        max: 12,                       // 最大値
                        stepSize: 2,                   // 軸間隔
                        fontColor: "#97b9d1",             // 目盛りの色
                        fontSize: 14                   // フォントサイズ
                    },
                }
            ],
        },
        layout: {                          // 全体のレイアウト
            padding: {                         // 余白
                left: 0,
                right: 0,
                top: 50,
                bottom: 0
            }
        },
        plugins:{
            labels:{
                display:false,
                render:'percentage',
                fontColor:'white',
                fontSize:20
            }
        },
    }
});



//学習言語と学習コンテンツのチャート
var language = document.getElementById('language-chart-doughnut');
var myLanguageChart = new Chart(language, {
    type: 'doughnut',
    data: {
        labels: ['Javascript', 'CSS', 'PHP', 'HTML', 'Lavarel', 'SQL', 'SHELL', '情報システム基礎知識（その他）'],
        datasets: [{
            data: [10, 20, 20, 10, 10, 10, 10, 10],
            backgroundColor: ['#0345EC', '#0F71BD', '#20BDDE', '#3CCEFE', '#B29EF3', '#6D46EC', '#4A17EF', '#3105C0'],
            weight: 100,
        }],
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: '割合'
        },
        plugins: {
            labels: {
                render: 'percentage',
                fontColor: 'white',
                fontSize: 20
            }
        }
    }
});
var material = document.getElementById('material-chart-doughnut');
var myMaterialChart = new Chart(material, {
    type: 'doughnut',
    data: {
        labels: ['ドットインストール', 'N予備校', 'POSSE課題'],
        datasets: [{
            data: [10, 20, 70],
            backgroundColor: ['#0345EC', '#0F71BD', '#20BDDE'],
            weight: 100,
        }],
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: true,
            text: '割合'
        },
        plugins: {
            labels: {
                render: 'percentage',
                fontColor: 'white',
                fontSize: 20
            }
        }
    }
});