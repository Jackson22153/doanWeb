let textEditorForm = document.getElementById("text-editor");
// update post
let postContent = document.getElementById('text-input-hiden');



async function filterElement(line){
    const childEle = line.firstChild;
    if(childEle){
      // first child's tagname
      const tagName = childEle.tagName;
      if(!tagName){
        // text inside
        var div = document.createElement('div');
        if(line.style.cssText.length>0)
          div.style.cssText = line.style.cssText;
        div.innerHTML = line.innerHTML;
        line.replaceWith(div);
      }else{
        // text style inside
        if(tagName === 'B' || tagName === 'U' || tagName === 'I' || 
          tagName === 'SUB' || tagName === 'SUP' || tagName ==='FONT'){
  
          var div = document.createElement('div');
          if(line.style.cssText.length>0)
          div.style.cssText = line.style.cssText;
          div.innerHTML = line.innerHTML;
          line.replaceWith(div);
        }
        else{ 
          // other elements inside like img, ul, ol,...
          line.replaceWith(childEle)
        }
      }
    }else { 
      // no element or text inside - br
      var br = document.createElement('br');
      line.replaceWith(br);
    }
    return line;
}
function validate(writingArea){

    const lines = writingArea.querySelectorAll('div.line');

    lines.forEach((line) =>{
        line =filterElement(line);
    })
    var context = writingArea.innerHTML;
    context = context.replaceAll('contenteditable="true"', '');
    context = context.replaceAll('line--selected', '');
    context = context.replaceAll('data-placeholder="Enter text here"', '');
    context = context.replaceAll('img--selected"', '');
    context = context.replaceAll('id="null"', '');

    return context;
}
// rempve comments
function removeCommentsFromHTML(htmlString) {
  return htmlString.replace(/<!--[\s\S]*?-->/g, '');
}
// remove white spaces among html code 
function minifyHTML(html) {
  return html.replace(/\s+/g, ' ').trim();
}
// submit event
textEditorForm.addEventListener('submit', (event)=>{
    event.preventDefault();

    var title = writingArea.querySelector("h1.title").innerHTML;
    // creating a new form
    // var imgPropertiesEle = writingArea.querySelectorAll('img-properties');
    // imgPropertiesEle.forEach(ele => ele.remove());
    var result = validate(writingArea);
    result = removeCommentsFromHTML(result);
    result = minifyHTML(result);

    var form = document.createElement('form');
    form.method=textEditorForm.method;
    form.action=textEditorForm.action;

    // post id 
    var inputPostID = document.createElement('input');
    const postID = textEditorForm.querySelector('input[name="postID"]').value;
    inputPostID.name = 'postID';
    inputPostID.value = postID;
    form.appendChild(inputPostID);

    // post title
    var inputTitle = document.createElement('input');
    inputTitle.name = 'postTitle';
    inputTitle.value = title;
    form.appendChild(inputTitle);

    // post content 
    var inputContent = document.createElement('input');
    inputContent.name = 'postContent';
    inputContent.value = result;
    form.appendChild(inputContent);

    // post image 
    var inputImage = document.createElement('input');
    var postImg = textEditorForm.querySelector('#post-thumbnail-image');
    inputImage.name = 'postImg';
    inputImage.value = postImg.src;
    form.appendChild(inputImage);

    // state
    const state = textEditorForm.querySelector('#state-selector').value;
    var inputState = document.createElement('input');
    inputState.name = 'state';
    inputState.value = state;

    form.appendChild(inputState);

    // categories
    const categories = [];
    const categoryInputs = textEditorForm.querySelectorAll('.category-check-input:checked');
    categoryInputs.forEach((category) => {
        categories.push(category.value);
    });
    var inputCategory = document.createElement('input');
    inputCategory.name = 'categories';
    inputCategory.value = categories;
    form.appendChild(inputCategory);

    // submit
    document.body.appendChild(form);
    form.submit();
})  


function initial(){
  // remove child elements
  while (writingArea.firstChild) {
    writingArea.removeChild(writingArea.firstChild);
  }
  // insert post content
  var lines = postContent.children;
  Array.from(lines).forEach(line=>{
    if(line.tagName!== 'H1'){
      if(line.tagName !== 'DIV'){
        var newLine = document.createElement('div');
        newLine.classList.add("line");
        newLine.setAttribute('contenteditable', 'true');
        newLine.appendChild(line);

        writingArea.appendChild(newLine);
      }
      else{
        line.classList.add('line');
        line.setAttribute('contenteditable', true);

        writingArea.appendChild(line);
      }
    }
    else{
      line.setAttribute('contenteditable', 'true');
      writingArea.appendChild(line);
    }
  })
}
window.onload = initial();
// yesConfirmBtn.addEventListener('click', ()=>{
//   var title = writingArea.querySelector("h1.title").innerHTML;
//   // creating a new form
//   // var imgPropertiesEle = writingArea.querySelectorAll('img-properties');
//   // imgPropertiesEle.forEach(ele => ele.remove());
//   var result = validate(writingArea);
//   result = removeCommentsFromHTML(result);
//   result = minifyHTML(result);

//   var form = document.createElement('form');
//   form.method=textEditorForm.method;
//   form.action=textEditorForm.action;

//   // post id 
//   var inputPostID = document.createElement('input');
//   const postID = textEditorForm.querySelector('input[name="postID"]').value;
//   inputPostID.name = 'postID';
//   inputPostID.value = postID;
//   form.appendChild(inputPostID);

//   // post title
//   var inputTitle = document.createElement('input');
//   inputTitle.name = 'postTitle';
//   inputTitle.value = title;
//   form.appendChild(inputTitle);

//   // post content 
//   var inputContent = document.createElement('input');
//   inputContent.name = 'postContent';
//   inputContent.value = result;
//   form.appendChild(inputContent);

//   // post image 
//   var inputImage = document.createElement('input');
//   var postImg = textEditorForm.querySelector('#post-thumbnail-image');
//   inputImage.name = 'postImg';
//   inputImage.value = postImg.src;
//   form.appendChild(inputImage);

//   // state
//   const state = textEditorForm.querySelector('#state-selector').value;
//   var inputState = document.createElement('input');
//   inputState.name = 'state';
//   inputState.value = state;

//   form.appendChild(inputState);

//   // categories
//   const categories = [];
//   const categoryInputs = textEditorForm.querySelectorAll('.category-check-input:checked');
//   categoryInputs.forEach((category) => {
//       categories.push(category.value);
//   });
//   var inputCategory = document.createElement('input');
//   inputCategory.name = 'categories';
//   inputCategory.value = categories;
//   form.appendChild(inputCategory);

//   submit
//   document.body.appendChild(form);
//   form.submit();
// })