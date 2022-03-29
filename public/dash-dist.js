var bootstrap_enabled = false;
var bootstrap_primary = getComputedStyle(document.documentElement).getPropertyValue('--primary'); ;
var bootstrap_primary_alt = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary');
if ((bootstrap_primary !== null && bootstrap_primary !== '') | (bootstrap_primary_alt !== null && bootstrap_primary_alt !== '')) {
    console.log("Bootstrap CSS detected");
    bootstrap_enabled = true;
}
console.log("DASH: We detect bootstrap is enabled (True/False): " + bootstrap_enabled);
console.log(bootstrap_primary);
console.log(bootstrap_primary_alt);
if (typeof dash_referrer === 'undefined') {
    var dash_referrer = '';
} else {
    dash_referrer = 'referrer='+dash_referrer;
}
if (typeof dash_tags === 'undefined') {
    var dash_tags = '';
} else {
    dash_tags = 'tags=' + dash_tags;
}

var dash_params = [dash_referrer, dash_tags].filter(Boolean).join("&");

if (dash_params.length !== 0) {
    dash_params = '?'+dash_params;
}

// Update this link with your own.
var href_base = "https://{YOUR-WEBSITE}/quickdash_client/public";

var link = document.createElement("link");
link.href = href_base+"/css/dash.css";
link.type = "text/css";
link.rel = "stylesheet";
link.media = "screen,print";

document.getElementsByTagName("head")[0].appendChild(link);

if (bootstrap_enabled == false) {
    var link_pf = document.createElement("link");
    link_pf.href = href_base+"/css/polyfill.css";
    link_pf.type = "text/css";
    link_pf.rel = "stylesheet";
    link_pf.media = "screen,print";

    document.getElementsByTagName("head")[0].appendChild(link_pf);
}

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        document.getElementsByClassName('quickdash-outter')[0].innerHTML = xhr.responseText;
    }
};
xhr.open('GET', href_base+'/dashtabs.php' + dash_params);
xhr.send();

function quickdash_opentab(event, tagname) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("quickdash-links tags");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("quickdash-tab-button");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    activetab = document.getElementsByClassName("quickdash-links tags tag-"+tagname);
    for (i = 0; i < activetab.length; i++) { 
        activetab[i].style.display = "inherit";
    }
    event.currentTarget.className += " active";
}