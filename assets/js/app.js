import '../css/app.css';
import $ from 'jquery';
import "popper.js";
import 'bootstrap';
import 'bootstrap-datepicker';

$(document).ready(function () {
            $('.add-another-collection-widget').click(function (e) {
                var list = jQuery(jQuery(this).attr('data-list'));
                // Try to find the counter of the list or use the length of the list
                var counter = list.data('widget-counter') | list.children().length;
                // grab the prototype template
                var newWidget = list.attr('data-prototype');
                // replace the "_name_" used in the id and name of the prototype
                // with a number that's unique to your emails
                // end name attribute looks like name="contact[emails][2]"
                newWidget = newWidget.replace(/__name__/g, counter);
                // Increase the counter
                counter++;
                // And store it, the length cannot be used if deleting widgets is allowed
                list.data('widget-counter', counter);
                // create a new list element and add it to the list
                var newElem = $(list.attr('data-widget-tickets')).html(newWidget);
                newElem.appendTo(list);
                $('.form-check-input').mouseup (function(){
                    alert('Si vous cohez cette case, vous devez présenter un justificatif pour entrer au Musée: Ça peut-être votre étudiant, votre carte de militaire ou d\'employé(e) du Musée etc...');
                });
                $('.js-datepicker').datepicker({
                    format: 'yyyy-mm-dd',
              }); 
      });
  $('.remove').click(function(e){
    $('li').remove();
});});

$(document).ready(function() {
        // you may need to change this code if you are not using Bootstrap Datepicker
        $('.js-datepicker').datepicker({
              format: 'yyyy-mm-dd',
              //dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
              startDate: '-d',
               daysOfWeekDisabled: [0, 2]
        });
});