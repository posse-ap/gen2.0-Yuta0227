const headerButton=document.getElementById('header-button');
const fullOverlay=document.getElementById('fullOverlay');
const exit=document.getElementById('exit');
const comment=document.getElementById('comment');
const time=document.getElementById('time');
const date=document.getElementById('date');
//ラベルクリック時checked==trueならば青色をつける
for(let i=1;i<=12;i++){
    document.getElementById(`label${i}`).addEventListener('click',function(){
        if(document.getElementById(`checkbox${i}`).checked==true){
            document.getElementById(`my-checkbox${i}`).classList.add('color-blue');
        }else if(document.getElementById(`checkbox${i}`).checked==false){
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');  
        }
    })
}
//右上の記録・投稿ボタン押すとオーバーレイ表示する
headerButton.addEventListener('click',function(){
    fullOverlay.removeAttribute('hidden');
})
//×ボタン押すとオーバーレイが消えると同時に入力内容リセットされる
exit.addEventListener('click',function(){
    fullOverlay.setAttribute('hidden',"");
    comment.value="";
    time.value="";
    date.value="";
    for(let i=1;i<=12;i++){
        if(document.getElementById(`my-checkbox${i}`).classList.contains("color-blue")==true){
            document.getElementById(`my-checkbox${i}`).classList.remove('color-blue');
            document.getElementById(`checkbox${i}`).checked=false;
        }
    }
})

//ツイートボタン押してるかつ投稿ボタン押してるとツイートする
//                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" data-show-count="false">記録・投稿</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
