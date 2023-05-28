$(document).ready(function(){
    $('input[name="daterange"]').daterangepicker();
    //$('#reportrange span').html(moment().subtract(29, 'days').format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'));

    $('#reportrange').daterangepicker({
        format: 'DD.MM.YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01.01.2000',
        maxDate: '31.12.2040',
        //dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,        
        ranges: {
            'Сегодня': [moment(), moment()],
            'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
            'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
            'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
            'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },        
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'OK',
            cancelLabel: 'Отмена',
            fromLabel: 'Период с',
            toLabel: 'По',
            customRangeLabel: 'Выбор',
            daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            firstDay: 1
        }
    }, function(start, end, label) {
        $('#reportrange input[name=date_begin]').val(start.format('DD.MM.YYYY'));
        $('#reportrange input[name=date_end]').val(end.format('DD.MM.YYYY'));                
        //console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
    });
});    