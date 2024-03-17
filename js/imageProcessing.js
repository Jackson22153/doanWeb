const repositoryOwner = 'jackson22153fake';
const repository = 'BlogImgRepository';
let token = '';



async function uploadImage(contentBase64, extension, dotEnvPath){
    var content = contentBase64.split(';base64,').pop();
    // content = contentBase64.replace(`data:image/${extension};base64,`, '');
    var uuid = crypto.randomUUID();
    const fileName = `${uuid}.${extension}`;
    const url = `https://api.github.com/repos/${repositoryOwner}/${repository}/contents/${fileName}`;

    const data = {
        message: 'imageUpload',
        committer: {
            name: 'BlogImgRepository',
            email: 'jackson22153@gmail.com'
        },
        content: content
    };

    await fetch(`${dotEnvPath}.env`).then(res => res.text())
    .then(text => {
        const lines = text.split('\n');
        lines.forEach(line => {
            if(line) {
                const [key, value] = line.split('=');
                token = value;
            }else throw Error("dont have any token");
        });
    });

    // const token = value;
    return await fetch(url, {
        method: 'PUT',
        headers: {
            'Authorization': `token ${token}`,
            'Content-Type': 'application/json',
            'X-GitHub-Api-Version': '2022-11-28'
        },
        body: JSON.stringify(data)
    })
}