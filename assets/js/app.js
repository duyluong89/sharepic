$(function(){
    $('.sidebar_menu_item').on('click', function(e){
        e.preventDefault();
        i = $(this);
        parent = i.attr('data-parent');
        target = i.attr('href');

        if ($(parent + ' ' + target).is(':hidden')) {
            $(parent + ' .panel-collapse').hide();
            $(parent + ' ' + target).show();
            $('.sidebar_menu_item').removeClass('active');
            i.addClass('active');
        }
    });
});