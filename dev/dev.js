/**
 * Created by melodic on 05.04.2016.
 */

$(function(){

    $('.control-block').on('click',function(){
        //if ($('#myWizard').hasClass('slideInLeft')){
        //    $('#myWizard').removeClass('animated slideInLeft').addClass('animated slideOutLeft');
        //}else{
        //    $('#myWizard').removeClass('animated slideOutLeft').addClass('animated slideInLeft');
        //}
    });


    $('select').on('changed.bs.select', function (e) {
        $(e.target).selectpicker('toggle');
    });

    $('#summernote').summernote();

    $('.tab-pane').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            e.preventDefault();
        }
    });

    $('.next').click(function(e){
        //$('form').valid();
        var nextId = $(this).parents('.tab-pane').next().attr("id");
        $('[href=#'+nextId+']').tab('show');
        e.preventDefault();
        return false;
    });

    $('.back').click(function(){

        var prevId = $(this).parents('.tab-pane').prev().attr("id");
        $('[href=#'+prevId+']').tab('show');
        return false;

    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        //update progress
        var step = $(e.target).data('step');
        var percent = (parseInt(step) / 4) * 100;

        $('.progress-bar').css({width: percent + '%'});
        $('.progress-bar').text("Step " + step + " of 4");

        //e.relatedTarget // previous tab

    })

    $('.first').click(function(){

        $('#myWizard a:first').tab('show')

    })

    $(".nav li.disabled a").click(function() {
        return false;
    });
});
