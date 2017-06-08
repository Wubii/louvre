
$('#appbundle_mborder_visiteDate').datepicker({
    
    dateFormat: 'dd/mm/yy',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    firstDay: 1 ,
    
    beforeShowDay: function(date) {
      var day = date.getDay();
      var disabledSpecificDays = ["05-01", "11-01", "12-25"];
      var string = jQuery.datepicker.formatDate("mm-dd", date);

      return [(day != 0) && (day != 2) && (disabledSpecificDays.indexOf(string) == -1)];
    },

    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    minDate: 0,
    showAnim: "slide"
});

$.datepicker.regional['fr'];

var disabledSpecificDays = ["2017/05/1", "2017/11/1", "2017/12/25"]; 