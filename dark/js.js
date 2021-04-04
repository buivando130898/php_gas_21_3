theme = localStorage.getItem("theme");


if(theme=="dark")
{
    
    document.body.classList.add('dark');

}else 
{
    document.body.classList.add('ligh');

}



function save_dark()
{
    localStorage.setItem("theme", "dark");
    str="dark";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "save.php?theme=" + str, true);
    xmlhttp.send();

    document.body.classList.add('dark');
}

function save_ligh()
{
    localStorage.setItem("theme", "ligh");
    str="ligh";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "save.php?theme=" + str, true);
    xmlhttp.send();
    document.body.classList.remove('dark');
}




function print()
{
    alert(localStorage.getItem("theme"));
}
