function kaitouSeisei(item){
 if(item["id"]==5){
    document.getElementById("number_area").innerHTML="自信度アンケート"
 }
 else{
    document.getElementById("number_area").innerHTML=(item["id"]+1)+"問目";
 }
 document.getElementById("question_area").innerHTML=item["question"];  
 let choices=item["choices"];
 let choice_area=document.getElementById("choice_area");
 for(let c=0;c<choices.length;c++){
   choice_area.appendChild(sentakushi(c,choices[c]));
 }   
}
function sentakushi(c, choice){
    let input = document.createElement("input");
    input.type = "radio"; //ラジオボタン要素
    input.name = "choices"; //$_POST["choices"]に対応
    input.id ="choice" + (c+1);
    input.value = c + 1; //正誤判定の際に用いる値
    input.classList.add("form-check-input");
    input.required=true;
    
    let label = document.createElement("label");
    label.setAttribute("for","choice"+(c+1));
    label.innerHTML = choice; //選択肢文要素
    label.classList.add("form-check-label");
    
    let div = document.createElement("div");
    div.classList.add("form-check");
    div.appendChild(input); //選択肢エリアにラジオボタン追加
    div.appendChild(label); //選択肢文を追加
    return div;
}