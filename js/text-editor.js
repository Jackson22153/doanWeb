
let optionSection = document.getElementById('options-section');
let optionsButtons = document.querySelectorAll(".option-button");
let advancedOptionButton = document.querySelectorAll(".adv-option-button");
let hiddenButtons = document.querySelectorAll('.hidden-button');

let fontName = document.getElementById("fontName");
let fontSizeRef = document.getElementById("fontSize");
let writingArea = document.getElementById("text-input");
let linkButton = document.getElementById("createLink");
let alignButtons = document.querySelectorAll(".align");
let spacingButtons = document.querySelectorAll(".spacing");
let formatButtons = document.querySelectorAll(".format");
let scriptButtons = document.querySelectorAll(".script");
let dynamicButtons = document.querySelectorAll('.dynamic-button');
let orderButtons = document.querySelectorAll('.order-button');

let nextButton = document.getElementById('next-button');
let selectButtons = document.getElementsByClassName('select-button');
let toggleModalButtons = document.querySelectorAll('.toggle-button');
let textEditorSubmit = document.getElementById('text-editor-submit');
// var confirmModalForm = document.querySelector('confirm-modal-form');

let modalOverlay = document.querySelector('.modal');
let inputPostImage = document.getElementById('input-post-image');
let postThumbnailImage = document.getElementById('post-thumbnail-image');
let dotEnvPath = document.getElementById("current-path");
console.log(dotEnvPath)
// confirm data toggle and add data
// function confirmModalFunc(){
//   // toggle confirm modal
//   var innerConfirmModal = confirmModalForm.querySelector('.confirm-modal');
//   innerConfirmModal.classList.toggle('d-block');
//   // add data to confirm modal
// }
// // trigger confirm modal
// textEditorSubmit.addEventListener('click', ()=>{
//   confirmModalFunc()
// })


// modal
let imageUrl = null;
// upload image from system
async function createNewImage(content, extension){
    uploadImage(content, extension, dotEnvPath.getAttribute('path'))
    .then(response => response.json())
    .then(data => {
        // console.log(data);
        const content = data.content;
        imageUrl = content.download_url;
        postThumbnailImage.setAttribute('src', imageUrl);
    })
    .catch((error) => console.error('Error:', error));
}
// selected post image from system
inputPostImage.addEventListener('change', (event)=>{
  if(event.target.files && event.target.files[0]){   
      const file = event.target.files[0];
      var reader = new FileReader();

      reader.onloadend = function() {
          var content = reader.result;

          const fileName = file.name;
          const extension = fileName.split('.').pop();

          createNewImage(content, extension);
      }
      reader.readAsDataURL(file);
  }
})
// toggle modal
toggleModalButtons.forEach((button)=>{
  button.addEventListener('click', ()=>{
    modalOverlay.classList.toggle('d-block');
  })
})

// insert image from uploadting or pasting
function insertImage(imgSrc, currLine){
    const newDiv =createImg(imgSrc)
    // console.log(newDiv)
    if(currLine.tagName === 'IMG'){
      const divLine =  currLine.closest('div.line');
      writingArea.insertBefore(newDiv, divLine);
    }else if(currLine.tagName !== 'DIV' && !currLine.classList.contains('line') ||
      currLine.innerHTML !== ''){
        // not a div line or have text inside
      createLine(newDiv.innerHTML);
    }else {
      // a div line with no text
      currLine.innerHTML = newDiv.innerHTML;
    }
}

// image upload button event
let imageUploadBtn = document.getElementById("image-upload-button");
let imageUploadIpt = document.getElementById("image-upload-input");

imageUploadBtn.addEventListener('click', function(){
  var selection = window.getSelection();
  if(selection.rangeCount){
    var range = selection.getRangeAt(0);
    const node = range.commonAncestorContainer;
    // console.log(node.classList)
    selection.removeAllRanges();
    if(node.nodeType === 1 || node.nodeType === 3){
      // console.log(node)
      node.focus();
      imageUploadIpt.click();
      // node.focus();
    }
  }
})
imageUploadIpt.addEventListener('change', function(event){
  event.preventDefault()
  var file = event.target.files[0];

  const node =writingArea.querySelector(".line--selected");

  if(file){
    var reader = new FileReader();
    reader.onload = function(e){
      let imgSrc = e.target.result;

      const fileName = file.name;
      
      const extension = fileName.split('.').pop();

      uploadImage(imgSrc, extension, dotEnvPath.getAttribute('path'))
      .then(res =>res.json())
      .then(data =>{        
        const content = data.content;
        // get uploaded image from github
        imgSrc = content.download_url;

        const currLine = node;
        insertImage(imgSrc, currLine);
        // const newDiv =createImg(imgSrc);
        // if(currLine.tagName === 'IMG'){
        //   const divLine =  currLine.closest('div.line');
        //   writingArea.insertBefore(newDiv, divLine);
        // }else {
        //   currLine.innerHTML = newDiv.innerHTML;
        // }
        imageUploadIpt.value = null;
      })

    }
    reader.readAsDataURL(file);
  }
})

// scroll into view
function scrollToBottom(delta){
  writingArea.scrollTop = 1000 + delta;
}
// sub
function getCaretPosition(editableDiv) {
  var caretPos = 0, sel, range;
  if (window.getSelection) {
    sel = window.getSelection();
    if (sel.rangeCount) {
      range = sel.getRangeAt(0);
      if (range.commonAncestorContainer.parentNode == editableDiv) {
        caretPos = range.endOffset;
      }
    }
  } else if (document.selection && document.selection.createRange) {
    range = document.selection.createRange();
    if (range.parentElement() == editableDiv) {
      var tempEl = document.createElement("span");
      editableDiv.insertBefore(tempEl, editableDiv.firstChild);
      var tempRange = range.duplicate();
      tempRange.moveToElementText(tempEl);
      tempRange.setEndPoint("EndToEnd", range);
      caretPos = tempRange.text.length;
    }
  }
  return caretPos;
}
// select new line
function selectLine(selectELe){
  // Create a range and set its position to the start of the new div
  var range = document.createRange();
  range.setStart(selectELe, 0);
  range.setEnd(selectELe, 0);

  // Get the selection and remove all ranges
  var selection = window.getSelection();
  selection.removeAllRanges();

  // Add the new range to the selection
  selection.addRange(range);
}
// insert new line
function createLine(newContent){
  // Create a new div
  var div = document.createElement('div');
  div.classList.add('line')
  div.contentEditable = 'true';
  // insert content
  div.innerHTML = newContent? newContent: '';
  // div.innerHTML = newContent? newContent: '&nbsp;';
  // Get the current div
  var currentDiv = document.activeElement;

  // Insert the new div after the current one
  if (currentDiv.nextSibling) {
    writingArea.insertBefore(div, currentDiv.nextSibling);
  } else {
    writingArea.appendChild(div);
  }
  selectLine(div);
}
// focus previous line
function focusPreLine(currentLine){
  var selection = window.getSelection();
  var range = document.createRange();
  range.selectNodeContents(currentLine.previousElementSibling);
  range.collapse(false);
  selection.removeAllRanges();
  selection.addRange(range)
  currentLine.previousElementSibling.focus();
}
// focus next line
function focusNextLine(currentLine){
  var selection = window.getSelection();
  var range = document.createRange();
  range.selectNodeContents(currentLine.nextElementSibling);
  range.collapse(false);
  selection.removeAllRanges();
  selection.addRange(range)
  currentLine.nextElementSibling.focus();
}
// // insert image
// create img line
function createImg(imgSrc){
  // create a img element
  var img = document.createElement('img');
  // img.classList.add('img-size--normal')
  img.src = imgSrc;
  // insert new link
  var newDiv = document.createElement('div')
  newDiv.classList.add('line');
  newDiv.contentEditable = true;
  newDiv.appendChild(img)
  // // create img properties
  // const imgProperties = new ImgProperties();
  // imgProperties.classList.add('img-properties--hidden')
  // newDiv.appendChild(imgProperties)

  return newDiv
}

// check style of a current line/node
function checkSentenceStyle(currentLine){
  var styles = window.getComputedStyle(currentLine);
  var fontWeight = styles.fontWeight;
  var fontStyle = styles.fontStyle;
  var textDecorationLine = styles.textDecorationLine;
  var webkitTextDecorationsInEffect = styles.webkitTextDecorationsInEffect;
  var verticalAlign = styles.verticalAlign;
  var textDecorationLine = styles.textDecorationLine;
  
  // console.log(styles)

  var isBold = fontWeight >= 700 ? true : false;
  var isItalic = fontStyle === 'italic' ? true : false;
  // isUnderline
  var isUnderline1 = textDecorationLine === 'underline' ? true : false;
  var isUnderline2 = webkitTextDecorationsInEffect.includes('underline');
  var isUnderline = isUnderline1 || isUnderline2;

  var isSup = verticalAlign === 'super' ? true : false;
  var isSub = verticalAlign === 'sub' ? true : false;
  // isStrikeThrough
  // var isStrikeThrough1 = textDecorationLine === 'line-through' ? true : false;
  // var isStrikeThrough2 = webkitTextDecorationsInEffect.includes('line-through');
  // var isStrikeThrough = isStrikeThrough1 || isStrikeThrough2;
  
  return {
    'bold': isBold,
    'italic': isItalic,
    'underline': isUnderline,
    'superscript': isSup,
    'subscript': isSub,
    // 'strikethrough': isStrikeThrough
  }
}
// set selection style status for each dynamic buttons
function checkSelectionStyle() {
  var sel = window.getSelection();
  var ele = sel.anchorNode;
  if(ele && ele.nodeType === 3){
    ele = ele.parentNode;
    const styles = checkSentenceStyle(ele)
    Array.from(dynamicButtons).forEach(btn => {
      if(styles[btn.id]){
        btn.classList.add('active');
      }else {
        btn.classList.remove('active');
      }
    })
  } 
}

// event
// click event
// selected line
let selectedLine = null;
// previous line
let preLine = null;
// left mouse checked
let leftMouse = false;

// writing area event
writingArea.addEventListener('click', (e)=>{
  const line = e.target.closest('.line');
  if(line){
    // remove previous selected img
    if(preLine && !(preLine.contains(e.target)|| preLine==line)){
      preLine.classList.remove('line--selected');
      const img = preLine.querySelector('.img--selected');
      // const imgProperties = preLine.querySelector('img-properties');
      // if(imgProperties) imgProperties.classList.add('img-properties--hidden');
      if(img) {
        img.classList.remove('img--selected');
      }
    }
    // set line--selected at a focus line
    selectedLine = line;
    line.classList.add('line--selected');

    if(e.target.tagName === 'IMG'){
      // insert current selected img
      const img = e.target
      img.classList.add('img--selected')
      // const imgProperties = line.querySelector('img-properties')
      // imgProperties.classList.remove('img-properties--hidden')
    }
    preLine = line;
  }
})
// mouse event
writingArea.addEventListener('mousedown', function(e){
  if(e.button === 0) leftMouse = true;
})
writingArea.addEventListener('mousemove', function(e){
  if(leftMouse){
    checkSelectionStyle()
  }
})
writingArea.addEventListener('mouseup', function(e){
  if(e.button === 0) leftMouse = false;
  checkSelectionStyle()
});
// press key event
// key up event
writingArea.addEventListener('keyup', checkSelectionStyle);
function checkLiLine(element){
  var temp = element;
  while(temp && !temp.classList.contains('line')){
    if(temp.tagName==='LI') return true;

    temp = temp.parentElement;
  }
  return false;
}
// event listener after pressing a key
writingArea.addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();

    highlighterRemover(dynamicButtons);
    var selection = window.getSelection();
    // insert new line
    if(selection.rangeCount > 0) {
      var range = selection.getRangeAt(0);
      var node = range.commonAncestorContainer;
      const element = node.nodeType === 3 ? node.parentNode : node;
      // insert new li for current li
      if(element.tagName === 'LI'){
        if(element.innerHTML.trim()){
          const parentEle = element.closest('ul') || element.closest('ol');
          if(parentEle){
            var li = document.createElement('li');
            // Insert the new div after the current one
            if (element.nextSibling) {
              parentEle.insertBefore(li, element.nextSibling);
            } else {
              parentEle.appendChild(li);
            }
            selectLine(li)
          }
        }else{
          element.remove();
          createLine('')
        }
      }else{
        var endRange = range.cloneRange(); // Create a copy of the range
        endRange.selectNodeContents(selection.focusNode); // Select all contents
        endRange.setStart(range.endContainer, range.endOffset); // Set start at original range end
        const newLineText =endRange.toString(); // Get the text
        endRange.deleteContents(); //remove all selected content
        // create new line for selected text
        createLine(newLineText)
      }
    }
    scrollToBottom(20);
    // console.log(event.view)
  }
  else if(event.key === 'Backspace'){
    var currentDiv = document.activeElement;
    if(currentDiv.textContent.trim() === ''){
      event.preventDefault();
      var numberOfLines = writingArea.getElementsByTagName('div').length;
      var prevDiv = currentDiv.previousElementSibling;
      if(prevDiv && numberOfLines > 1){
        focusPreLine(currentDiv)
        writingArea.removeChild(currentDiv);
      }
    }
  }
  else if(event.key === 'ArrowUp'){   
    var selection = window.getSelection();
    if(selection.rangeCount > 0) {
      event.preventDefault();
      var range = selection.getRangeAt(0);
      var node = range.commonAncestorContainer;
      const element = node.nodeType === 3 ? node.parentNode : node;
      focusPreLine(element);
    }
  }
  else if(event.key === 'ArrowDown'){
    var selection = window.getSelection();
    if(selection.rangeCount > 0) {
      event.preventDefault();
      var range = selection.getRangeAt(0);
      var node = range.commonAncestorContainer;
      const element = node.nodeType === 3 ? node.parentNode : node;
      focusNextLine(element)
    }
  }
  else if (event.key === 'ArrowLeft') {

  }
  else if (event.key === 'ArrowRight') {
  }
  else if(event.key === 'Tab'){
    var selection = window.getSelection();
    if(selection.rangeCount > 0) {
      event.preventDefault();
      var range = selection.getRangeAt(0);
      // var node = range.commonAncestorContainer;
      // const element = node.nodeType === 3 ? node.parentNode : node;

      var spaces = document.createTextNode('\u00a0\u00a0\u00a0');

      // Insert the spaces at the cursor position
      range.insertNode(spaces);

      // Move the cursor after the inserted spaces
      range.setStartAfter(spaces);
      range.setEndAfter(spaces);
      selection.removeAllRanges();
      selection.addRange(range);
    }
  }
});
// paste event
writingArea.addEventListener('paste', (event)=>{
  var items = (event.clipboardData || event.originalEvent.clipboardData).items;
  var item = items[0];
  // upload image file
  if(item.kind === 'file') {
    event.preventDefault()

    const currLine = event.target;

    // paste image from clipboard
    if(!(currLine.className.includes('title') && currLine.tagName === 'H1')){
      var blob = item.getAsFile();
      var reader = new FileReader();
      reader.onload = async function(e) {
        e.preventDefault()
        // get image base64
        let imgSrc = e.target.result;
        await uploadImage(imgSrc, 'png', dotEnvPath.getAttribute('path'))
        .then(res => res.json())
        .then(data => {
          // console.log(data);
          const content = data.content;
          imgSrc = content.download_url;
          insertImage(imgSrc, currLine);
        })
        .catch((error) => console.error('Error:', error));

      };
      reader.readAsDataURL(blob);
    }
  }else if(item.kind === 'string'){
    // stop default event
    event.stopPropagation();
    event.preventDefault();

    // Get pasted data via clipboard API
    var clipboardData = event.clipboardData || window.Clipboard;
    var pastedData = clipboardData.getData('Text');
    // replace all \n
    // pastedData = pastedData.replaceAll('\n','');
    // get current line
    const line = document.activeElement;
    // Do whatever with pasteddata
    // line.innerHTML=pastedData;
    if(line.tagName !== 'DIV' && !line.classList.contains('line') ||
      line.innerHTML !== ''){
        // not a div line or have text inside
      createLine(pastedData);

    }else {
      // a div line with no text
      line.innerHTML = pastedData;
      // Create a new range and selection
      var range = document.createRange();
      var sel = window.getSelection();
  
      // Set the range to the end of the div
      range.setStart(line, line.childNodes.length);
      range.collapse(true);
  
      // Clear the selection and add the new range
      sel.removeAllRanges();
      sel.addRange(range);
    }
  }
});

// hidden button
hiddenButtons.forEach((button) =>{
  // console.log(button)
  button.addEventListener('click', ()=>{
    optionSection.classList.toggle('d-none');
  })
})
// closeHiddenButton.addEventListener('click', ()=>{
// })

//List of fontlist
let fontList = [
  "Arial",
  "Verdana",
  "Times New Roman",
  "Garamond",
  "Georgia",
  "Courier New",
  "cursive",
];

//Initial Settings
const initializer = () => {
  //function calls for highlighting buttons
  //No highlights for link, unlink,lists, undo,redo since they are one time operations
  // highlighter(alignButtons, true);
  highlighter(spacingButtons, true);
  highlighter(formatButtons, true);
  highlighter(scriptButtons, true);
  // highlighter(dynamicButtons, true);


  //create options for font names
  fontList.map((value) => {
    let option = document.createElement("option");
    option.value = value;
    option.innerHTML = value;
    fontName.appendChild(option);
  });

  //fontSize allows only till 7
  for (let i = 1; i <= 7; i++) {
    let option = document.createElement("option");
    option.value = i;
    option.innerHTML = i;
    fontSizeRef.appendChild(option);
  }

  //default size
  fontSizeRef.value = 3;
};

//main logic
const modifyText = (command, defaultUi, value) => {
  //execCommand executes command on selected text
  document.execCommand(command, defaultUi, value);
};

//For basic operations which don't need value parameter
optionsButtons.forEach((button) => {
  button.addEventListener("click", () => {
    // console.log(button.id)
    modifyText(button.id, false, null);
  });
});

//options that require value parameter (e.g colors, fonts)
advancedOptionButton.forEach((button) => {
  button.addEventListener("change", () => {
    modifyText(button.id, false, button.value);
  });
});

//link
linkButton.addEventListener("click", () => {
  let userLink = prompt("Enter a URL");
  //if link has http then pass directly else add https
  if (/http/i.test(userLink)) {
    modifyText(linkButton.id, false, userLink);
  } else {
    userLink = "http://" + userLink;
    modifyText(linkButton.id, false, userLink);
  }
});

//Highlight clicked button
const highlighter = (className, needsRemoval) => {
  className.forEach((button) => {
    button.addEventListener("click", () => {

      var sel = window.getSelection();
      var ele = sel.anchorNode;
      if(ele.nodeType === 3){
        // div element with text
        var sel = window.getSelection();
        if(sel.toString().length>0){
          // select at least 1 letter
          ele = ele.parentNode;
          var styles = checkSentenceStyle(ele);
          if(styles[button.id]){
            button.classList.add('active');
          }else 
          {
            button.classList.remove('active');
          }
        }else{
          // not select any letter
          ele = ele.parentNode;
          // console.log(ele)
          var styles = checkSentenceStyle(ele);
          // console.log(styles)
          if(!styles[button.id]){
            button.classList.add('active');
          }else 
          {
            button.classList.remove('active');
          }
          ele =ele.closest('.line');
          ele.focus();
        }        
        // console.log("this is a text")
      }
      else {
        // div element without text
        var status = button.classList.contains('active');
        if(status) button.classList.remove('active');
        else button.classList.add('active')
        ele.focus();
      }
    });
  });
};

const highlighterRemover = (className) => {
  className.forEach((button) => {
    button.classList.remove("active");
  });
};

window.onload = initializer();