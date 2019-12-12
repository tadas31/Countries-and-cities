function conf(name, path)
{
    var con=confirm("Are you sure you want to delete " + name);
    if (con){
        window.location.href = path;
    }

}