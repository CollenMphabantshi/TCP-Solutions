
$(document).ready(function(){
    $("#mylist-content").hide();
    $("#mycreations-content").hide();
    $("#inbox-content").hide();
    $("#settings-content").hide();
    $(".btn-disabled").removeAttr("href");
    openPage("popular","home-content","");
    $("#navigation li a").click(function(){
	if($(this).attr("id") == "home")
	{
            $("#home-content").show();
            $("#mylist-content").hide();
            $("#mycreations-content").hide();
            $("#inbox-content").hide();
            $("#settings-content").hide();
            openPage("popular","home-content","");
	}else if($(this).attr("id") == "mylist"){
            $("#home-content").hide();
            $("#mylist-content").show();
            $("#mycreations-content").hide();
            $("#inbox-content").hide();
            $("#settings-content").hide();
            openPage("getList","mylist-content","");
	}else if($(this).attr("id") == "mycreations"){
            $("#home-content").hide();
            $("#mylist-content").hide();
            $("#mycreations-content").show();
            $("#inbox-content").hide();
            $("#settings-content").hide();
            openPage("mycreation","mycreations-content","");
	}else if($(this).attr("id") == "inbox"){
            $("#home-content").hide();
            $("#mylist-content").hide();
            $("#mycreations-content").hide();
            $("#inbox-content").show();
            $("#settings-content").hide();
            openPage("inbox","inbox-content","");
	}else if($(this).attr("id") == "settings"){
            $("#home-content").hide();
            $("#mylist-content").hide();
            $("#mycreations-content").hide();
            $("#inbox-content").hide();
            $("#settings-content").show();
            openPage("settings","settings-content","");
	}
    });
    
    
    
    $("#navigation li").click(function(){
        if($(this).children("a").attr("id") == "cf")
	{
            document.location.href = "/restricted/full/cf";
	}
    });
    
});


function openPage(page,pageId,param){
    var linkurl = "pages/";
    if(page !== "" && page !== null)
    {
        linkurl += page+".php";
    }else{
        return;
    }
    
   $("#popup-content").removeClass("popup");
   $("#popup-content").html("");
   
    var html = $.ajax({
        url: linkurl+param,
        async: false
    }).responseText;
    //alert(html);
    
    if(pageId === "popup-content")
    {
        $("#home-content").hide();
        $("#mylist-content").hide();
        $("#mycreations-content").hide();
        $("#inbox-content").hide();
        $("#settings-content").hide();
        $("#popup-content").addClass("popup");
        
        $("#popup-content").html(html);
    }
    else{
        $("#"+pageId+" .data").html(html);
    }
}

function acknowledge(cid){
    openPage("acknowledge","popup-content","?cid="+cid);
    window.document.location.reload();
 }
function addToList(cid){
    openPage("addToList","popup-content","?cid="+cid);
    document.location.href = "/restricted/full/cf/";
}
function openCreation(cid){
    openPage("viewCreation","popup-content","?cid="+cid);
}
function viewCreation(cid){
    openPage("creation","popup-content","?cid="+cid);
}
function viewMyCreation(cid){
    openPage("creationSetup","popup-content","?cid="+cid);
}
function addCreation(){
    openPage("creationForm","popup-content","");
}
function removeCreation(){
    openPage("removeCreation","popup-content","");
}
            
function removeMyCreation(){
    var query = new FormData();
    var id = "";
    $("fieldset input").each(function(count){
        var el = document.getElementById(""+$(this).attr("id"));
        if(el.checked){
            id += $(this).attr("id")+",";
        }
    });
    query.append("creationID",id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
        $("#home-content").hide();
        $("#mylist-content").hide();
        $("#mycreations-content").hide();
        $("#inbox-content").hide();
        $("#settings-content").hide();
        $("#popup-content").html(request.responseText);
    }};
    request.open("POST","pages/remove.php");request.send(query);
}