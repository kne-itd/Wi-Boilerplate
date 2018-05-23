(function(){
    var cookieConsentDiv = document.createElement('div');
    var heading = document.createElement('h3');
    var paragraph = document.createElement('p');
    var btn = document.createElement('button');
    var pLink = document.createElement('a');
    
    var headingText = document.createTextNode('Cookies');
    var pText = document.createTextNode('Yes. Vi bruger dem også. Og det skal du selvfølgelig vide.');
    var pLinkText = document.createTextNode('Vilkår');
    var btnText = document.createTextNode('Acceptér');
        
    pLink.href = 'vilkaar';
    pLink.appendChild(pLinkText);
    
    heading.appendChild(headingText);
    paragraph.appendChild(pText);
    btn.appendChild(btnText);
    
//    cookieConsentDiv.setAttributeNode(att);
    cookieConsentDiv.appendChild(heading);
    cookieConsentDiv.appendChild(paragraph);
    cookieConsentDiv.appendChild(pLink);
    cookieConsentDiv.appendChild(btn);
    
    btn.classList.add('btn');
    btn.classList.add('btn-primary');
    btn.classList.add('m-4');
    
    cookieConsentDiv.classList.add('cookie-consent');
    cookieConsentDiv.classList.add('alert');
    cookieConsentDiv.classList.add('alert-warning');
    
    document.body.appendChild(cookieConsentDiv);
    
    if (getCookie('cookie_consent')) {
        cookieConsentDiv.style.display = 'none';
    }
    btn.addEventListener('click', function () {
        createCookie('cookie_consent', 'true');
        cookieConsentDiv.style.display = 'none';
    });
    function getCookie(name) {
    //    var regExp = new RegExp("(?:^" + name + "|;\s*" + name + ")=(.*?)(?:;|$)", "g");
        var regExp = new RegExp('(?:^|;\\s*)(' + name + ')\\s*=\\s*([^;]+)',"g");
        var result = regExp.exec(document.cookie);
        console.log(document.cookie);
        return (result === null ? null : result[2]);
    }
    function createCookie(name, value, days) {
        var expires = '';
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + '=' + value + expires + ';path=/';
    }  
})();
    
$(document).ready(function(){
   setTimeout(function(){
      $('.cookie-consent').hide(1000); 
   }, 5000)
});
