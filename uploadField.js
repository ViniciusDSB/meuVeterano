const uploadForm = document.getElementById("uploadForm");
const inputField = document.getElementById("inputGroupFile02");
const fileListTable = document.getElementById("fileListTable");
const maxUpSize = 4194304;
let totalUploadSize = 0;


inputField.addEventListener('change', () =>{
    let fileList = inputField.files;
    totalUploadSize = 0;
    if(fileList.length > 0){
        fileListTable.innerHTML = '<thead> <th></th> <th>Nome</th> <th>Tamanho</th> <th>Status</th> <thead> <tbody id="fileListBody"> </tbody>'
        let fileListBody = document.getElementById("fileListBody");
        for (let i = 0; i < fileList.length; i++) {

            let tableRow = document.createElement('tr');

            let td1 = document.createElement("td");
            let td2 = document.createElement("td");
            let td3 = document.createElement("td");
            let td4 = document.createElement("td");

            td1.innerText = i+1;
            td2.innerText = fileList[i].name;
            totalUploadSize+=fileList[i].size
            fileSize = 0;

            if(fileList[i].size < 1024){
                fileSize = (fileList[i].size).toFixed(2) +'byte';
            }else if(fileList[i].size < 1048576){
                fileSize = (fileList[i].size/1024).toFixed(2) +"kb";
            }else{
                fileSize = (fileList[i].size/1048576).toFixed(2) +"Mb";
            }

            td3.innerText = fileSize;
            td4.innerText = "Ok";

            if(fileList[i].size > maxUpSize){
                tableRow.className = "table-danger"
                td4.innerText = "Arquivo >40Mb";
            }

            tableRow.append(td1);
            tableRow.append(td2);
            tableRow.append(td3);
            tableRow.append(td4);

            fileListBody.append(tableRow)
        }
    }else{
        fileListTable.innerText = 'Selecione ou arraste arquivos';
    }

    if(totalUploadSize > maxUpSize){
        alert('O tamanho do upload: '+ (totalUploadSize/(1024**2)).toFixed(2) +'Mb excete o tamanho de 40mb');
    }
    
})

uploadForm.addEventListener('submit', (event) => {

    for(i=0; i<uploadForm.length; i++){
        let formElm = uploadForm[i];
        if(formElm.type!='div' && formElm.type!='submit' && formElm.type!='label' && formElm.type!='h3' && formElm.value == ''){
            alert('Preencha todos os campos!');
            console.log(formElm.type);
            event.preventDefault();
        }
    }

    if(totalUploadSize > maxUpSize){
        alert('Respeite o limite de tamanho por upload de 40Mb');
        inputField.value = '';
        fileListTable.innerText = 'Selecione ou arraste arquivos';

        event.preventDefault();
    }
})