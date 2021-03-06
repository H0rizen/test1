function loadTxt() {
    document.getElementById("tab0").innerHTML = "FLICKR";
    document.getElementById("tab1").innerHTML = "MY FILES";
    document.getElementById("tab2").innerHTML = "STYLES";
    document.getElementById("lblTag").innerHTML = "TAG:";
    document.getElementById("lblFlickrUserName").innerHTML = "Flickr User Name:";
    document.getElementById("lnkLoadMore").innerHTML = "Load More";
    document.getElementById("lblImgSrc").innerHTML = "IMAGE SOURCE:";
    document.getElementById("lblWidthHeight").innerHTML = "WIDTH x HEIGHT:";
    
    var optAlign = document.getElementsByName("optAlign");
    optAlign[0].text = ""
    optAlign[1].text = "Left"
    optAlign[2].text = "Right"

    document.getElementById("lblTitle").innerHTML = "TITLE:";
    document.getElementById("lblAlign").innerHTML = "ALIGN:";
    document.getElementById("lblSpacing").innerHTML = "V-SPACING:";
    document.getElementById("lblSpacingH").innerHTML = "H-SPACING:";
    document.getElementById("lblSize1").innerHTML = "SMALL SQUARE";
    document.getElementById("lblSize2").innerHTML = "THUMBNAIL";
    document.getElementById("lblSize3").innerHTML = "SMALL";
    document.getElementById("lblSize5").innerHTML = "MEDIUM";
    document.getElementById("lblSize6").innerHTML = "LARGE";

    document.getElementById("lblOpenLarger").innerHTML = "OPEN LARGER IMAGE IN A LIGHTBOX, OR";
    document.getElementById("lblLinkToUrl").innerHTML = "LINK TO URL:";
    document.getElementById("lblNewWindow").innerHTML = "OPEN IN A NEW WINDOW.";
    document.getElementById("btnCancel").value = "cancel";
    document.getElementById("btnSearch").value = " Search "; 
}
function writeTitle() {
    document.write("<title>" + "Image" + "</title>")
}
function getTxt(s) {
    switch (s) {
        case "insert": return "insert";
        case "change": return "change";
    }
}