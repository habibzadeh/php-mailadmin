/**
 * Created by Habibzadeh on 12/27/2014.
 */
jQuery(function($){
    $(document).ready(function(){
        $('.MenuTitle').click(function(){
           $(this).next().toggle();
        });
    });
});
function ShowAlert(id){
    $(document).ready(function(){
        $(id).css('display','block');
    });
}