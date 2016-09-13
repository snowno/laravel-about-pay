$(function(){
    $('.user_mes').click(function(){
        $(this).children('div').show();
    })
    $('.dropdown-toggle').hover(function(){
        $('.usermes').show();
    })

    $('.scan').mouseover(function(){
        $('.mark').show();
    })
    $('.scan').mouseout(function(){
        $('.mark').hide();
    })
})