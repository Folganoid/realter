$(document).ready(function () {
       var path = window.location.pathname.split("/");

       if(path[1]) {
           $('#' + path[1]).addClass('active');
       }
});
