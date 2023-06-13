function ShowNextQuestion() {
    var firstAnswer = document.querySelector('input[name="experience"]:checked').value;
    
    if (firstAnswer === "Yes") {
        document.getElementById("second_question").style.display = "block";
    }
    else {
        document.getElementById("second_question").style.display = "none";
    }
}


function ResetSecondQuestion() {
    var secondQuestion = document.getElementById("second_question");
    secondQuestion.style.display = "none";
}


var counter = 2;
function addTextBox() {
    var textBoxContainer = document.getElementById("text_box_container");
    var textBoxSet = document.createElement("div");
    textBoxSet.innerHTML = `
        言語${counter}:
        <input type="text" name="lang[]" placeholder="言語${counter}">
        <input type="text" name="year[]" placeholder="言語${counter}の使用年数">
        <input type="text" name="level[]" placeholder="言語${counter}の習得レベル">
        <button type="button" onclick="removeTextBox(this)">削除</button>
      `;
    textBoxContainer.appendChild(textBoxSet);
    counter++;
}

function removeTextBox(button) {
    var textBox = button.previousElementSibling; // 削除ボタンの前の要素（テキストボックス）を取得
    textBox.parentNode.remove(); // 親要素（テキストボックスと削除ボタンを含む要素）を削除
}
