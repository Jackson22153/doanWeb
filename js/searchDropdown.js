// parameters: des-path (destination path), search-condition (json format), search-path

class SearchDropdown extends HTMLElement{
    constructor(){
        super();
        let html = `
            <input placeholder="Search Posts" name="search" type="text" id="search-bar"
                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Posts'"
                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                autocomplete="off">
            <div class="dropdown-menu" id="search-dropdown-menu" aria-labelledby="dropdownMenuLink">  
            </div>
            <button type="submit"><i class="fa fa-search"></i></button>
        `;
        this.innerHTML = html;
    }

    connectedCallback(){
        let searchBar = document.getElementById('search-bar');
        let dropdownMenu = document.querySelector('#search-dropdown-menu');
        var searchPath = this.getAttribute('search-path');
        var searchCondition = this.getAttribute('search-condition');
        var desPath = this.getAttribute('des-path');
        let timer;

        searchBar.addEventListener('keyup', (event)=>{
            var query = event.target.value;
        

            clearTimeout(timer); // clear the timer if a key is pressed
            timer = setTimeout(async ()=>{
                var data = JSON.parse(searchCondition);
                data = {
                    ...data,
                    query: query
                }
                data = JSON.stringify(data);
    
                if(query.length>2){
                    await fetch(searchPath, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: data
                        // body: 'query=' + encodeURIComponent(query),
                    })
                    .then(response => response.json())
                    .then(data => {
                        while(dropdownMenu.firstChild){
                            const child = dropdownMenu.firstChild;
                            dropdownMenu.removeChild(child)
                        }
                        if(data.length>0){
                            data.forEach(post => {
                                var a = document.createElement('a');
                                a.classList.add("dropdown-item");
                                a.href= `${desPath}?p=${post.id}`;
                                a.innerHTML = post.postTitle;
                                // console.log(a);
                                dropdownMenu.appendChild(a);
                            });
                        }else {
                            var a = document.createElement('a');
                            a.classList.add("dropdown-item");
                            a.innerHTML = "Blog not found";
                            // console.log(a);
                            dropdownMenu.appendChild(a);
                        }
                        searchBar.focus();
                    });
                }else{
                    while(dropdownMenu.firstChild){
                        const child = dropdownMenu.firstChild;
                        dropdownMenu.removeChild(child)
                    }
                }

            }, 200); // set the timer
            
        })
    }
}
customElements.define('search-dropdown', SearchDropdown);