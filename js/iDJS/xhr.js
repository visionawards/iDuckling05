var Ajax=function(){this.xmlHttp=null;this.callback=null;this.method="post";this.url="";this.create=function(method,url,callback){this.xmlHttp=initialize();this.callback=callback;this.url=url;this.method=method.toUpperCase();}
this.send=function(params){var urlString=this.url;if(this.method=='GET'){urlString=urlString+"?"+params;this.xmlHttp.open(this.method,urlString,true);this.xmlHttp.send(null);}
else if(this.method=="POST"){this.xmlHttp.open(this.method,urlString,true);this.xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");this.xmlHttp.send(params);}
this.xmlHttp.onreadystatechange=this.callback;}
this.getData=function(){if(this.xmlHttp.readyState==4&&this.xmlHttp.status==200){return this.xmlHttp.responseText;}else{return null;}}
function initialize(){var xmlHttp=null;try{xmlHttp=new XMLHttpRequest();}catch(e){try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){alert("Your browser does not support Ajax, please upgrade.");return false;}}}
return xmlHttp;}}