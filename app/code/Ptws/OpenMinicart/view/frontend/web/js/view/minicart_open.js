/*define(["jquery/ui","jquery"], function(Component, $){

setTimeout( function()  {
		if (jQuery('.message-success.success.message').length > 0) {
			jQuery('[data-block="minicart"]').find('[data-role="dropdownDialog"]').dropdownDialog("open");       

		}
	}, 1000);

	/*return function(config, element){
		var minicart = $(element);
		minicart.on('contentLoading', function () {
			minicart.on('contentUpdated', function () {
				minicart.find('[data-role="dropdownDialog"]').dropdownDialog("open");
				 setTimeout(function() {
                $('[data-block="minicart"]').find('[data-role="dropdownDialog"]').dropdownDialog("close");
                }, 5000);
			});
		});
	}
});*/


define(["jquery/ui","jquery"], function(Component, $){
    return function(config, element){
        var minicart = $(element);
        minicart.on('contentLoading', function () {
            minicart.on('contentUpdated', function () {
                minicart.find('[data-role="dropdownDialog"]').dropdownDialog("open");
            });
        });
    }
});