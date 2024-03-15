// submit event
// 
let textEditorForm = document.getElementById("text-editor");
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
// remove white spaces among html code 
function minifyHTML(html) {
    return html.replace(/\s+/g, ' ').trim();
}
// extract title plain text
function extractPlainTextFromHTML(htmlString) {
  const tempElement = document.createElement('span');
  tempElement.innerHTML = htmlString;
  return tempElement.textContent || tempElement.innerText;
}
// submit form
textEditorForm.addEventListener('submit', (event)=>{
event.preventDefault();
// 
var h1Title = writingArea.querySelector("h1.title").innerHTML;
var title = extractPlainTextFromHTML(h1Title);
// creating a new form
// var imgPropertiesEle = writingArea.querySelectorAll('img-properties');
// imgPropertiesEle.forEach(ele => ele.remove());
var result = validate(writingArea);
var result = minifyHTML(result);

var form = document.createElement('form');
form.method=textEditorForm.method;
form.action=textEditorForm.action;

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
inputImage.name = 'postImg';
inputImage.value = imageUrl;
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