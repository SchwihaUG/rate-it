function onReadyRateIt(e){function t(){for(var e=0;e<readyListRateIt.length;e++){readyListRateIt[e]()}}if(!readyListRateIt.length){bindReady(t)}readyListRateIt.push(e)}function bindReady(e){function n(){if(t)return;t=true;e()}var t=false;if(document.addEventListener){document.addEventListener("DOMContentLoaded",n,false)}else if(document.attachEvent){try{var r=window.frameElement!=null}catch(i){}if(document.documentElement.doScroll&&!r){function s(){if(t)return;try{document.documentElement.doScroll("left");n()}catch(e){setTimeout(s,10)}}s()}document.attachEvent("onreadystatechange",function(){if(document.readyState==="complete"){n()}})}if(window.addEventListener)window.addEventListener("load",n,false);else if(window.attachEvent)window.attachEvent("onload",n);else{var o=window.onload;window.onload=function(){o&&o();n()}}}var readyListRateIt=[]