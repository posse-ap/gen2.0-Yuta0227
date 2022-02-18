let myNodeList = document.querySelectorAll('div');  //ノードリスト
let myHTMLCollection = document.getElementsByClassName('bom'); //HTMLコレクション

let newNode = document.createElement('div'); 
document.body.appendChild(newNode); //新しく<div class="bom"></div>を追加する
let allNode= document.getElementsByTagName('div');
// newNode.classList.add('bom');
for(let i=0;i<=2;i++){
    allNode[i].classList.add('bom');
}
console.log(allNode);

console.log(myNodeList.length); //戻り値 2
console.log(myHTMLCollection.length); //戻り値 3