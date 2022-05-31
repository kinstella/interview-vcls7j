
$(function () {

    var dialogDiv = $(document.createElement('div'));
    dialogDiv.dialog({
        modal: true,
        autoOpen: false,
        height: 160,
        width: 300,
        open: function () {
            var contactUrl = '/contacts/' + $(this).data('contactId');
            $(this).load(contactUrl);
        },
        close : function() {
            $(this).html(''); // clear content on close
         }
    });

    $(".show-info-btn").on('click', function (e) {
        e.preventDefault();
        var contactId = $(this).data('contactid');
        dialogDiv.data('contactId', contactId).dialog('open');
    });

});
