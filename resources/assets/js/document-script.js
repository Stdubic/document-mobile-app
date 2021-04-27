const PREVIEW_LENGTH = 45;
const TYPE_SECTION = "SECTION";
const TYPE_SENTENCE = "SENTENCE";
const TYPE_DOCUMENT = "DOCUMENT";
const TYPE_IMAGE = "IMAGE";

var data = [{
    "text": "Click to add title",
    "type":"document",
    "data": {
        "database": {
            "id": "-1",
            "type": "DOCUMENT",
            "document_title": "Click to add title",
            "protected" : false
        }
    },
    "children": []
}];

var $tree = null;
$(function() {
    $tree = $('#structure');
    $tree.jstree({
        "core": {
            "animation": 0,
            "check_callback": true,
            "themes": { "stripes": true },
            'data': data
        },
        "types": {
            "sentence": {
                "icon": "/img/sentence.png",
                "valid_children": []
            },
            "section": {
                "icon": "/img/section.png"
            },
            "imagefield":{
                "icon": "/img/icon-image.png",
                "valid_children": []
            }
        },
        "plugins": [
            "types",
            "dnd"
        ]
    }).on('loaded.jstree', function() { $tree.jstree('open_all');  document.getElementById('edit').innerHTML=''; })
        .on('select_node.jstree', function(node, selected, event) {  editNode(selected.node); })
        .on('create_node.jstree', function(node, parent) {
            console.log("created node", node);
            console.log("created parent", parent)
        });

});


// controls
function deleteNode() {

    const selectedNode = $tree.jstree().get_node($tree.jstree().get_selected());
    if(selectedNode.data.database.type == TYPE_DOCUMENT){
        alert("Can not delete document here. To delete document go to document list, select it and click delete.");
        return;
    }
    $tree.jstree().delete_node(selectedNode);
    setTimeout(function() { $tree.jstree(true).trigger('loaded.jstree'); }, 800);
}

function addSentence() {

    const selectedNode = $tree.jstree().get_node($tree.jstree().get_selected());
    if (selectedNode.type === "sentence" || selectedNode.type === "image") { alert("Can not add sentance, image or section to sentence!"); return; };
    const newNode = {
        "text": "New sentence",
        "state": "open",
        "type": "sentence",
        "data": {
            "database": {
                "id": "-1",
                "type": TYPE_SENTENCE,
                "sentence_number": "",
                "sentence_text": "New sentence"
            }
        }
    };
    $tree.jstree().create_node(selectedNode, newNode, "last", function() { $tree.jstree().open_node(selectedNode) });
}

function addSection() {
    const selectedNode = $tree.jstree().get_node($tree.jstree().get_selected());
    if (selectedNode.type === "sentence" || selectedNode.type === "image") { alert("Can not add sentance, image or section to section!"); return; };
    const newNode = {
        "text": "New section",
        "state": "open",
        "type": "section",
        "data": {
            "database": {
                "id": "-1",
                "type": TYPE_SECTION,
                "section_number": "",
                "section_title": "New section",
                "section_description": "New section description"
            }
        }
    };
    $tree.jstree().create_node(selectedNode, newNode, "last", function() { $tree.jstree().open_node(selectedNode) });

}

function addImage() {
    const selectedNode = $tree.jstree().get_node($tree.jstree().get_selected());
    if (selectedNode.type === "sentence" || selectedNode.type === "image") { alert("Can not add sentance, section or image to image!"); return; };
    const newNode = {
        "text": "Image",
        "state": "open",
        "type": "imagefield",
        "data": {
            "database": {
                "id": "-1",
                "type": TYPE_IMAGE,
                "image_source": "",
                "image_description": "Image description"
            }
        }
    };
    $tree.jstree().create_node(selectedNode, newNode, "last", function() { $tree.jstree().open_node(selectedNode) });

}

function editNode(node) {
    console.log(node);
    console.log('edit node pozvan');
    var container = document.getElementById("edit");
    var label_number = document.createElement("label");
    var label_text = document.createElement("label");


    var label_description = document.createElement('span');
    var input_description = document.createElement('span');
    var input_number = document.createElement("span");


    if (node.data.database.type == TYPE_SECTION) {
        var input_text = document.createElement("input");
        input_number = document.createElement("input");
        label_description = document.createElement("label");
        input_description = document.createElement("input");
        label_text.innerHTML = "Section title";
        label_number.innerHTML = "Section number";
        label_description.innerHTML = "Section description";

        input_text.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.section_title = newText;

            let nodeText = node.data.database.section_number + " " + node.data.database.section_title;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0,PREVIEW_LENGTH) + " ..." ;}
            node.text = nodeText;

            $tree.jstree().redraw_node(node, true);
        });

        input_number.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.section_number = newText;

            let nodeText = node.data.database.section_number + " " + node.data.database.section_title;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0,PREVIEW_LENGTH) + " ..." ;}
            node.text = nodeText;

            $tree.jstree().redraw_node(node, true);
        });

        input_description.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.section_description = newText;
            $tree.jstree().redraw_node(node, true);
        });

        input_text.value = node.data.database.section_title;
        input_number.value = node.data.database.section_number;
        input_description.value = node.data.database.section_description;

    } else if (node.data.database.type === TYPE_SENTENCE) {
        var input_text = document.createElement("textarea");
        input_text.rows = 10;
        input_number = document.createElement("input");
        label_text.innerHTML = "Sentence text";
        label_number.innerHTML = "Sentence number";

        input_text.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.sentence_text = newText;

            let nodeText = node.data.database.sentence_number + " " + node.data.database.sentence_text;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0, PREVIEW_LENGTH) + " ..."; }
            node.text = nodeText;


            $tree.jstree().redraw_node(node, true);
        });


        input_number.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.sentence_number = newText;

            let nodeText = node.data.database.sentence_number + " " + node.data.database.sentence_text;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0, PREVIEW_LENGTH) + " ..."; }
            node.text = nodeText;

            $tree.jstree().redraw_node(node, true);
        });


        input_text.value = node.data.database.sentence_text;
        input_number.value = node.data.database.sentence_number;

    } else if (node.data.database.type === TYPE_DOCUMENT ) {
        var input_text = document.createElement("input");
        label_text.innerHTML = "Document title";

        // za checkbox protected ce se koristi postojici inptut number
        input_number =  document.createElement("input");
        input_number.name = "protected";
        input_number.type = "checkbox";

        label_number.innerHTML = "Protected";

        input_text.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.document_title = newText;

            let nodeText = node.data.database.document_title;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0, PREVIEW_LENGTH) + " ..."; }
            node.text = nodeText;

            $tree.jstree().redraw_node(node, true);
        });

        input_number.addEventListener('change', function(event) {
            const newValue = event.target.checked;
            node.data.database.protected = newValue;
            $tree.jstree().redraw_node(node, true);
        });

        input_text.value = node.data.database.document_title;
        input_number.checked = node.data.database.protected;

    } else if (node.data.database.type === TYPE_IMAGE) {
        var input_text = document.createElement("input");
        input_text.type = 'file';
        input_number = document.createElement("input");
        label_text.innerHTML = "Choose image";
        label_number.innerHTML = "Image description";

        input_text.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const formDataData = new FormData();
            formDataData.append("image",file);
            var req = new XMLHttpRequest();
            req.open("POST", "/api/document/image-upload", true);
            req.onload = function(oEvent) {
                if (req.status == 200 ) {

                    const jsonResponse = JSON.parse(req.responseText);
                    const imageSource = jsonResponse.image_url;
                    node.data.database.image_source = imageSource;
                    // add image to preview
                    const editContainer = document.getElementById('edit');
                    let preview = editContainer.querySelector('img');
                    preview.src =imageSource;

                    $tree.jstree().redraw_node(node, true);
                } else {
                    console.log(req);
                   console.log('error occured');
                }
            };
            req.setRequestHeader('Authorization', "Bearer "+userToken);
            req.send(formDataData);
        });

        input_number.addEventListener('input', function(event) {
            const newText = event.target.value;
            node.data.database.image_description = newText;

            let nodeText =  "Image - " + node.data.database.image_description;
            if (nodeText.length > PREVIEW_LENGTH - 1) { nodeText = nodeText.substr(0, PREVIEW_LENGTH) + " ..."; }
            node.text = nodeText;

            $tree.jstree().redraw_node(node, true);
        });


        input_number.value = node.data.database.image_description;

    } else {
        return;
    }

    container.innerHTML = "";
    container.appendChild(label_number);
    container.appendChild(input_number);
    container.appendChild(label_text);
    container.appendChild(input_text);
    container.appendChild(label_description);
    container.appendChild(input_description);

    if(node.data.database.type === TYPE_SENTENCE) {
        if(node.data.database.id==-1) {
            const warningText=document.createElement('span');
                warningText.innerHTML='Adding comments will be available after saving.';
            container.appendChild(warningText);
        } else {
            container.appendChild(renderCommenting());
        }
    }
    if(node.data.database.type === TYPE_IMAGE){
        const preview = document.createElement('img');
        preview.src =node.data.database.image_source;
        preview.style = 'width:100%';
        container.appendChild(preview);
    }


}



function saveNode() {
    let data = $tree.jstree().get_json();
    data = JSON.stringify(data);
    var xhttp = new XMLHttpRequest();
    const formdata = new FormData();
    formdata.append("data", data);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // dokument je spremljen #SAVED
            fireNotification({
                message: 'Saved',
                icon: 'fa fa-check',
                type: 'success',
                delay: 5
            });
            refreshDocument(xhttp.responseText);

        }
    };
    xhttp.open("POST", "/api/backend/process-document", true);
    xhttp.setRequestHeader('Authorization', "Bearer "+userToken);
    xhttp.send(formdata);
}

function refreshDocument(document_id) {
    console.log("refresh pozva");

    if (document_id == "-1") {
        var balnk_data = [{
            "text": "Click to add title",
            "data": {
                "database": {
                    "id": "-1",
                    "type": "DOCUMENT",
                    "document_title": "Click to add title",
                    "protected": false
                }
            },
            "children": []
        }];
        $tree.jstree(true).settings.core.data = balnk_data;
        $tree.jstree(true).refresh();
        setTimeout(function() { $tree.jstree(true).trigger('loaded.jstree'); }, 800);
        return;
    }
    var xhttp = new XMLHttpRequest();
    const formdata = new FormData();
    formdata.append("data", data);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log('data',xhttp.responseText);
            const response_json = JSON.parse('[ '+ xhttp.responseText +' ]');
            $tree.jstree(true).settings.core.data = response_json;
            $tree.jstree(true).refresh();
            setTimeout(function() { $tree.jstree(true).trigger('loaded.jstree'); }, 800);

        }
    };
    xhttp.open("GET", "/api/backend/documents/" + document_id, true);
    xhttp.setRequestHeader('Authorization', "Bearer "+userToken);
    xhttp.send(formdata);
}

var commentCategories = [];
fetch('/comment-categories').then(response=> response.json()).then(response => commentCategories = response);
function renderCommenting() {
    const commentingContainer = document.createElement('div');
    const titleCommenting = document.createElement('p');
    const commentsContainer = document.createElement('div');
    commentsContainer.id='comments-container';
    titleCommenting.innerHTML = 'Commenting';
    commentingContainer.appendChild(titleCommenting);
    const commentCategorySelect = document.createElement('select');
    const option = document.createElement("option");
    option.text = '-';
    option.value = -1;
    commentCategorySelect.id='comment-category-id';
    commentCategorySelect.add(option);
    commentCategorySelect.onchange = event => showComments(event.target.value);
    commentCategories.forEach(element => {
        const option = document.createElement("option");
        option.text = element.name;
        option.value = element.id;
        commentCategorySelect.add(option);
    });
    const addCommentContainer = addCommentRender();
    commentingContainer.appendChild(commentCategorySelect);
    commentingContainer.appendChild(addCommentContainer);
    commentingContainer.appendChild(commentsContainer);
    return commentingContainer;
}

async function showComments(commentCategoryId){
    const requestConfig = {
        headers : {
            "Authorization" : "Bearer "+userToken
        }
    };
   const sentenceId = $tree.jstree().get_node($tree.jstree().get_selected()).data.database.id;
   const response = await fetch('/api/sentences/'+ sentenceId + '/' + commentCategoryId, requestConfig).then(response=> response.json());
   const commentsContainer = document.getElementById('comments-container');
   commentsContainer.innerHTML = '';
   response.data.comments.forEach(comment=>{
      const commentContainer = document.createElement('div');
       commentContainer.style = 'position:relative';
       const userInfo = document.createElement('p');
       const commentInfo = document.createElement('p');
       commentInfo.style = "border-bottom: 1px solid silver;"
       userInfo.innerText = comment.user.name + ' ' + (comment.user.surname ?comment.user.surname: '') ;
       commentInfo.innerText = comment.comment;

       const deleteButton = document.createElement('button');
       deleteButton.type='button';
       deleteButton.innerHTML='Delete';
       deleteButton.style='position:absolute; right:0;';
       deleteButton.onclick = () => deleteComment(comment.id);

       commentContainer.appendChild(deleteButton);
       commentContainer.appendChild(userInfo);
       commentContainer.appendChild(commentInfo);
       commentsContainer.appendChild(commentContainer);


   });

}

function addCommentRender (){
    const commentForm = document.createElement('form');
    const commentText = document.createElement('textarea');
    const commentSubmit = document.createElement('button');
    commentForm.onsubmit = event => addComment(event);
    commentText.name = "text";
    commentSubmit.innerText = 'Comment';
    commentForm.appendChild(commentText);
    commentForm.appendChild(commentSubmit);
    return commentForm;
}

async function addComment(event){
    event.preventDefault();
    const formData = new FormData(event.target);
    const commentCategoryId = document.getElementById('comment-category-id').value;
    formData.append("category_id",commentCategoryId);
    const headers = new Headers();
    headers.set('Accept', 'application/json');
    headers.set('Authorization', "Bearer "+userToken);

    const requestConfig = {
        method : 'post',
        headers : headers,
        body: formData
    };
    console.log('event',event);


    const sentenceId = $tree.jstree().get_node($tree.jstree().get_selected()).data.database.id;
    const response = await fetch('/api/sentences/'+ sentenceId + '/comments', requestConfig).then(response=> response.json());
    console.log(response);
    showComments(commentCategoryId);
    event.target.reset();
    return false;
}

async function deleteComment(commentId){
    const headers = new Headers();
    headers.set('Accept', 'application/json');
    headers.set('Authorization', "Bearer "+userToken);
    const requestConfig = {
        method : 'delete',
        headers : headers
    };
    try{
    const response = await fetch('/api/comments/'+ commentId , requestConfig).then(response=> response.json());

        const commentCategoryId = document.getElementById('comment-category-id').value;
        showComments(commentCategoryId);

    } catch (error){
        alert("An error occured while deleting comment.");
    }


}