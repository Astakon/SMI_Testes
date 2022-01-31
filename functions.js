var xmlHttp;
var selectedCategory;

function SelectCategoryChange(theSelect) {

    if (typeof (theSelect) === 'string') {
        selectedCategory = theSelect;
    } else {
        selectedCategory = theSelect.value;
    }

    var args = "category=" + selectedCategory;

    // With HTTP GET method
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "processSubCategoriesAJAX.php?" + args, true);
    xmlHttp.onreadystatechange = SelectCategoryHandleReply;
    xmlHttp.send(null);
}


function SelectCategoryHandleReply() {

    //alert( xmlHttp.readyState );

    if (xmlHttp.readyState === 4) {
        var subSelect = document.getElementById("subcategories");

        if (selectedCategory == 0) {

            document.getElementById("addSubInput").style.display = "none";
            document.getElementById("publicarButton").style.display = "none";
        } else {
            document.getElementById("addSubInput").style.display = "block";
            document.getElementById("publicarButton").style.display = "block";
        }



        subSelect.options.length = 0;

        var response = xmlHttp.responseText;


        var subCategories = JSON.parse(response);



        for (i = 0; i < subCategories.length; i++) {
            var currentCounty = subCategories[i];

            var value = currentCounty["idSubCategoria"];
            var option = currentCounty["nome"];

            try {
                subSelect.add(new Option("", value), null);
            } catch (e) {
                subSelect.add(new Option("", value));
            }

            subSelect.options[i].innerHTML = option;
        }
    }
}

function addSubCategory() {

    var nome = document.getElementById("newSubCategory").value;
    var idCategoria = document.getElementById("categories").value;
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "AddNewSubCategory.php?nome=" + nome + "&idCategoria=" + idCategoria, true);
    xmlHttp.onreadystatechange = addSubCategoryHandle;
    xmlHttp.send(null);
}

function addSubCategoryHandle() {


    if (xmlHttp.readyState === 4) {
        if (xmlHttp.responseText === -1) {
            alert("Não inserida!");

        } else {
            alert("Sub categoria adicionada!");
            SelectCategoryChange(xmlHttp.responseText);
        }

    }
}


function contentTypeHandler() {


    var conteudo = document.getElementById("tipoConteudo").value;

    if (conteudo === 2) {

        document.getElementById("thumbnail").style.display = "none";

    } else {
        document.getElementById("thumbnail").style.display = "block";
    }
}



function changeClassification(classificacao, idUtilizador, idConteudo) {

    deuLike = classificacao;
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "processClassificacao.php?classificacao=" + classificacao + "&idUtilizador=" + idUtilizador + "&idConteudo=" + idConteudo, true);
    xmlHttp.onreadystatechange = changeClassificationHandler;
    xmlHttp.send(null);

}

function changeClassificationHandler() {

    if (xmlHttp.readyState === 4) {

        location.reload();


    }
}

function subscribeFunction(subscribe, idSubscritor, idPublicador) {

    //Remover subscrição
    if (subscribe === 0) {
        console.log("unfollow");
    } else {
        console.log("follow " + idSubscritor + " " + idPublicador);
    }


    // With HTTP GET method
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "processSubscricao.php?subscricao=" + subscribe + "&idSubscritor=" + idSubscritor + "&idPublicador=" + idPublicador, true);
    xmlHttp.onreadystatechange = subscribeFunctionHandler;
    xmlHttp.send(null);

}
function subscribeFunction2(subscribe, idSubscritor, idCategoria) {

    //Remover subscrição
    if (subscribe === 0) {
        console.log("unfollow");
    } else {
        console.log("follow " + idSubscritor + " " + idCategoria);
    }


    // With HTTP GET method
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "processSubscricaoCat.php?subscricao=" + subscribe + "&idSubscritor=" + idSubscritor + "&idCategoria=" + idCategoria, true);
    xmlHttp.onreadystatechange = subscribeFunctionHandler;
    xmlHttp.send(null);

}

function subscribeFunctionHandler() {
    if (xmlHttp.readyState === 4) {
        if (xmlHttp.responseText === "true") {
            alert("Subcricao alterada!");
            location.reload();

        } else {
            alert("Erro ao alterar subscricao!");
        }

    }
}

function editCommentHandler() {
    if (xmlHttp.readyState === 4) {
        location.reload();
    }
}

function shareTwitter(curPath, nomeConteudo) {
    link = "http://twitter.com/share?url=" + curPath + "&text=" + nomeConteudo;
    window.open(link, "Twitter Share", "width=620, height=420");

}


function editComment(apagar_adicionar, idUtilizador, idConteudo, idComentario) {

    var comment = document.getElementById("newComent").value;
    if (comment === "" && apagar_adicionar === 1)
        return;

    console.log(comment);
    xmlHttp = GetXmlHttpObject();
    xmlHttp.open("GET", "processComentario.php?comentario=" + comment + "&idUtilizador=" + idUtilizador + "&idConteudo=" + idConteudo + "&idComentario=" + idComentario + "&apagar_adicionar=" + apagar_adicionar, true);
    xmlHttp.onreadystatechange = editCommentHandler;
    xmlHttp.send(null);
}

function GetXmlHttpObject() {
    try {
        return new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
    } // Internet Explorer
    try {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } catch (e) {
    } // Internet Explorer
    try {
        return new XMLHttpRequest();
    } catch (e) {
    } // Firefox, Opera 8.0+, Safari
    alert("XMLHttpRequest not supported");
    return null;
}
