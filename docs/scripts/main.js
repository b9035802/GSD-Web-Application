(function(){
    $(".burgerMenu").on("click", function(ev) 
    {
        ev.preventDefault();
        $(this).toggleClass("animateBurger");
        $(".mainNav").slideToggle("fast");
    });
    
    $(window).on("resize", function(ev) {
        //console.info(window.innerWidth);
        if (window.innerWidth > 800) {
        $("nav ul").attr("style", "");
        }
    });
    function navHighlight(elem, home, active) {
        var url = location.href.split('/'),
            loc = url[url.length -1],
            link = document.querySelectorAll(elem);
        for (var i = 0; i < link.length; i++) {
            var path = link[i].href.split('/'),
                page = path[path.length -1];
            if (page == loc || page == home && loc == '') {
                link[i].parentNode.className += ' ' + active;
                document.body.className += ' ' + page.substr(0, page.lastIndexOf('.'));
                }
            }
        }
    navHighlight('.mainNav ul li a', 'index.html', 'current'); /* menu link selector, home page, highlight class */
    }
)();

function OpenRows(clickedRow)//rows id passed in from database management.php
{
    var elements = document.querySelectorAll(".tableRowButton,.tableRow");

    for(var i = 0;i < elements.length ;i++)
    {
        if(clickedRow == elements[i].id)
        {
            elements.item(i).classList.toggle("hidden");

        }
            
    }
    

}