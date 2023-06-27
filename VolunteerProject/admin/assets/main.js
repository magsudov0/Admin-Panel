var list=document.querySelector(".bi-list")
var x=document.querySelector(".bi-x-lg")
var menuBar=document.querySelector(".row")

function changeList(){
    list.style.display = 'none';
    x.style.display = 'flex'
    menuBar.style.display= 'flex'
}

function changeX(){
    list.style.display = 'flex';
    x.style.display = 'none'
    menuBar.style.display= 'none'
}

function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("mySearch");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myMenu");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }

  function hiden() {
    document.getElementById('eyeIconHide').style.display = 'none';
    document.getElementById('eyeIconView').style.display = 'inline-block';
    var x = document.forms['form'].elements['password'];
    x = x.length ? x[0] : x;
    if (x.type == 'password') {
        document.getElementById('password').setAttribute('type', 'text');
    } else {
        document.getElementById('password').setAttribute('type', 'password');
    }
}

function viewer() {
    document.getElementById('eyeIconHide').style.display = 'inline-block';
    document.getElementById('eyeIconView').style.display = 'none';
    var x = document.forms['form'].elements['password'];
    x = x.length ? x[0] : x;
    if (x.type == 'password') {
        document.getElementById('password').setAttribute('type', 'text');
    } else {
        document.getElementById('password').setAttribute('type', 'password');
    }
}